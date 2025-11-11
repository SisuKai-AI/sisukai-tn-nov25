<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\ExamAttempt;
use App\Models\ExamAttemptQuestion;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BenchmarkController extends Controller
{
    /**
     * Show benchmark explanation page
     */
    public function explain($certificationId)
    {
        $learner = auth('learner')->user();
        
        $certification = Certification::with(['domains'])->findOrFail($certificationId);
        
        // Check if learner is enrolled
        $enrollment = $certification->learners()->where('learner_id', $learner->id)->first();
        if (!$enrollment) {
            return redirect()->route('learner.certifications.index')
                ->with('error', 'You must enroll in this certification first.');
        }
        
        // Check if benchmark already exists
        $existingBenchmark = ExamAttempt::where('learner_id', $learner->id)
            ->where('certification_id', $certificationId)
            ->where('exam_type', 'benchmark')
            ->latest()
            ->first();
        
        return view('learner.benchmark.explain', [
            'certification' => $certification,
            'enrollment' => $enrollment,
            'existingBenchmark' => $existingBenchmark,
        ]);
    }
    
    /**
     * Create a new benchmark exam attempt
     */
    public function create(Request $request, $certificationId)
    {
        $learner = auth('learner')->user();
        
        $certification = Certification::with(['domains'])->findOrFail($certificationId);
        
        // Check if learner is enrolled
        $enrollment = $certification->learners()->where('learner_id', $learner->id)->first();
        if (!$enrollment) {
            return redirect()->route('learner.certifications.index')
                ->with('error', 'You must enroll in this certification first.');
        }
        
        // Check if there's already an in-progress benchmark
        $inProgressBenchmark = ExamAttempt::where('learner_id', $learner->id)
            ->where('certification_id', $certificationId)
            ->where('exam_type', 'benchmark')
            ->where('status', 'in_progress')
            ->first();
        
        if ($inProgressBenchmark) {
            return redirect()->route('learner.exams.take', $inProgressBenchmark->id)
                ->with('info', 'Resuming your in-progress benchmark exam.');
        }
        
        // Get total question count for benchmark (from certification config or default)
        $totalQuestions = $certification->exam_questions ?? 45;
        $timeLimit = $certification->exam_duration ?? 90;
        $passingScore = $certification->passing_score ?? 70;
        
        // Get questions for benchmark (distributed across domains)
        $domains = $certification->domains;
        $questionsPerDomain = ceil($totalQuestions / $domains->count());
        
        $selectedQuestions = collect();
        foreach ($domains as $domain) {
            $domainQuestions = Question::whereHas('topic', function($query) use ($domain) {
                    $query->where('domain_id', $domain->id);
                })
                ->where('status', 'approved')
                ->inRandomOrder()
                ->limit($questionsPerDomain)
                ->get();
            
            $selectedQuestions = $selectedQuestions->merge($domainQuestions);
        }
        
        // Trim to exact count and shuffle
        $selectedQuestions = $selectedQuestions->take($totalQuestions)->shuffle();
        
        if ($selectedQuestions->count() < 10) {
            return redirect()->back()
                ->with('error', 'Not enough questions available for this certification. Please contact support.');
        }
        
        // Determine attempt number
        $attemptNumber = ExamAttempt::where('learner_id', $learner->id)
            ->where('certification_id', $certificationId)
            ->where('exam_type', 'benchmark')
            ->count() + 1;
        
        // Create exam attempt
        $examAttempt = ExamAttempt::create([
            'id' => Str::uuid(),
            'learner_id' => $learner->id,
            'certification_id' => $certificationId,
            'exam_type' => 'benchmark',
            'status' => 'created',
            'attempt_number' => $attemptNumber,
            'total_questions' => $selectedQuestions->count(),
            'time_limit_minutes' => $timeLimit,
            'passing_score' => $passingScore,
            'difficulty_level' => 'mixed',
            'adaptive_mode' => false,
            'correct_answers' => 0,
            'score_percentage' => 0,
        ]);
        
        // Create exam attempt questions
        $order = 1;
        foreach ($selectedQuestions as $question) {
            ExamAttemptQuestion::create([
                'id' => Str::uuid(),
                'attempt_id' => $examAttempt->id,
                'question_id' => $question->id,
                'order_number' => $order++,
                'is_flagged' => false,
            ]);
        }
        
        return redirect()->route('learner.benchmark.start', $certificationId)
            ->with('success', 'Benchmark exam created successfully. Good luck!');
    }
    
    /**
     * Start the benchmark exam
     */
    public function start($certificationId)
    {
        $learner = auth('learner')->user();
        
        // Get the most recent created or in-progress benchmark
        $examAttempt = ExamAttempt::where('learner_id', $learner->id)
            ->where('certification_id', $certificationId)
            ->where('exam_type', 'benchmark')
            ->whereIn('status', ['created', 'in_progress'])
            ->latest()
            ->first();
        
        if (!$examAttempt) {
            return redirect()->route('learner.benchmark.explain', $certificationId)
                ->with('error', 'No benchmark exam found. Please create one first.');
        }
        
        // Update status to in_progress if it's created
        if ($examAttempt->status === 'created') {
            $examAttempt->update([
                'status' => 'in_progress',
                'started_at' => now(),
            ]);
        }
        
        // Redirect to exam taking interface
        return redirect()->route('learner.exams.take', $examAttempt->id);
    }
}

