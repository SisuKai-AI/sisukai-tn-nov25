<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_monthly',
        'price_annual',
        'trial_days',
        'certification_limit',
        'features',
        'has_analytics',
        'has_practice_sessions',
        'has_benchmark_exams',
        'is_active',
        'is_featured',
        'is_popular',
        'sort_order',
        'stripe_price_id_monthly',
        'stripe_price_id_annual',
        'paddle_plan_id_monthly',
        'paddle_plan_id_annual',
        'savings_percentage',
    ];

    protected $casts = [
        'price_monthly' => 'decimal:2',
        'price_annual' => 'decimal:2',
        'features' => 'array',
        'has_analytics' => 'boolean',
        'has_practice_sessions' => 'boolean',
        'has_benchmark_exams' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_popular' => 'boolean',
    ];

    /**
     * Get all subscriptions for this plan
     */
    public function subscriptions()
    {
        return $this->hasMany(LearnerSubscription::class);
    }

    /**
     * Get active subscriptions for this plan
     */
    public function activeSubscriptions()
    {
        return $this->hasMany(LearnerSubscription::class)->where('status', 'active');
    }
}
