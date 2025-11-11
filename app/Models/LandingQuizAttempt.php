<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingQuizAttempt extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use \Illuminate\Database\Eloquent\Concerns\HasUuids;

    protected $fillable = [
        'certification_id',
        'session_id',
        'score',
        'answers',
        'completed_at',
        'converted_to_registration',
        'learner_id',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'answers' => 'array',
        'completed_at' => 'datetime',
        'converted_to_registration' => 'boolean',
    ];

    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

    public function markAsConverted($learner)
    {
        $this->update([
            'converted_to_registration' => true,
            'learner_id' => $learner->id,
        ]);
    }
}
