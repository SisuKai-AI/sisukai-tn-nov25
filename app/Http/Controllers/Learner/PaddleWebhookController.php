<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\Learner;
use App\Models\LearnerSubscription;
use App\Models\Payment;
use App\Models\SingleCertificationPurchase;
use App\Models\SubscriptionPlan;
use App\Models\Certification;
use App\Services\PaddleService;
use App\Mail\TrialStartedMail;
use App\Mail\PaymentSucceededMail;
use App\Mail\PaymentFailedMail;
use App\Mail\SubscriptionCancelledMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaddleWebhookController extends Controller
{
    private $paddleService;
    
    public function __construct()
    {
        $this->paddleService = new PaddleService();
    }
    
    /**
     * Handle Paddle webhooks
     */
    public function handleWebhook(Request $request)
    {
        try {
            // Verify webhook signature
            if (!$this->paddleService->verifyWebhookSignature($request)) {
                Log::error('Paddle webhook signature verification failed');
                return response()->json(['error' => 'Invalid signature'], 400);
            }
            
            $payload = $request->all();
            $eventType = $payload['event_type'] ?? null;
            
            Log::info('Paddle webhook received', [
                'event_type' => $eventType,
                'payload' => $payload
            ]);
            
            // Route to appropriate handler
            switch ($eventType) {
                case 'subscription.created':
                    return $this->handleSubscriptionCreated($payload);
                    
                case 'subscription.updated':
                    return $this->handleSubscriptionUpdated($payload);
                    
                case 'subscription.canceled':
                    return $this->handleSubscriptionCanceled($payload);
                    
                case 'transaction.completed':
                    return $this->handleTransactionCompleted($payload);
                    
                case 'transaction.payment_failed':
                    return $this->handlePaymentFailed($payload);
                    
                default:
                    Log::info('Unhandled Paddle webhook event type: ' . $eventType);
                    return response()->json(['status' => 'ignored']);
            }
            
        } catch (\Exception $e) {
            Log::error('Paddle webhook error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }
    
    /**
     * Handle subscription.created event
     */
    private function handleSubscriptionCreated($payload)
    {
        try {
            $data = $payload['data'];
            $customerId = $data['customer_id'];
            $subscriptionId = $data['id'];
            $status = $data['status'];
            
            // Find learner by Paddle customer ID
            $learner = Learner::where('paddle_customer_id', $customerId)->first();
            
            if (!$learner) {
                // Try to find by email in custom data
                $email = $data['custom_data']['email'] ?? null;
                if ($email) {
                    $learner = Learner::where('email', $email)->first();
                    
                    // Update Paddle customer ID
                    if ($learner) {
                        $learner->update(['paddle_customer_id' => $customerId]);
                    }
                }
            }
            
            if (!$learner) {
                Log::error('Learner not found for Paddle subscription', ['customer_id' => $customerId]);
                return response()->json(['error' => 'Learner not found'], 404);
            }
            
            // Get plan ID from custom data
            $planId = $data['custom_data']['plan_id'] ?? null;
            $plan = SubscriptionPlan::find($planId);
            
            if (!$plan) {
                Log::error('Plan not found for Paddle subscription', ['plan_id' => $planId]);
                return response()->json(['error' => 'Plan not found'], 404);
            }
            
            // Create or update subscription
            $subscription = LearnerSubscription::updateOrCreate(
                ['paddle_subscription_id' => $subscriptionId],
                [
                    'learner_id' => $learner->id,
                    'plan_id' => $plan->id,
                    'status' => $this->mapPaddleStatus($status),
                    'current_period_start' => $data['current_billing_period']['starts_at'] ?? now(),
                    'current_period_end' => $data['current_billing_period']['ends_at'] ?? now()->addMonth(),
                    'trial_ends_at' => $data['trial_dates']['ends_at'] ?? null,
                    'payment_processor' => 'paddle',
                ]
            );
            
            // Send trial started email if in trial
            if ($status === 'trialing') {
                Mail::to($learner->email)->send(new TrialStartedMail($learner, $plan));
            }
            
            Log::info('Paddle subscription created', [
                'learner_id' => $learner->id,
                'subscription_id' => $subscriptionId
            ]);
            
            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            Log::error('Error handling Paddle subscription.created: ' . $e->getMessage());
            return response()->json(['error' => 'Processing failed'], 500);
        }
    }
    
    /**
     * Handle subscription.updated event
     */
    private function handleSubscriptionUpdated($payload)
    {
        try {
            $data = $payload['data'];
            $subscriptionId = $data['id'];
            $status = $data['status'];
            
            $subscription = LearnerSubscription::where('paddle_subscription_id', $subscriptionId)->first();
            
            if (!$subscription) {
                Log::error('Subscription not found for Paddle update', ['subscription_id' => $subscriptionId]);
                return response()->json(['error' => 'Subscription not found'], 404);
            }
            
            // Update subscription
            $subscription->update([
                'status' => $this->mapPaddleStatus($status),
                'current_period_start' => $data['current_billing_period']['starts_at'] ?? $subscription->current_period_start,
                'current_period_end' => $data['current_billing_period']['ends_at'] ?? $subscription->current_period_end,
            ]);
            
            Log::info('Paddle subscription updated', [
                'subscription_id' => $subscriptionId,
                'status' => $status
            ]);
            
            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            Log::error('Error handling Paddle subscription.updated: ' . $e->getMessage());
            return response()->json(['error' => 'Processing failed'], 500);
        }
    }
    
    /**
     * Handle subscription.canceled event
     */
    private function handleSubscriptionCanceled($payload)
    {
        try {
            $data = $payload['data'];
            $subscriptionId = $data['id'];
            
            $subscription = LearnerSubscription::where('paddle_subscription_id', $subscriptionId)->first();
            
            if (!$subscription) {
                Log::error('Subscription not found for Paddle cancellation', ['subscription_id' => $subscriptionId]);
                return response()->json(['error' => 'Subscription not found'], 404);
            }
            
            $learner = $subscription->learner;
            $plan = $subscription->plan;
            
            // Update subscription status
            $subscription->update([
                'status' => 'canceled',
                'ends_at' => $data['scheduled_change']['effective_at'] ?? now(),
            ]);
            
            // Send cancellation email
            Mail::to($learner->email)->send(new SubscriptionCancelledMail($learner, $plan));
            
            Log::info('Paddle subscription canceled', [
                'subscription_id' => $subscriptionId,
                'learner_id' => $learner->id
            ]);
            
            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            Log::error('Error handling Paddle subscription.canceled: ' . $e->getMessage());
            return response()->json(['error' => 'Processing failed'], 500);
        }
    }
    
    /**
     * Handle transaction.completed event
     */
    private function handleTransactionCompleted($payload)
    {
        try {
            $data = $payload['data'];
            $customerId = $data['customer_id'];
            $transactionId = $data['id'];
            $amount = $data['details']['totals']['total'] / 100; // Convert from cents
            
            // Find learner
            $learner = Learner::where('paddle_customer_id', $customerId)->first();
            
            if (!$learner) {
                Log::error('Learner not found for Paddle transaction', ['customer_id' => $customerId]);
                return response()->json(['error' => 'Learner not found'], 404);
            }
            
            // Check if this is a subscription or one-time purchase
            $subscriptionId = $data['subscription_id'] ?? null;
            $customData = $data['custom_data'] ?? [];
            
            if ($subscriptionId) {
                // Subscription payment
                $subscription = LearnerSubscription::where('paddle_subscription_id', $subscriptionId)->first();
                
                if ($subscription) {
                    // Record payment
                    Payment::create([
                        'learner_id' => $learner->id,
                        'subscription_id' => $subscription->id,
                        'paddle_transaction_id' => $transactionId,
                        'amount' => $amount,
                        'currency' => strtolower($data['currency_code']),
                        'status' => 'completed',
                        'payment_method' => 'paddle',
                        'payment_processor' => 'paddle',
                    ]);
                    
                    // Update subscription status to active
                    $subscription->update(['status' => 'active']);
                    
                    // Send payment succeeded email
                    Mail::to($learner->email)->send(new PaymentSucceededMail($learner, $subscription->plan, $amount));
                }
            } else {
                // One-time certification purchase
                $certificationId = $customData['certification_id'] ?? null;
                
                if ($certificationId) {
                    $certification = Certification::find($certificationId);
                    
                    if ($certification) {
                        // Create purchase record
                        SingleCertificationPurchase::create([
                            'learner_id' => $learner->id,
                            'certification_id' => $certification->id,
                            'paddle_transaction_id' => $transactionId,
                            'amount' => $amount,
                            'status' => 'active',
                            'payment_processor' => 'paddle',
                        ]);
                        
                        // Record payment
                        Payment::create([
                            'learner_id' => $learner->id,
                            'paddle_transaction_id' => $transactionId,
                            'amount' => $amount,
                            'currency' => strtolower($data['currency_code']),
                            'status' => 'completed',
                            'payment_method' => 'paddle',
                            'payment_processor' => 'paddle',
                            'description' => 'Single Certification: ' . $certification->name,
                        ]);
                        
                        // Send payment succeeded email (certification variant)
                        Mail::to($learner->email)->send(new PaymentSucceededMail($learner, null, $amount, $certification));
                    }
                }
            }
            
            Log::info('Paddle transaction completed', [
                'transaction_id' => $transactionId,
                'learner_id' => $learner->id,
                'amount' => $amount
            ]);
            
            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            Log::error('Error handling Paddle transaction.completed: ' . $e->getMessage());
            return response()->json(['error' => 'Processing failed'], 500);
        }
    }
    
    /**
     * Handle transaction.payment_failed event
     */
    private function handlePaymentFailed($payload)
    {
        try {
            $data = $payload['data'];
            $customerId = $data['customer_id'];
            $transactionId = $data['id'];
            $amount = $data['details']['totals']['total'] / 100;
            
            // Find learner
            $learner = Learner::where('paddle_customer_id', $customerId)->first();
            
            if (!$learner) {
                Log::error('Learner not found for Paddle payment failure', ['customer_id' => $customerId]);
                return response()->json(['error' => 'Learner not found'], 404);
            }
            
            // Record failed payment
            Payment::create([
                'learner_id' => $learner->id,
                'paddle_transaction_id' => $transactionId,
                'amount' => $amount,
                'currency' => strtolower($data['currency_code']),
                'status' => 'failed',
                'payment_method' => 'paddle',
                'payment_processor' => 'paddle',
            ]);
            
            // Send payment failed email
            Mail::to($learner->email)->send(new PaymentFailedMail($learner, $amount));
            
            Log::info('Paddle payment failed', [
                'transaction_id' => $transactionId,
                'learner_id' => $learner->id,
                'amount' => $amount
            ]);
            
            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            Log::error('Error handling Paddle transaction.payment_failed: ' . $e->getMessage());
            return response()->json(['error' => 'Processing failed'], 500);
        }
    }
    
    /**
     * Map Paddle status to our internal status
     */
    private function mapPaddleStatus($paddleStatus)
    {
        $statusMap = [
            'active' => 'active',
            'trialing' => 'trialing',
            'past_due' => 'past_due',
            'paused' => 'paused',
            'canceled' => 'canceled',
        ];
        
        return $statusMap[$paddleStatus] ?? 'inactive';
    }
}
