<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Learner;
use App\Models\Certification;
use App\Models\ExamAttempt;
use App\Models\ExamAttemptQuestion;
use App\Models\Question;
use Illuminate\Support\Str;

// Get learner and certification
$learner = Learner::where('email', 'learner@sisukai.com')->first();
$certification = Certification::with(['domains'])->where('name', 'LIKE', '%CompTIA A+%')->first();

echo "Testing Benchmark Creation\n";
echo "==========================\n";
echo "Learner: {$learner->name} ({$learner->email})\n";
echo "Certification: {$certification->name}\n";
echo "Domains: {$certification->domains->count()}\n\n";

// Check enrollment
$enrollment = $certification->learners()->where('learner_id', $learner->id)->first();
if (!$enrollment) {
    echo "ERROR: Learner not enrolled!\n";
    exit(1);
}
echo "✓ Enrollment confirmed\n";

// Check for existing in-progress benchmark
$inProgressBenchmark = ExamAttempt::where('learner_id', $learner->id)
    ->where('certification_id', $certification->id)
    ->where('exam_type', 'benchmark')
    ->where('status', 'in_progress')
    ->first();

if ($inProgressBenchmark) {
    echo "✓ Found existing in-progress benchmark: {$inProgressBenchmark->id}\n";
    exit(0);
}

// Get configuration
$totalQuestions = $certification->exam_questions ?? 45;
$timeLimit = $certification->exam_duration ?? 90;
$passingScore = $certification->passing_score ?? 70;

echo "Configuration:\n";
echo "  - Questions: {$totalQuestions}\n";
echo "  - Time Limit: {$timeLimit} minutes\n";
echo "  - Passing Score: {$passingScore}%\n\n";

// Get questions distributed across domains
$domains = $certification->domains;
$questionsPerDomain = ceil($totalQuestions / $domains->count());

echo "Question Distribution:\n";
$selectedQuestions = collect();
foreach ($domains as $domain) {
    $domainQuestions = Question::whereHas('topic', function($query) use ($domain) {
            $query->where('domain_id', $domain->id);
        })
        ->where('status', 'approved')
        ->inRandomOrder()
        ->limit($questionsPerDomain)
        ->get();
    
    echo "  - {$domain->name}: {$domainQuestions->count()} questions\n";
    $selectedQuestions = $selectedQuestions->merge($domainQuestions);
}

// Trim to exact count and shuffle
$selectedQuestions = $selectedQuestions->take($totalQuestions)->shuffle();

echo "\nTotal selected questions: {$selectedQuestions->count()}\n";

if ($selectedQuestions->count() < 10) {
    echo "ERROR: Not enough questions available (minimum 10 required)\n";
    exit(1);
}

// Determine attempt number
$attemptNumber = ExamAttempt::where('learner_id', $learner->id)
    ->where('certification_id', $certification->id)
    ->where('exam_type', 'benchmark')
    ->count() + 1;

echo "Attempt number: {$attemptNumber}\n\n";

// Create exam attempt
echo "Creating exam attempt...\n";
$examAttempt = ExamAttempt::create([
    'id' => Str::uuid(),
    'learner_id' => $learner->id,
    'certification_id' => $certification->id,
    'exam_type' => 'benchmark',
    'status' => 'created',
    'attempt_number' => $attemptNumber,
    'time_limit_minutes' => $timeLimit,
    'passing_score' => $passingScore,
    'difficulty_level' => 'mixed',
    'adaptive_mode' => false,
    'correct_answers' => 0,
    'score_percentage' => 0,
    'total_questions' => $selectedQuestions->count(),
]);

echo "✓ Exam attempt created: {$examAttempt->id}\n";

// Create exam attempt questions
echo "Creating exam questions...\n";
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

echo "✓ Created {$selectedQuestions->count()} exam questions\n\n";

echo "SUCCESS! Benchmark exam created successfully!\n";
echo "Exam ID: {$examAttempt->id}\n";
echo "Status: {$examAttempt->status}\n";
echo "Questions: {$selectedQuestions->count()}\n";

