<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttemptQuestion extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'attempt_id',
        'question_id',
        'order_number',
        'is_flagged',
        'time_spent_seconds',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_flagged' => 'boolean',
        'order_number' => 'integer',
        'time_spent_seconds' => 'integer',
    ];

    /**
     * Get the exam attempt that owns the question.
     */
    public function attempt()
    {
        return $this->belongsTo(ExamAttempt::class, 'attempt_id');
    }

    /**
     * Get the question.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the exam answer for this question (if answered).
     */
    public function examAnswer()
    {
        return $this->hasOne(ExamAnswer::class, 'question_id', 'question_id')
            ->where('attempt_id', $this->attempt_id);
    }

    /**
     * Scope a query to only include flagged questions.
     */
    public function scopeFlagged($query)
    {
        return $query->where('is_flagged', true);
    }

    /**
     * Scope a query to order by question order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_number');
    }
}
