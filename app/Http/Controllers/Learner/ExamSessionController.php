<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Certification;
use App\Models\ExamAnswer;
use App\Models\ExamAttempt;
use App\Models\ExamAttemptQuestion;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamSessionController extends Controller
{
    /**
     * Display a listing of exam sessions for the authenticated learner.
     */
    public function index(Request $request)
    {
        $learner = Auth::guard('learner')->user();
        
        $query = ExamAttempt::where('learner_id', $learner->id)
            ->with(['certification', 'learner']);
        
        // Filter by exam type
        if ($request->filled('exam_type')) {
            $query->where('exam_type', $request->exam_type);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by certification
        if ($request->filled('certification_id')) {
            $query->where('certification_id', $request->certification_id);
        }
        
        $examSessions = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get statistics
        $stats = [
            'total' => ExamAttempt::where('learner_id', $learner->id)->count(),
            'completed' => ExamAttempt::where('learner_id', $learner->id)->where('status', 'completed')->count(),
            'in_progress' => ExamAttempt::where('learner_id', $learner->id)->where('status', 'in_progress')->count(),
            'average_score' => ExamAttempt::where('learner_id', $learner->id)
                ->where('status', 'completed')
                ->avg('score_percentage') ?? 0,
        ];
        
        // Get certifications for filter
        $certifications = Certification::where('is_active', true)->orderBy('name')->get();
        
        return view('learner.exams.index', compact('examSessions', 'stats', 'certifications'));
    }

    /**
     * Show the details of an exam session before starting.
     */
    public function show($id)
    {
        $learner = Auth::guard('learner')->user();
        
        $examSession = ExamAttempt::where('id', $id)
            ->where('learner_id', $learner->id)
            ->with(['certification', 'learner'])
            ->firstOrFail();
        
        // Get previous attempts for this certification and exam type
        $previousAttempts = ExamAttempt::where('learner_id', $learner->id)
            ->where('certification_id', $examSession->certification_id)
            ->where('exam_type', $examSession->exam_type)
            ->where('id', '!=', $id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('learner.exams.show', compact('examSession', 'previousAttempts'));
    }

    /**
     * Start an exam session.
     */
    public function start($id)
    {
        $learner = Auth::guard('learner')->user();
        
        $examSession = ExamAttempt::where('id', $id)
            ->where('learner_id', $learner->id)
            ->where('status', 'created')
            ->firstOrFail();
        
        DB::beginTransaction();
        try {
            // Update status and start time
            $examSession->update([
                'status' => 'in_progress',
                'started_at' => now(),
            ]);
            
            // Generate exam questions if not already generated
            if ($examSession->attemptQuestions()->count() === 0) {
                $this->generateExamQuestions($examSession);
            }
            
            DB::commit();
            
            return redirect()->route('learner.exams.take', $examSession->id)
                ->with('success', 'Exam started successfully. Good luck!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to start exam. Please try again.');
        }
    }

    /**
     * Display the exam taking interface.
     */
    public function take($id)
    {
        $learner = Auth::guard('learner')->user();
        
        $examSession = ExamAttempt::where('id', $id)
            ->where('learner_id', $learner->id)
            ->whereIn('status', ['in_progress'])
            ->with(['certification', 'attemptQuestions.question.answers'])
            ->firstOrFail();
        
        // Calculate remaining time
        $elapsedMinutes = $examSession->started_at->diffInMinutes(now());
        $remainingMinutes = max(0, $examSession->time_limit_minutes - $elapsedMinutes);
        
        // Check if time has expired
        if ($remainingMinutes <= 0) {
            $this->submitExam($examSession);
            return redirect()->route('learner.exams.results', $examSession->id)
                ->with('warning', 'Time expired. Your exam has been automatically submitted.');
        }
        
        // Get all questions with their answers
        $questions = $examSession->attemptQuestions()
            ->with(['question.answers', 'question.topic.domain'])
            ->ordered()
            ->get();
        
        // Get answered question IDs
        $answeredQuestionIds = $examSession->examAnswers()->pluck('question_id')->toArray();
        
        return view('learner.exams.take', compact('examSession', 'questions', 'answeredQuestionIds', 'remainingMinutes'));
    }

    /**
     * Get a specific question via AJAX.
     */
    public function getQuestion($attemptId, $questionNumber)
    {
        $learner = Auth::guard('learner')->user();
        
        $examSession = ExamAttempt::where('id', $attemptId)
            ->where('learner_id', $learner->id)
            ->firstOrFail();
        
        $attemptQuestion = $examSession->attemptQuestions()
            ->where('order_number', $questionNumber)
            ->with(['question.answers', 'question.topic.domain'])
            ->first();
        
        if (!$attemptQuestion) {
            return response()->json(['error' => 'Question not found'], 404);
        }
        
        // Get the answer if already answered
        $examAnswer = ExamAnswer::where('attempt_id', $attemptId)
            ->where('question_id', $attemptQuestion->question_id)
            ->first();
        
        return response()->json([
            'question' => $attemptQuestion->question,
            'is_flagged' => $attemptQuestion->is_flagged,
            'selected_answer_id' => $examAnswer->selected_answer_id ?? null,
        ]);
    }

    /**
     * Submit an answer for a question via AJAX.
     */
    public function submitAnswer(Request $request, $id)
    {
        $request->validate([
            'question_id' => 'required|uuid',
            'answer_id' => 'required|uuid',
        ]);
        
        $learner = Auth::guard('learner')->user();
        
        $examSession = ExamAttempt::where('id', $id)
            ->where('learner_id', $learner->id)
            ->where('status', 'in_progress')
            ->firstOrFail();
        
        // Get the question and answer
        $question = Question::findOrFail($request->question_id);
        $answer = Answer::findOrFail($request->answer_id);
        
        // Check if answer belongs to the question
        if ($answer->question_id !== $question->id) {
            return response()->json(['error' => 'Invalid answer for this question'], 400);
        }
        
        // Save or update the exam answer
        ExamAnswer::updateOrCreate(
            [
                'attempt_id' => $examSession->id,
                'question_id' => $question->id,
            ],
            [
                'selected_answer_id' => $answer->id,
                'is_correct' => $answer->is_correct,
                'answered_at' => now(),
            ]
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Answer saved successfully',
        ]);
    }

    /**
     * Toggle flag on a question via AJAX.
     */
    public function flagQuestion($attemptId, $questionId)
    {
        $learner = Auth::guard('learner')->user();
        
        $examSession = ExamAttempt::where('id', $attemptId)
            ->where('learner_id', $learner->id)
            ->where('status', 'in_progress')
            ->firstOrFail();
        
        $attemptQuestion = ExamAttemptQuestion::where('attempt_id', $attemptId)
            ->where('question_id', $questionId)
            ->firstOrFail();
        
        $attemptQuestion->update([
            'is_flagged' => !$attemptQuestion->is_flagged,
        ]);
        
        return response()->json([
            'success' => true,
            'is_flagged' => $attemptQuestion->is_flagged,
        ]);
    }

    /**
     * Submit the entire exam.
     */
    public function submit(Request $request, $id)
    {
        $learner = Auth::guard('learner')->user();
        
        $examSession = ExamAttempt::where('id', $id)
            ->where('learner_id', $learner->id)
            ->where('status', 'in_progress')
            ->firstOrFail();
        
        $this->submitExam($examSession);
        
        return redirect()->route('learner.exams.results', $examSession->id)
            ->with('success', 'Exam submitted successfully!');
    }

    /**
     * Display exam results.
     */
    public function results($id)
    {
        $learner = Auth::guard('learner')->user();
        
        $examSession = ExamAttempt::where('id', $id)
            ->where('learner_id', $learner->id)
            ->where('status', 'completed')
            ->with(['certification', 'examAnswers.question.topic.domain', 'examAnswers.answer'])
            ->firstOrFail();
        
        // Calculate domain performance
        $domainPerformance = $this->calculateDomainPerformance($examSession);
        
        // Get weak and strong domains
        $weakDomains = collect($domainPerformance)->filter(fn($d) => $d['percentage'] < 60)->sortBy('percentage')->take(3);
        $strongDomains = collect($domainPerformance)->filter(fn($d) => $d['percentage'] >= 80)->sortByDesc('percentage')->take(3);
        
        // Get all questions with answers for review
        $questions = $examSession->attemptQuestions()
            ->with(['question.answers', 'question.topic.domain'])
            ->ordered()
            ->get()
            ->map(function ($attemptQuestion) use ($examSession) {
                $examAnswer = $examSession->examAnswers()
                    ->where('question_id', $attemptQuestion->question_id)
                    ->first();
                
                return [
                    'attempt_question' => $attemptQuestion,
                    'question' => $attemptQuestion->question,
                    'exam_answer' => $examAnswer,
                    'is_correct' => $examAnswer ? $examAnswer->is_correct : false,
                ];
            });
        
        // Prepare chart data
        $chartData = $this->prepareChartData($examSession, $domainPerformance);
        
        // Prepare progress trend data (only for benchmark exams)
        $progressTrendData = null;
        if ($examSession->exam_type === 'benchmark') {
            $progressTrendData = $this->prepareProgressTrendData($learner, $examSession->certification_id);
        }
        
        return view('learner.exams.results', compact('examSession', 'domainPerformance', 'weakDomains', 'strongDomains', 'questions', 'chartData', 'progressTrendData'));
    }

    /**
     * Display exam history with analytics.
     */
    public function history(Request $request)
    {
        $learner = Auth::guard('learner')->user();
        
        $query = ExamAttempt::where('learner_id', $learner->id)
            ->where('status', 'completed')
            ->with(['certification']);
        
        // Filter by certification
        if ($request->filled('certification_id')) {
            $query->where('certification_id', $request->certification_id);
        }
        
        // Filter by exam type
        if ($request->filled('exam_type')) {
            $query->where('exam_type', $request->exam_type);
        }
        
        // Filter by pass/fail
        if ($request->filled('passed')) {
            $query->where('passed', $request->passed === '1');
        }
        
        $attempts = $query->orderBy('completed_at', 'desc')->paginate(15);
        
        // Get statistics
        $stats = [
            'total_attempts' => ExamAttempt::where('learner_id', $learner->id)->where('status', 'completed')->count(),
            'average_score' => ExamAttempt::where('learner_id', $learner->id)->where('status', 'completed')->avg('score_percentage') ?? 0,
            'pass_rate' => $this->calculatePassRate($learner->id),
            'total_time' => ExamAttempt::where('learner_id', $learner->id)->where('status', 'completed')->sum('duration_minutes') ?? 0,
        ];
        
        // Get certifications for filter
        $certifications = Certification::where('is_active', true)->orderBy('name')->get();
        
        // Get score progression data for chart
        $scoreProgression = ExamAttempt::where('learner_id', $learner->id)
            ->where('status', 'completed')
            ->orderBy('completed_at')
            ->limit(20)
            ->get()
            ->map(function ($attempt) {
                return [
                    'date' => $attempt->completed_at->format('M d'),
                    'score' => $attempt->score_percentage,
                    'certification' => $attempt->certification->name,
                ];
            });
        
        // Calculate additional statistics for the view
        $completedExams = $attempts;
        $passedExams = ExamAttempt::where('learner_id', $learner->id)
            ->where('status', 'completed')
            ->where('passed', true)
            ->count();
        $averageScore = $stats['average_score'];
        $bestScore = ExamAttempt::where('learner_id', $learner->id)
            ->where('status', 'completed')
            ->max('score_percentage') ?? 0;
        
        return view('learner.exams.history', compact(
            'attempts',
            'completedExams',
            'passedExams',
            'averageScore',
            'bestScore',
            'stats',
            'certifications',
            'scoreProgression'
        ));
    }

    /**
     * Generate exam questions for an attempt.
     */
    private function generateExamQuestions(ExamAttempt $examSession)
    {
        $certification = $examSession->certification;
        $totalQuestions = $examSession->total_questions;
        
        // Get all questions for this certification
        $availableQuestions = Question::whereHas('topic.domain', function ($query) use ($certification) {
            $query->where('certification_id', $certification->id);
        })
            ->where('status', 'approved')
            ->inRandomOrder()
            ->limit($totalQuestions)
            ->get();
        
        // Create exam attempt questions
        foreach ($availableQuestions as $index => $question) {
            ExamAttemptQuestion::create([
                'attempt_id' => $examSession->id,
                'question_id' => $question->id,
                'order_number' => $index + 1,
                'is_flagged' => false,
                'time_spent_seconds' => 0,
            ]);
        }
    }

    /**
     * Submit exam and calculate scores.
     */
    private function submitExam(ExamAttempt $examSession)
    {
        $totalQuestions = $examSession->total_questions;
        $correctAnswers = $examSession->examAnswers()->where('is_correct', true)->count();
        $scorePercentage = ($correctAnswers / $totalQuestions) * 100;
        $passed = $scorePercentage >= $examSession->passing_score;
        
        // Calculate duration
        $durationMinutes = $examSession->started_at->diffInMinutes(now());
        
        $examSession->update([
            'status' => 'completed',
            'completed_at' => now(),
            'correct_answers' => $correctAnswers,
            'score_percentage' => round($scorePercentage, 2),
            'passed' => $passed,
            'duration_minutes' => $durationMinutes,
        ]);
    }

    /**
     * Prepare progress trend data for multiple attempts.
     */
    private function prepareProgressTrendData($learner, $certificationId)
    {
        // Get all completed benchmark attempts for this certification
        $attempts = ExamAttempt::where('learner_id', $learner->id)
            ->where('certification_id', $certificationId)
            ->where('exam_type', 'benchmark')
            ->where('status', 'completed')
            ->orderBy('completed_at', 'asc')
            ->get();
        
        // Need at least 2 attempts to show trend
        if ($attempts->count() < 2) {
            return null;
        }
        
        $labels = [];
        $overallScores = [];
        $domainScores = [];
        
        foreach ($attempts as $index => $attempt) {
            // Label: "Attempt 1", "Attempt 2", etc.
            $labels[] = 'Attempt ' . ($index + 1);
            
            // Overall score
            $overallScores[] = round($attempt->score, 1);
            
            // Domain scores
            $domainPerf = $this->calculateDomainPerformance($attempt);
            foreach ($domainPerf as $domain) {
                $domainName = $domain['domain']->name;
                if (!isset($domainScores[$domainName])) {
                    $domainScores[$domainName] = [];
                }
                $domainScores[$domainName][] = round($domain['percentage'], 1);
            }
        }
        
        return [
            'labels' => $labels,
            'overall_scores' => $overallScores,
            'domain_scores' => $domainScores,
            'passing_score' => $attempts->first()->certification->passing_score,
            'attempt_count' => $attempts->count(),
        ];
    }
    
    /**
     * Prepare chart data for visualization.
     */
    private function prepareChartData($examSession, $domainPerformance)
    {
        // Domain Radar Chart Data
        $domainLabels = [];
        $domainScores = [];
        $domainColors = [
            '#e74c3c', // Red
            '#3498db', // Blue
            '#9b59b6', // Purple
            '#f39c12', // Orange
            '#1abc9c', // Turquoise
            '#34495e', // Dark Gray
        ];
        
        foreach ($domainPerformance as $index => $domain) {
            $domainLabels[] = $domain['domain']->name;
            $domainScores[] = round($domain['percentage'], 1);
        }
        
        // Score Distribution Doughnut Data
        $totalQuestions = $examSession->total_questions;
        $correctAnswers = $examSession->correct_answers;
        $incorrectAnswers = $examSession->total_questions - $examSession->correct_answers - ($totalQuestions - $examSession->examAnswers->count());
        $unanswered = $totalQuestions - $examSession->examAnswers->count();
        
        return [
            'domain_radar' => [
                'labels' => $domainLabels,
                'scores' => $domainScores,
                'passing' => $examSession->passing_score,
            ],
            'score_distribution' => [
                'labels' => ['Correct', 'Incorrect', 'Unanswered'],
                'data' => [$correctAnswers, $incorrectAnswers, $unanswered],
                'colors' => ['#198754', '#dc3545', '#6c757d'],
            ],
            'domain_colors' => array_slice($domainColors, 0, count($domainPerformance)),
        ];
    }
    
    /**
     * Calculate domain performance.
     */
    private function calculateDomainPerformance(ExamAttempt $examSession)
    {
        $domainPerformance = [];
        
        $examAnswers = $examSession->examAnswers()->with('question.topic.domain')->get();
        
        $groupedByDomain = $examAnswers->groupBy(function ($answer) {
            return $answer->question->topic->domain->id;
        });
        
        foreach ($groupedByDomain as $domainId => $answers) {
            $domain = $answers->first()->question->topic->domain;
            $total = $answers->count();
            $correct = $answers->where('is_correct', true)->count();
            $percentage = ($correct / $total) * 100;
            
            $domainPerformance[] = [
                'domain' => $domain,
                'total' => $total,
                'correct' => $correct,
                'percentage' => round($percentage, 2),
            ];
        }
        
        return collect($domainPerformance)->sortByDesc('percentage')->values()->all();
    }

    /**
     * Calculate pass rate for a learner.
     */
    private function calculatePassRate($learnerId)
    {
        $totalCompleted = ExamAttempt::where('learner_id', $learnerId)->where('status', 'completed')->count();
        
        if ($totalCompleted === 0) {
            return 0;
        }
        
        $totalPassed = ExamAttempt::where('learner_id', $learnerId)->where('status', 'completed')->where('passed', true)->count();
        
        return round(($totalPassed / $totalCompleted) * 100, 2);
    }
}

