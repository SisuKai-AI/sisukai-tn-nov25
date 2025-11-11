<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Payment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'learner_id',
        'payment_type',
        'certification_id',
        'subscription_plan_id',
        'amount',
        'currency',
        'status',
        'payment_processor',
        'processor_payment_id',
        'processor_customer_id',
        'metadata',
        'paid_at',
        'refunded_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    /**
     * Get the learner that owns the payment
     */
    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

    /**
     * Get the certification for single cert purchases
     */
    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    /**
     * Get the subscription plan for subscription purchases
     */
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Check if payment is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if payment is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment failed
     */
    public function isFailed()
    {
        return $this->status === 'failed';
    }

    /**
     * Check if payment was refunded
     */
    public function isRefunded()
    {
        return $this->status === 'refunded';
    }

    /**
     * Mark payment as completed
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);
    }

    /**
     * Mark payment as failed
     */
    public function markAsFailed()
    {
        $this->update(['status' => 'failed']);
    }

    /**
     * Mark payment as refunded
     */
    public function markAsRefunded()
    {
        $this->update([
            'status' => 'refunded',
            'refunded_at' => now(),
        ]);
    }
}
