<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaddleService
{
    private $apiKey;
    private $vendorId;
    private $environment;
    private $baseUrl;
    
    public function __construct()
    {
        $this->apiKey = config('services.paddle.api_key');
        $this->vendorId = config('services.paddle.vendor_id');
        $this->environment = config('services.paddle.environment', 'sandbox');
        
        // Paddle API base URL
        $this->baseUrl = $this->environment === 'production'
            ? 'https://api.paddle.com'
            : 'https://sandbox-api.paddle.com';
    }
    
    /**
     * Create a checkout session for subscription
     */
    public function createSubscriptionCheckout($learner, $planId, $priceId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/checkout/sessions', [
                'items' => [
                    [
                        'price_id' => $priceId,
                        'quantity' => 1,
                    ],
                ],
                'customer' => [
                    'email' => $learner->email,
                ],
                'custom_data' => [
                    'learner_id' => $learner->id,
                    'plan_id' => $planId,
                    'type' => 'subscription',
                ],
                'success_url' => route('learner.payment.success') . '?session_id={checkout_session_id}',
                'cancel_url' => route('learner.payment.cancel'),
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            Log::error('Paddle checkout creation failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            
            throw new \Exception('Failed to create Paddle checkout session');
            
        } catch (\Exception $e) {
            Log::error('Paddle API error', ['message' => $e->getMessage()]);
            throw $e;
        }
    }
    
    /**
     * Create a checkout session for single certification
     */
    public function createCertificationCheckout($learner, $certification)
    {
        try {
            // In production, you would have Paddle product IDs for each certification
            // For now, we'll use a generic product ID
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/checkout/sessions', [
                'items' => [
                    [
                        'price_id' => config('services.paddle.single_cert_price_id'),
                        'quantity' => 1,
                    ],
                ],
                'customer' => [
                    'email' => $learner->email,
                ],
                'custom_data' => [
                    'learner_id' => $learner->id,
                    'certification_id' => $certification->id,
                    'type' => 'single_certification',
                ],
                'success_url' => route('learner.payment.success') . '?session_id={checkout_session_id}',
                'cancel_url' => route('learner.payment.cancel'),
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            Log::error('Paddle certification checkout failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            
            throw new \Exception('Failed to create Paddle checkout session');
            
        } catch (\Exception $e) {
            Log::error('Paddle API error', ['message' => $e->getMessage()]);
            throw $e;
        }
    }
    
    /**
     * Cancel a subscription
     */
    public function cancelSubscription($subscriptionId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . "/subscriptions/{$subscriptionId}/cancel", [
                'effective_from' => 'next_billing_period',
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            throw new \Exception('Failed to cancel Paddle subscription');
            
        } catch (\Exception $e) {
            Log::error('Paddle cancel subscription error', ['message' => $e->getMessage()]);
            throw $e;
        }
    }
    
    /**
     * Resume a cancelled subscription
     */
    public function resumeSubscription($subscriptionId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . "/subscriptions/{$subscriptionId}/resume");
            
            if ($response->successful()) {
                return $response->json();
            }
            
            throw new \Exception('Failed to resume Paddle subscription');
            
        } catch (\Exception $e) {
            Log::error('Paddle resume subscription error', ['message' => $e->getMessage()]);
            throw $e;
        }
    }
    
    /**
     * Verify webhook signature
     */
    public function verifyWebhookSignature($payload, $signature)
    {
        $webhookSecret = config('services.paddle.webhook_secret');
        
        // Paddle uses TS1 signature format
        // Extract timestamp and signatures
        $parts = explode(';', $signature);
        $timestamp = null;
        $signatures = [];
        
        foreach ($parts as $part) {
            if (strpos($part, 't=') === 0) {
                $timestamp = substr($part, 2);
            } elseif (strpos($part, 'h1=') === 0) {
                $signatures[] = substr($part, 3);
            }
        }
        
        if (!$timestamp || empty($signatures)) {
            return false;
        }
        
        // Create signed payload
        $signedPayload = $timestamp . ':' . $payload;
        
        // Calculate expected signature
        $expectedSignature = hash_hmac('sha256', $signedPayload, $webhookSecret);
        
        // Compare signatures
        foreach ($signatures as $sig) {
            if (hash_equals($expectedSignature, $sig)) {
                return true;
            }
        }
        
        return false;
    }
}
