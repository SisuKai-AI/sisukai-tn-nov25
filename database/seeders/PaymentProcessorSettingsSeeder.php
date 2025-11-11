<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentProcessorSettingsSeeder extends Seeder
{
    /**
     * Seed payment processor settings for Stripe and Paddle.
     * 
     * This seeder is idempotent - it will skip processors that already exist.
     * API keys are loaded from environment variables.
     */
    public function run(): void
    {
        $this->command->info('Seeding payment processor settings...');
        
        // Stripe Configuration
        $this->seedStripe();
        
        // Paddle Configuration
        $this->seedPaddle();
        
        $this->command->info('Payment processor settings seeded successfully');
    }
    
    /**
     * Seed Stripe payment processor settings
     */
    private function seedStripe(): void
    {
        // Check if Stripe already exists (idempotent)
        $existing = DB::table('payment_processor_settings')
            ->where('processor', 'stripe')
            ->first();
            
        if ($existing) {
            $this->command->warn('  Stripe settings already exist, skipping...');
            return;
        }
        
        // Get Stripe keys from environment
        $stripePublicKey = env('STRIPE_PUBLIC_KEY', '');
        $stripeSecretKey = env('STRIPE_SECRET_KEY', '');
        $stripeWebhookSecret = env('STRIPE_WEBHOOK_SECRET', '');
        
        // Validate required keys
        if (empty($stripePublicKey) || empty($stripeSecretKey)) {
            $this->command->warn('  ⚠ Stripe API keys not found in .env file');
            $this->command->warn('    Please set STRIPE_PUBLIC_KEY and STRIPE_SECRET_KEY');
            $this->command->warn('    Using placeholder values for now...');
        }
        
        // Prepare configuration JSON
        $config = [
            'public_key' => $stripePublicKey ?: 'pk_test_placeholder',
            'secret_key' => $stripeSecretKey ?: 'sk_test_placeholder',
            'webhook_secret' => $stripeWebhookSecret ?: 'whsec_placeholder',
            'mode' => env('STRIPE_MODE', 'test'), // test or live
            'currency' => 'USD',
            'payment_methods' => ['card', 'us_bank_account'],
            'features' => [
                'subscriptions' => true,
                'one_time_payments' => true,
                'customer_portal' => true,
                'invoicing' => true,
            ],
        ];
        
        // Insert Stripe settings
        DB::table('payment_processor_settings')->insert([
            'id' => Str::uuid()->toString(),
            'processor' => 'stripe',
            'is_active' => true,
            'is_default' => true,
            'config' => json_encode($config),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $this->command->info('  ✓ Stripe settings created (active, default)');
    }
    
    /**
     * Seed Paddle payment processor settings
     */
    private function seedPaddle(): void
    {
        // Check if Paddle already exists (idempotent)
        $existing = DB::table('payment_processor_settings')
            ->where('processor', 'paddle')
            ->first();
            
        if ($existing) {
            $this->command->warn('  Paddle settings already exist, skipping...');
            return;
        }
        
        // Get Paddle keys from environment
        $paddleVendorId = env('PADDLE_VENDOR_ID', '');
        $paddleApiKey = env('PADDLE_API_KEY', '');
        $paddlePublicKey = env('PADDLE_PUBLIC_KEY', '');
        $paddleWebhookSecret = env('PADDLE_WEBHOOK_SECRET', '');
        
        // Validate required keys
        if (empty($paddleVendorId) || empty($paddleApiKey)) {
            $this->command->warn('  ⚠ Paddle API keys not found in .env file');
            $this->command->warn('    Please set PADDLE_VENDOR_ID and PADDLE_API_KEY');
            $this->command->warn('    Using placeholder values for now...');
        }
        
        // Prepare configuration JSON
        $config = [
            'vendor_id' => $paddleVendorId ?: '12345',
            'api_key' => $paddleApiKey ?: 'paddle_api_placeholder',
            'public_key' => $paddlePublicKey ?: 'paddle_public_placeholder',
            'webhook_secret' => $paddleWebhookSecret ?: 'paddle_webhook_placeholder',
            'environment' => env('PADDLE_ENVIRONMENT', 'sandbox'), // sandbox or production
            'currency' => 'USD',
            'features' => [
                'subscriptions' => true,
                'one_time_payments' => true,
                'customer_portal' => false,
                'invoicing' => true,
            ],
        ];
        
        // Insert Paddle settings (inactive by default)
        DB::table('payment_processor_settings')->insert([
            'id' => Str::uuid()->toString(),
            'processor' => 'paddle',
            'is_active' => false,
            'is_default' => false,
            'config' => json_encode($config),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $this->command->info('  ✓ Paddle settings created (inactive)');
    }
}
