<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\Domain;
use App\Models\ExamAttempt;
use App\Models\PracticeSession;
use App\Models\PracticeAnswer;
use App\Models\Question;
use App\Models\Topic;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PracticeSessionController extends Controller
{
    /**
     * Get practice recommendations based on benchmark results
     * Route: GET /learner/practice/recommendations/{certification}
     */
    public function recommendations($certificationId)
    {
        $learner = Auth::guard('learner')->user();
        
        $certification = Certification::with(['domains'])->findOrFail($certificationId);
        
        // Check if learner is enrolled
        $enrollment = $certification->learners()->where('learner_id', $learner->id)->first();
        if (!$enrollment) {
            return redirect()->route('learner.certifications.index')
                ->with('error', 'You must enroll in this certification first.');
        }
        
        // Get latest completed benchmark
        $benchmark = ExamAttempt::where('learner_id', $learner->id)
            ->where('certification_id', $certificationId)
            ->where('exam_type', 'benchmark')
            ->where('status', 'completed')
            ->latest('completed_at')
            ->first();
        
        if (!$benchmark) {
            return redirect()->route('learner.benchmark.explain', $certificationId)
                ->with('warning', 'Please complete the benchmark exam first to get personalized practice recommendations.');
        }
        
        // Calculate domain performance
        $domainPerformance = $this->calculateDomainPerformance($benchmark);
        
        // Categorize domains
        $weakDomains = $domainPerformance->filter(function($domain) {
            return $domain['percentage'] < 60;
        })->sortBy('percentage');
        
        $moderateDomains = $domainPerformance->filter(function($domain) {
            return $domain['percentage'] >= 60 && $domain['percentage'] < 80;
        })->sortBy('percentage');
        
        $strongDomains = $domainPerformance->filter(function($domain) {
            return $domain['percentage'] >= 80;
        })->sortByDesc('percentage');
        
        // Get all domains with topics for "By Domain" and "By Topic" tabs
        $allDomains = $certification->domains()->with(['topics' => function($query) {
            $query->withCount(['questions' => function($q) {
                $q->where('status', 'approved');
            }]);
        }])->get();
        
        // Add question counts to domains
        foreach ($allDomains as $domain) {
            $domain->questions_count = Question::whereHas('topic', function($query) use ($domain) {
                $query->where('domain_id', $domain->id);
            })->where('status', 'approved')->count();
        }
        
        return view('learner.practice.recommendations', compact(
            'certification',
            'benchmark',
            'weakDomains',
            'moderateDomains',
            'strongDomains',
            'allDomains',
            'domainPerformance'
        ));
    }
    
    /**
     * Create a new practice session
     * Route: POST /learner/practice/create
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'certification_id' => 'required|exists:certifications,id',
            'domain_id' => 'nullable|exists:domains,id',
            'topic_id' => 'nullable|exists:topics,id',
            'question_count' => 'required|integer|min:5|max:50',
            'practice_mode' => 'required|in:recommended,domain,topic,quick,mixed'
        ]);
        
        $learner = Auth::guard('learner')->user();
        
        // Check enrollment
        $certification = Certification::findOrFail($validated['certification_id']);
        $enrollment = $certification->learners()->where('learner_id', $learner->id)->first();
        
        if (!$enrollment) {
            return redirect()->route('learner.certifications.index')
                ->with('error', 'You must enroll in this certification first.');
        }
        
        DB::beginTransaction();
        try {
            // Generate question set based on selection
            $questions = $this->generateQuestionSet(
                $validated['certification_id'],
                $validated['domain_id'] ?? null,
                $validated['topic_id'] ?? null,
                $validated['question_count'],
                $validated['practice_mode']
            );
            
            if ($questions->count() < 5) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Not enough questions available for this practice session. Please try a different selection.');
            }
            
            // Create practice session
            $session = PracticeSession::create([
                'id' => Str::uuid(),
                'learner_id' => $learner->id,
                'certification_id' => $validated['certification_id'],
                'domain_id' => $validated['domain_id'],
                'total_questions' => $questions->count(),
                'completed' => false,
            ]);
            
            // Attach questions to session with order
            $order = 1;
            foreach ($questions as $question) {
                DB::table('practice_session_questions')->insert([
                    'practice_session_id' => $session->id,
                    'question_id' => $question->id,
                    'question_order' => $order++,
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('learner.practice.take', $session->id)
                ->with('success', 'Practice session created! Let\'s start learning.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to create practice session. Please try again.');
        }
    }
    
    /**
     * Calculate domain performance from benchmark
     */
    private function calculateDomainPerformance($benchmark)
    {
        // Get all questions from the benchmark with their domains
        $questions = $benchmark->attemptQuestions()
            ->with(['question.topic.domain', 'examAnswer'])
            ->get();
        
        // Group by domain and calculate performance
        $domainStats = [];
        
        foreach ($questions as $attemptQuestion) {
            $domain = $attemptQuestion->question->topic->domain;
            $domainId = $domain->id;
            
            if (!isset($domainStats[$domainId])) {
                $domainStats[$domainId] = [
                    'id' => $domain->id,
                    'name' => $domain->name,
                    'description' => $domain->description,
                    'total' => 0,
                    'correct' => 0,
                    'percentage' => 0,
                    'questions_count' => Question::whereHas('topic', function($query) use ($domain) {
                        $query->where('domain_id', $domain->id);
                    })->where('status', 'approved')->count(),
                ];
            }
            
            $domainStats[$domainId]['total']++;
            
            // Check if answer was correct
            if ($attemptQuestion->examAnswer && $attemptQuestion->examAnswer->is_correct) {
                $domainStats[$domainId]['correct']++;
            }
        }
        
        // Calculate percentages
        foreach ($domainStats as $domainId => $stats) {
            if ($stats['total'] > 0) {
                $domainStats[$domainId]['percentage'] = round(($stats['correct'] / $stats['total']) * 100, 1);
            }
        }
        
        return collect($domainStats);
    }
    
    /**
     * Generate question set for practice
     */
    private function generateQuestionSet($certificationId, $domainId, $topicId, $count, $mode)
    {
        $query = Question::where('status', 'approved');
        
        if ($topicId) {
            // Topic-specific practice
            $query->where('topic_id', $topicId);
        } elseif ($domainId) {
            // Domain-specific practice
            $query->whereHas('topic', function($q) use ($domainId) {
                $q->where('domain_id', $domainId);
            });
        } else {
            // Certification-wide practice
            $query->whereHas('topic.domain', function($q) use ($certificationId) {
                $q->where('certification_id', $certificationId);
            });
        }
        
        // Get questions randomly
        return $query->with(['answers', 'topic.domain'])
            ->inRandomOrder()
            ->limit($count)
            ->get();
    }
    
    /**
     * Display the practice session interface.
     */
    public function take($id)
    {
        $learner = Auth::guard('learner')->user();
        
        $session = PracticeSession::where('id', $id)
            ->where('learner_id', $learner->id)
            ->with(['certification', 'questions.answers', 'questions.topic.domain'])
            ->firstOrFail();
        
        // Check if session is already completed
        if ($session->completed) {
            return redirect()->route('learner.practice.results', $session->id);
        }
        
        // Get answered questions
        $answeredQuestions = PracticeAnswer::where('session_id', $session->id)
            ->pluck('question_id')
            ->toArray();
        
        return view('learner.practice.take', compact('session', 'answeredQuestions'));
    }
    
    /**
     * Submit an answer for a practice question (AJAX).
     */
    public function submitAnswer(Request $request, $id)
    {
        $request->validate([
            'question_id' => 'required|uuid',
            'answer_id' => 'required|uuid',
        ]);
        
        $learner = Auth::guard('learner')->user();
        
        $session = PracticeSession::where('id', $id)
            ->where('learner_id', $learner->id)
            ->firstOrFail();
        
        // Get the question and answer
        $question = Question::with(['answers', 'topic.domain'])->findOrFail($request->question_id);
        $selectedAnswer = Answer::findOrFail($request->answer_id);
        
        // Check if answer belongs to the question
        if ($selectedAnswer->question_id !== $question->id) {
            return response()->json(['error' => 'Invalid answer for this question'], 400);
        }
        
        // Get the correct answer
        $correctAnswer = $question->answers->where('is_correct', true)->first();
        
        // Save or update the practice answer
        $practiceAnswer = PracticeAnswer::updateOrCreate(
            [
                'session_id' => $session->id,
                'question_id' => $question->id,
            ],
            [
                'selected_answer_id' => $selectedAnswer->id,
                'is_correct' => $selectedAnswer->is_correct,
                'answered_at' => now(),
            ]
        );
        
        // Return immediate feedback
        return response()->json([
            'success' => true,
            'is_correct' => $selectedAnswer->is_correct,
            'correct_answer_id' => $correctAnswer->id,
            'explanation' => $question->explanation,
            'domain' => $question->topic->domain->name,
            'topic' => $question->topic->name,
        ]);
    }
    
    /**
     * Complete the practice session.
     */
    public function complete($id)
    {
        $learner = Auth::guard('learner')->user();
        
        $session = PracticeSession::where('id', $id)
            ->where('learner_id', $learner->id)
            ->firstOrFail();
        
        // Calculate results
        $totalQuestions = $session->total_questions;
        $answeredCount = PracticeAnswer::where('session_id', $session->id)->count();
        $correctCount = PracticeAnswer::where('session_id', $session->id)
            ->where('is_correct', true)
            ->count();
        
        $scorePercentage = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100, 1) : 0;
        
        // Update session
        $session->update([
            'completed' => true,
            'completed_at' => now(),
            'score_percentage' => $scorePercentage,
        ]);
        
        return redirect()->route('learner.practice.results', $session->id);
    }
    
    /**
     * Show practice session results
     */
    public function results($id)
    {
        $learner = Auth::guard('learner')->user();
        
        $session = PracticeSession::with([
            'certification',
            'questions.answers',
            'questions.topic.domain',
            'practiceAnswers'
        ])
            ->where('id', $id)
            ->where('learner_id', $learner->id)
            ->firstOrFail();
        
        // Calculate statistics
        $totalQuestions = $session->total_questions;
        $correctCount = $session->practiceAnswers->where('is_correct', true)->count();
        $incorrectCount = $session->practiceAnswers->where('is_correct', false)->count();
        
        // Calculate domain performance
        $domainPerformance = collect();
        $domains = $session->questions->pluck('topic.domain')->unique('id');
        
        foreach ($domains as $domain) {
            $domainQuestions = $session->questions->filter(function($q) use ($domain) {
                return $q->topic->domain_id === $domain->id;
            });
            
            $domainAnswers = $session->practiceAnswers->filter(function($a) use ($domainQuestions) {
                return $domainQuestions->pluck('id')->contains($a->question_id);
            });
            
            $domainCorrect = $domainAnswers->where('is_correct', true)->count();
            $domainTotal = $domainQuestions->count();
            
            if ($domainTotal > 0) {
                $domainPerformance->push((object)[
                    'name' => $domain->name,
                    'correct' => $domainCorrect,
                    'total' => $domainTotal,
                    'percentage' => ($domainCorrect / $domainTotal) * 100
                ]);
            }
        }
        
        // Identify weak domains (< 60%)
        $weakDomains = $domainPerformance->filter(function($d) {
            return $d->percentage < 60;
        })->sortBy('percentage');
        
        return view('learner.practice.results', compact(
            'session',
            'correctCount',
            'incorrectCount',
            'domainPerformance',
            'weakDomains'
        ));
    }
    
    /**
     * Display practice session history.
     */
    public function history()
    {
        $learner = Auth::guard('learner')->user();
        
        $sessions = PracticeSession::where('learner_id', $learner->id)
            ->where('completed', true)
            ->with('certification')
            ->orderBy('completed_at', 'desc')
            ->paginate(20);
        
        // Calculate statistics
        $stats = [
            'total_sessions' => PracticeSession::where('learner_id', $learner->id)
                ->where('completed', true)
                ->count(),
            'total_questions' => PracticeAnswer::whereHas('practiceSession', function($q) use ($learner) {
                $q->where('learner_id', $learner->id);
            })->count(),
            'average_score' => PracticeSession::where('learner_id', $learner->id)
                ->where('completed', true)
                ->avg('score_percentage') ?? 0,
            'total_correct' => PracticeAnswer::whereHas('practiceSession', function($q) use ($learner) {
                $q->where('learner_id', $learner->id);
            })->where('is_correct', true)->count(),
        ];
        
        return view('learner.practice.history', compact('sessions', 'stats'));
    }
}
