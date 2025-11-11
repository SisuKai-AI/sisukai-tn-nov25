<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_id',
        'answer_text',
        'is_correct',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_correct' => 'boolean',
        'order' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the question that owns the answer.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the practice answers that selected this answer.
     */
    public function practiceAnswers()
    {
        return $this->hasMany(PracticeAnswer::class);
    }

    /**
     * Get the exam answers that selected this answer.
     */
    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class);
    }

    /**
     * Scope a query to only include correct answers.
     */
    public function scopeCorrect($query)
    {
        return $query->where('is_correct', true);
    }

    /**
     * Scope a query to order answers by their order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}

