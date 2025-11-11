<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CertificationLandingQuizQuestion extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'certification_id',
        'question_id',
        'order',
    ];

    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
