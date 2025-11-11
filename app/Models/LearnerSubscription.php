<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearnerSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_id',
        'subscription_plan_id',
        'status',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'cancelled_at',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Get the learner that owns the subscription
     */
    public function learner()
    {
        return $this->belongsTo(User::class, 'learner_id');
    }

    /**
     * Get the subscription plan
     */
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    /**
     * Check if subscription is active
     */
    public function isActive()
    {
        return $this->status === 'active' && 
               ($this->ends_at === null || $this->ends_at->isFuture());
    }

    /**
     * Check if subscription is in trial period
     */
    public function isTrial()
    {
        return $this->status === 'trial' && 
               ($this->trial_ends_at === null || $this->trial_ends_at->isFuture());
    }
}
