<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    use HasFactory, HasUuids;

    // Exam type constants
    const TYPE_BENCHMARK = 'benchmark';
    const TYPE_PRACTICE = 'practice';
    const TYPE_FINAL = 'final';

    // Status constants
    const STATUS_CREATED = 'created';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_ABANDONED = 'abandoned';
    const STATUS_EXPIRED = 'expired';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'learner_id',
        'certification_id',
        'exam_type',
        'time_limit_minutes',
        'questions_per_domain',
        'adaptive_mode',
        'difficulty_level',
        'attempt_number',
        'total_questions',
        'correct_answers',
        'score_percentage',
        'passing_score',
        'passed',
        'status',
        'started_at',
        'completed_at',
        'duration_minutes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'questions_per_domain' => 'array',
        'adaptive_mode' => 'boolean',
        'attempt_number' => 'integer',
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'score_percentage' => 'decimal:2',
        'passing_score' => 'integer',
        'passed' => 'boolean',
        'time_limit_minutes' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'duration_minutes' => 'integer',
    ];

    /**
     * Get the learner that owns the exam attempt.
     */
    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

    /**
     * Get the certification for the exam attempt.
     */
    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    /**
     * Get the exam answers for the attempt.
     */
    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class, 'attempt_id');
    }

    /**
     * Get the exam attempt questions for the attempt.
     */
    public function attemptQuestions()
    {
        return $this->hasMany(ExamAttemptQuestion::class, 'attempt_id');
    }

    /**
     * Get the certificate for the exam attempt (if passed).
     */
    public function certificate()
    {
        return $this->hasOne(Certificate::class, 'exam_attempt_id');
    }

    /**
     * Scope a query to only include in-progress attempts.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope a query to only include completed attempts.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include passed attempts.
     */
    public function scopePassed($query)
    {
        return $query->where('passed', true);
    }

    /**
     * Scope a query to only include failed attempts.
     */
    public function scopeFailed($query)
    {
        return $query->where('passed', false);
    }

    /**
     * Scope a query to only include benchmark exams.
     */
    public function scopeBenchmark($query)
    {
        return $query->where('exam_type', self::TYPE_BENCHMARK);
    }

    /**
     * Scope a query to only include practice exams.
     */
    public function scopePractice($query)
    {
        return $query->where('exam_type', self::TYPE_PRACTICE);
    }

    /**
     * Scope a query to only include final exams.
     */
    public function scopeFinal($query)
    {
        return $query->where('exam_type', self::TYPE_FINAL);
    }

    /**
     * Check if the attempt is in progress.
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if the attempt is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the learner passed the exam.
     */
    public function hasPassed(): bool
    {
        return $this->passed === true;
    }

    /**
     * Check if this is a benchmark exam.
     */
    public function isBenchmark(): bool
    {
        return $this->exam_type === self::TYPE_BENCHMARK;
    }

    /**
     * Check if this is a practice exam.
     */
    public function isPractice(): bool
    {
        return $this->exam_type === self::TYPE_PRACTICE;
    }

    /**
     * Check if this is a final exam.
     */
    public function isFinal(): bool
    {
        return $this->exam_type === self::TYPE_FINAL;
    }

    /**
     * Calculate and update the score.
     */
    public function calculateScore(): void
    {
        $correctAnswers = $this->examAnswers()->where('is_correct', true)->count();
        $totalQuestions = $this->examAnswers()->count();

        $this->correct_answers = $correctAnswers;
        $this->total_questions = $totalQuestions;
        $this->score_percentage = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;
        $this->passed = $this->score_percentage >= $this->passing_score;
        $this->save();
    }

    /**
     * Mark the attempt as completed.
     */
    public function markAsCompleted(): void
    {
        $this->status = 'completed';
        $this->completed_at = now();
        $this->save();
        $this->calculateScore();
    }

    /**
     * Get the domain breakdown of scores.
     */
    public function getDomainScores(): array
    {
        $domainScores = [];
        
        foreach ($this->certification->domains as $domain) {
            $domainQuestions = $this->examAnswers()
                ->whereHas('question.topic', function ($query) use ($domain) {
                    $query->where('domain_id', $domain->id);
                })
                ->get();

            $total = $domainQuestions->count();
            $correct = $domainQuestions->where('is_correct', true)->count();
            
            $domainScores[$domain->name] = [
                'total' => $total,
                'correct' => $correct,
                'percentage' => $total > 0 ? ($correct / $total) * 100 : 0,
            ];
        }

        return $domainScores;
    }

    /**
     * Get weak domains (score < 70%).
     */
    public function getWeakDomains(): array
    {
        $domainScores = $this->getDomainScores();
        return array_filter($domainScores, function ($domain) {
            return $domain['percentage'] < 70;
        });
    }

    /**
     * Get strong domains (score >= 80%).
     */
    public function getStrongDomains(): array
    {
        $domainScores = $this->getDomainScores();
        return array_filter($domainScores, function ($domain) {
            return $domain['percentage'] >= 80;
        });
    }
}

