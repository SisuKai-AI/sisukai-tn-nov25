<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
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
        'certification_id',
        'exam_attempt_id',
        'certificate_number',
        'status',
        'revocation_reason',
        'revoked_by',
        'issued_at',
        'revoked_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'issued_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    /**
     * Get the learner that owns the certificate.
     */
    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

    /**
     * Get the certification for the certificate.
     */
    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    /**
     * Get the exam attempt that earned the certificate.
     */
    public function examAttempt()
    {
        return $this->belongsTo(ExamAttempt::class, 'exam_attempt_id');
    }

    /**
     * Get the user who revoked the certificate.
     */
    public function revokedBy()
    {
        return $this->belongsTo(User::class, 'revoked_by');
    }

    /**
     * Scope a query to only include valid certificates.
     */
    public function scopeValid($query)
    {
        return $query->where('status', 'valid');
    }

    /**
     * Scope a query to only include revoked certificates.
     */
    public function scopeRevoked($query)
    {
        return $query->where('status', 'revoked');
    }

    /**
     * Check if the certificate is valid.
     */
    public function isValid(): bool
    {
        return $this->status === 'valid';
    }

    /**
     * Check if the certificate is revoked.
     */
    public function isRevoked(): bool
    {
        return $this->status === 'revoked';
    }

    /**
     * Revoke the certificate.
     */
    public function revoke(string $reason, $revokedBy = null): void
    {
        $this->status = 'revoked';
        $this->revocation_reason = $reason;
        $this->revoked_by = $revokedBy;
        $this->revoked_at = now();
        $this->save();
    }

    /**
     * Generate a unique certificate number.
     */
    public static function generateCertificateNumber(Certification $certification, Learner $learner): string
    {
        $prefix = strtoupper($certification->code);
        $year = now()->year;
        $sequence = str_pad(
            static::where('certification_id', $certification->id)
                ->whereYear('issued_at', $year)
                ->count() + 1,
            6,
            '0',
            STR_PAD_LEFT
        );

        return "{$prefix}-{$year}-{$sequence}";
    }
}

