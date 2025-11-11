<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlaggedQuestion extends Model
{
    use HasFactory, HasUuids;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'learner_id',
        'question_id',
        'certification_id',
        'notes',
        'flagged_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'flagged_at' => 'datetime',
    ];

    /**
     * Get the learner that flagged the question.
     */
    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

    /**
     * Get the question that was flagged.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the certification context for the flagged question.
     */
    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    /**
     * Scope a query to get flagged questions for a specific learner.
     */
    public function scopeForLearner($query, $learnerId)
    {
        return $query->where('learner_id', $learnerId);
    }

    /**
     * Scope a query to get flagged questions for a specific certification.
     */
    public function scopeForCertification($query, $certificationId)
    {
        return $query->where('certification_id', $certificationId);
    }
}

