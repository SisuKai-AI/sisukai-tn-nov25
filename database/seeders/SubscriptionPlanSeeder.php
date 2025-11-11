<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Seed subscription plans according to CERTIFICATION_LANDING_PAGE_ENHANCEMENT_V2
     * 
     * Three pricing tiers:
     * 1. Single Certification ($39 one-time) - Focus on one cert
     * 2. All-Access Monthly ($24/mo) - Unlimited certs, monthly billing
     * 3. All-Access Annual ($199/yr) - Unlimited certs, annual billing (31% savings)
     */
    public function run(): void
    {
        // Clear existing plans to avoid duplicates
        SubscriptionPlan::query()->delete();
        
        $plans = [
            [
                'name' => 'Single Certification',
                'slug' => 'single-cert',
                'description' => 'Focus on one certification at a time with full access to all practice materials. Perfect for learners with a specific certification goal.',
                'price_monthly' => 39.00,  // One-time payment stored as monthly
                'price_annual' => 0.00,    // No annual option for single cert
                'trial_days' => 0,
                'certification_limit' => 1,
                'has_analytics' => true,
                'has_practice_sessions' => true,
                'has_benchmark_exams' => true,
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 1,
                'features' => json_encode([
                    'Access to one certification',
                    'Unlimited practice questions',
                    'Unlimited benchmark exams',
                    'Performance analytics',
                    'Detailed explanations',
                    'One-time payment, no subscription',
                    'Lifetime access - no expiration',
                ]),
            ],
            [
                'name' => 'All-Access Monthly',
                'slug' => 'all-access-monthly',
                'description' => 'Unlimited access to all 18+ certifications with monthly billing. Cancel anytime, no commitment required.',
                'price_monthly' => 24.00,
                'price_annual' => 0.00,
                'trial_days' => 7,
                'certification_limit' => null, // Unlimited
                'has_analytics' => true,
                'has_practice_sessions' => true,
                'has_benchmark_exams' => true,
                'is_active' => true,
                'is_popular' => true,  // Most popular plan
                'sort_order' => 2,
                'features' => json_encode([
                    'Access to all 18+ certifications',
                    'Unlimited practice questions',
                    'Unlimited benchmark exams',
                    'Performance analytics and tracking',
                    'Personalized study plan recommendations',
                    'Progress tracking across all certifications',
                    'Cancel anytime, no commitment',
                ]),
            ],
            [
                'name' => 'All-Access Annual',
                'slug' => 'all-access-annual',
                'description' => 'Unlimited access to all 18+ certifications with annual billing. Save 31% compared to monthly! Includes priority support and downloadable materials.',
                'price_monthly' => 0.00,
                'price_annual' => 199.00,
                'trial_days' => 7,
                'certification_limit' => null, // Unlimited
                'has_analytics' => true,
                'has_practice_sessions' => true,
                'has_benchmark_exams' => true,
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 3,
                'features' => json_encode([
                    'Access to all 18+ certifications',
                    'Unlimited practice questions',
                    'Unlimited benchmark exams',
                    'Performance analytics and tracking',
                    'Personalized study plan recommendations',
                    'Priority email support',
                    'Downloadable study materials',
                    'Certification completion badges',
                    'Save 31% vs monthly billing',
                    '2 months FREE (equivalent to $16.58/month)',
                ]),
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
        
        $this->command->info('✅ Subscription plans seeded successfully (V2 specification)');
        $this->command->info('   - Single Certification: $39 one-time');
        $this->command->info('   - All-Access Monthly: $24/month');
        $this->command->info('   - All-Access Annual: $199/year');
    }
}
