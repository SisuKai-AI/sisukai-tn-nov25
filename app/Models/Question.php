<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'topic_id',
        'question_text',
        'question_type',
        'difficulty',
        'points',
        'explanation',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'points' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the topic that owns the question.
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Get the answers for the question.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get the correct answer for the question.
     */
    public function correctAnswer()
    {
        return $this->hasOne(Answer::class)->where('is_correct', true);
    }

    /**
     * Get the practice answers for the question.
     */
    public function practiceAnswers()
    {
        return $this->hasMany(PracticeAnswer::class);
    }

    /**
     * Get the exam answers for the question.
     */
    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class);
    }

    /**
     * Get the flagged instances for the question.
     */
    public function flaggedQuestions()
    {
        return $this->hasMany(FlaggedQuestion::class);
    }

    /**
     * Get the domain through the topic.
     */
    public function domain()
    {
        return $this->topic->domain();
    }

    /**
     * Get the certification through the topic and domain.
     */
    public function certification()
    {
        return $this->topic->domain->certification();
    }

    /**
     * Scope a query to only include active questions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to filter by difficulty.
     */
    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    /**
     * Scope a query to filter by question type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('question_type', $type);
    }

    /**
     * Check if the question is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if a given answer is correct.
     */
    public function isCorrectAnswer($answerId): bool
    {
        return $this->answers()->where('id', $answerId)->where('is_correct', true)->exists();
    }
}

