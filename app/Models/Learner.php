<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasTwoFactorAuth;
use App\Notifications\ResetPasswordNotification;

class Learner extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids, HasTwoFactorAuth;

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'provider',
        'provider_id',
        'email_verified_at',
        'two_factor_enabled',
        'two_factor_method',
        'two_factor_phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if learner account is active.
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if learner account is disabled.
     */
    public function isDisabled()
    {
        return $this->status === 'disabled';
    }

    /**
     * Get the practice sessions for the learner.
     */
    public function practiceSessions()
    {
        return $this->hasMany(PracticeSession::class);
    }

    /**
     * Get the exam attempts for the learner.
     */
    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    /**
     * Get the certificates for the learner.
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Get the flagged questions for the learner.
     */
    public function flaggedQuestions()
    {
        return $this->hasMany(FlaggedQuestion::class);
    }

    /**
     * Get passed exam attempts for the learner.
     */
    public function passedExams()
    {
        return $this->examAttempts()->where('passed', true);
    }

    /**
     * Check if learner has passed a specific certification.
     */
    public function hasPassed($certificationId): bool
    {
        return $this->examAttempts()
            ->where('certification_id', $certificationId)
            ->where('passed', true)
            ->exists();
    }

    /**
     * Get valid certificates for the learner.
     */
    public function validCertificates()
    {
        return $this->certificates()->where('status', 'valid');
    }

    /**
     * Get the certifications the learner is enrolled in.
     */
    public function certifications()
    {
        return $this->belongsToMany(Certification::class, 'learner_certification')
            ->withPivot('status', 'progress_percentage', 'enrolled_at', 'started_at', 'completed_at')
            ->withTimestamps();
    }

    /**
     * Get enrolled certifications.
     */
    public function enrolledCertifications()
    {
        return $this->certifications()->wherePivot('status', 'enrolled');
    }

    /**
     * Get in-progress certifications.
     */
    public function inProgressCertifications()
    {
        return $this->certifications()->wherePivot('status', 'in_progress');
    }

    /**
     * Get completed certifications.
     */
    public function completedCertifications()
    {
        return $this->certifications()->wherePivot('status', 'completed');
    }

    /**
     * Check if learner is enrolled in a certification.
     */
    public function isEnrolledIn($certificationId): bool
    {
        return $this->certifications()->where('certification_id', $certificationId)->exists();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}

