<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certification extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'provider',
        'exam_question_count',
        'exam_duration_minutes',
        'passing_score',
        'price_single_cert',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'exam_question_count' => 'integer',
        'exam_duration_minutes' => 'integer',
        'passing_score' => 'integer',
        'price_single_cert' => 'decimal:2',
        'is_active' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the domains for the certification.
     */
    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    /**
     * Get the questions for the certification through domains and topics.
     */
    public function questions()
    {
        return Question::whereHas('topic.domain', function($query) {
            $query->where('certification_id', $this->id);
        });
    }

    /**
     * Get the practice sessions for the certification.
     */
    public function practiceSessions()
    {
        return $this->hasMany(PracticeSession::class);
    }

    /**
     * Get the exam attempts for the certification.
     */
    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    /**
     * Get the certificates issued for this certification.
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Get the flagged questions for this certification.
     */
    public function flaggedQuestions()
    {
        return $this->hasMany(FlaggedQuestion::class);
    }

    /**
     * Get the landing quiz questions for this certification.
     */
    public function landingQuizQuestions()
    {
        return $this->hasMany(CertificationLandingQuizQuestion::class);
    }

    /**
     * Get the landing quiz attempts for this certification.
     */
    public function landingQuizAttempts()
    {
        return $this->hasMany(LandingQuizAttempt::class);
    }

    /**
     * Scope a query to only include active certifications.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include draft certifications.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Check if the certification is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if the certification is archived.
     */
    public function isArchived(): bool
    {
        return $this->status === 'archived';
    }

    /**
     * Get the learners enrolled in this certification.
     */
    public function learners()
    {
        return $this->belongsToMany(Learner::class, 'learner_certification')
            ->withPivot('status', 'progress_percentage', 'enrolled_at', 'started_at', 'completed_at')
            ->withTimestamps();
    }
}

