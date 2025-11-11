<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticeSession extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'learner_id',
        'certification_id',
        'domain_id',
        'topic_id',
        'total_questions',
        'correct_answers',
        'score_percentage',
        'status',
        'started_at',
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'score_percentage' => 'decimal:2',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the learner that owns the practice session.
     */
    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

    /**
     * Get the certification for the practice session.
     */
    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    /**
     * Get the domain for the practice session (if domain-specific).
     */
    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    /**
     * Get the topic for the practice session (if topic-specific).
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Get the practice answers for the session.
     */
    public function practiceAnswers()
    {
        return $this->hasMany(PracticeAnswer::class, 'session_id');
    }

    /**
     * Get the questions for the practice session.
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'practice_session_questions', 'practice_session_id', 'question_id')
            ->withPivot('question_order')
            ->orderBy('practice_session_questions.question_order');
    }

    /**
     * Scope a query to only include in-progress sessions.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope a query to only include completed sessions.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include abandoned sessions.
     */
    public function scopeAbandoned($query)
    {
        return $query->where('status', 'abandoned');
    }

    /**
     * Check if the session is in progress.
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if the session is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Calculate and update the score.
     */
    public function calculateScore(): void
    {
        $correctAnswers = $this->practiceAnswers()->where('is_correct', true)->count();
        $totalQuestions = $this->practiceAnswers()->count();

        $this->correct_answers = $correctAnswers;
        $this->total_questions = $totalQuestions;
        $this->score_percentage = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;
        $this->save();
    }

    /**
     * Mark the session as completed.
     */
    public function markAsCompleted(): void
    {
        $this->status = 'completed';
        $this->completed_at = now();
        $this->save();
        $this->calculateScore();
    }
}

