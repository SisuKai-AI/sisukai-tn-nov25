<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SingleCertificationPurchase extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'learner_id',
        'certification_id',
        'payment_id',
        'price_paid',
        'purchased_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'price_paid' => 'decimal:2',
        'purchased_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function isActive()
    {
        return $this->is_active && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function hasExpired()
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }
}
