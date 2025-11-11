<?php

namespace App\Http\Controllers;

use App\Models\Learner;
use App\Models\LearnerSubscription;
use App\Models\Payment;
use App\Models\PaymentProcessorSetting;
use App\Models\SingleCertificationPurchase;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrialStartedMail;
use App\Mail\PaymentSucceededMail;
use App\Mail\PaymentFailedMail;
use App\Mail\SubscriptionCancelledMail;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    /**
     * Handle Stripe webhook events
     */
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        
        try {
            // Get webhook secret
            $setting = PaymentProcessorSetting::where('processor', 'stripe')
                ->where('is_active', true)
                ->first();
            
            if (!$setting) {
                Log::error('Stripe webhook: No active Stripe configuration found');
                return response()->json(['error' => 'Webhook not configured'], 400);
            }
            
            $webhookSecret = $setting->getDecryptedWebhookSecret();
            
            // Verify webhook signature
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $webhookSecret
            );
            
        } catch (\UnexpectedValueException $e) {
            Log::error('Stripe webhook: Invalid payload', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Stripe webhook: Invalid signature', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }
        
        // Handle the event
        try {
            switch ($event->type) {
                case 'checkout.session.completed':
                    $this->handleCheckoutCompleted($event->data->object);
                    break;
                    
                case 'customer.subscription.created':
                    $this->handleSubscriptionCreated($event->data->object);
                    break;
                    
                case 'customer.subscription.updated':
                    $this->handleSubscriptionUpdated($event->data->object);
                    break;
                    
                case 'customer.subscription.deleted':
                    $this->handleSubscriptionDeleted($event->data->object);
                    break;
                    
                case 'invoice.payment_succeeded':
                    $this->handlePaymentSucceeded($event->data->object);
                    break;
                    
                case 'invoice.payment_failed':
                    $this->handlePaymentFailed($event->data->object);
                    break;
                    
                default:
                    Log::info('Stripe webhook: Unhandled event type', ['type' => $event->type]);
            }
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            Log::error('Stripe webhook: Error processing event', [
                'type' => $event->type,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Processing failed'], 500);
        }
    }
    
    /**
     * Handle checkout session completed
     */
    private function handleCheckoutCompleted($session)
    {
        $learnerId = $session->metadata->learner_id ?? null;
        $type = $session->metadata->type ?? null;
        
        if (!$learnerId) {
            Log::warning('Stripe webhook: No learner_id in checkout session metadata');
            return;
        }
        
        $learner = Learner::find($learnerId);
        if (!$learner) {
            Log::warning('Stripe webhook: Learner not found', ['learner_id' => $learnerId]);
            return;
        }
        
        // Record payment
        Payment::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'learner_id' => $learner->id,
            'processor' => 'stripe',
            'transaction_id' => $session->payment_intent ?? $session->id,
            'amount' => $session->amount_total / 100, // Convert from cents
            'currency' => strtoupper($session->currency ?? 'usd'),
            'status' => 'completed',
            'type' => $type,
            'metadata' => json_encode($session->metadata),
        ]);
        
        // Handle based on type
        if ($type === 'single_certification') {
            $this->handleSingleCertificationPurchase($session, $learner);
        }
        
        Log::info('Stripe webhook: Checkout completed', [
            'learner_id' => $learner->id,
            'type' => $type,
            'amount' => $session->amount_total / 100,
        ]);
    }
    
    /**
     * Handle single certification purchase
     */
    private function handleSingleCertificationPurchase($session, $learner)
    {
        $certificationId = $session->metadata->certification_id ?? null;
        
        if (!$certificationId) {
            Log::warning('Stripe webhook: No certification_id in metadata');
            return;
        }
        
        // Create purchase record
        SingleCertificationPurchase::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'learner_id' => $learner->id,
            'certification_id' => $certificationId,
            'amount_paid' => $session->amount_total / 100,
            'currency' => strtoupper($session->currency ?? 'usd'),
            'processor' => 'stripe',
            'transaction_id' => $session->payment_intent ?? $session->id,
            'status' => 'active',
            'purchased_at' => now(),
        ]);
        
        // Auto-enroll learner in certification
        \App\Models\LearnerCertification::firstOrCreate([
            'learner_id' => $learner->id,
            'certification_id' => $certificationId,
        ], [
            'id' => \Illuminate\Support\Str::uuid(),
            'enrolled_at' => now(),
        ]);
        
        Log::info('Stripe webhook: Single certification purchase completed', [
            'learner_id' => $learner->id,
            'certification_id' => $certificationId,
        ]);
    }
    
    /**
     * Handle subscription created
     */
    private function handleSubscriptionCreated($subscription)
    {
        $learnerId = $subscription->metadata->learner_id ?? null;
        $planId = $subscription->metadata->plan_id ?? null;
        
        if (!$learnerId || !$planId) {
            Log::warning('Stripe webhook: Missing metadata in subscription', [
                'learner_id' => $learnerId,
                'plan_id' => $planId,
            ]);
            return;
        }
        
        $learner = Learner::find($learnerId);
        $plan = SubscriptionPlan::find($planId);
        
        if (!$learner || !$plan) {
            Log::warning('Stripe webhook: Learner or plan not found');
            return;
        }
        
        // Create or update subscription
        LearnerSubscription::updateOrCreate(
            [
                'learner_id' => $learner->id,
                'stripe_subscription_id' => $subscription->id,
            ],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'subscription_plan_id' => $plan->id,
                'status' => $subscription->status,
                'trial_ends_at' => $subscription->trial_end ? \Carbon\Carbon::createFromTimestamp($subscription->trial_end) : null,
                'current_period_start' => \Carbon\Carbon::createFromTimestamp($subscription->current_period_start),
                'current_period_end' => \Carbon\Carbon::createFromTimestamp($subscription->current_period_end),
                'processor' => 'stripe',
            ]
        );
        
        // Update learner trial status
        $learner->update([
            'trial_started_at' => $subscription->trial_end ? now() : null,
            'trial_ends_at' => $subscription->trial_end ? \Carbon\Carbon::createFromTimestamp($subscription->trial_end) : null,
        ]);
        
        // Send trial started email
        $learnerSubscription = LearnerSubscription::where('stripe_subscription_id', $subscription->id)->first();
        if ($learnerSubscription && $subscription->trial_end) {
            Mail::to($learner->email)->send(new TrialStartedMail($learner, $learnerSubscription));
        }
        
        Log::info('Stripe webhook: Subscription created', [
            'learner_id' => $learner->id,
            'subscription_id' => $subscription->id,
            'status' => $subscription->status,
        ]);
    }
    
    /**
     * Handle subscription updated
     */
    private function handleSubscriptionUpdated($subscription)
    {
        $learnerSubscription = LearnerSubscription::where('stripe_subscription_id', $subscription->id)->first();
        
        if (!$learnerSubscription) {
            Log::warning('Stripe webhook: Subscription not found in database', ['subscription_id' => $subscription->id]);
            return;
        }
        
        $learnerSubscription->update([
            'status' => $subscription->status,
            'current_period_start' => \Carbon\Carbon::createFromTimestamp($subscription->current_period_start),
            'current_period_end' => \Carbon\Carbon::createFromTimestamp($subscription->current_period_end),
            'ends_at' => $subscription->cancel_at_period_end ? \Carbon\Carbon::createFromTimestamp($subscription->current_period_end) : null,
        ]);
        
        Log::info('Stripe webhook: Subscription updated', [
            'subscription_id' => $subscription->id,
            'status' => $subscription->status,
        ]);
    }
    
    /**
     * Handle subscription deleted
     */
    private function handleSubscriptionDeleted($subscription)
    {
        $learnerSubscription = LearnerSubscription::where('stripe_subscription_id', $subscription->id)->first();
        
        if (!$learnerSubscription) {
            Log::warning('Stripe webhook: Subscription not found in database', ['subscription_id' => $subscription->id]);
            return;
        }
        
        $learnerSubscription->update([
            'status' => 'canceled',
            'ends_at' => now(),
        ]);
        
        // Send subscription cancelled email
        Mail::to($learnerSubscription->learner->email)->send(
            new SubscriptionCancelledMail($learnerSubscription->learner, $learnerSubscription)
        );
        
        Log::info('Stripe webhook: Subscription deleted', [
            'subscription_id' => $subscription->id,
        ]);
    }
    
    /**
     * Handle successful payment
     */
    private function handlePaymentSucceeded($invoice)
    {
        $subscriptionId = $invoice->subscription ?? null;
        
        if (!$subscriptionId) {
            return;
        }
        
        $learnerSubscription = LearnerSubscription::where('stripe_subscription_id', $subscriptionId)->first();
        
        if (!$learnerSubscription) {
            return;
        }
        
        // Record payment
        Payment::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'learner_id' => $learnerSubscription->learner_id,
            'processor' => 'stripe',
            'transaction_id' => $invoice->payment_intent,
            'amount' => $invoice->amount_paid / 100,
            'currency' => strtoupper($invoice->currency),
            'status' => 'completed',
            'type' => 'subscription',
            'metadata' => json_encode([
                'subscription_id' => $subscriptionId,
                'invoice_id' => $invoice->id,
            ]),
        ]);
        
        // Update subscription status
        $learnerSubscription->update([
            'status' => 'active',
            'last_payment_at' => now(),
        ]);
        
        // Send payment succeeded email
        $payment = Payment::where('transaction_id', $invoice->payment_intent)->first();
        if ($payment) {
            Mail::to($learnerSubscription->learner->email)->send(
                new PaymentSucceededMail($learnerSubscription->learner, $payment, $learnerSubscription)
            );
        }
        
        Log::info('Stripe webhook: Payment succeeded', [
            'subscription_id' => $subscriptionId,
            'amount' => $invoice->amount_paid / 100,
        ]);
    }
    
    /**
     * Handle failed payment
     */
    private function handlePaymentFailed($invoice)
    {
        $subscriptionId = $invoice->subscription ?? null;
        
        if (!$subscriptionId) {
            return;
        }
        
        $learnerSubscription = LearnerSubscription::where('stripe_subscription_id', $subscriptionId)->first();
        
        if (!$learnerSubscription) {
            return;
        }
        
        // Update subscription status
        $learnerSubscription->update([
            'status' => 'past_due',
        ]);
        
        // Send payment failed email
        $failureReason = $invoice->last_payment_error->message ?? 'Payment declined';
        Mail::to($learnerSubscription->learner->email)->send(
            new PaymentFailedMail(
                $learnerSubscription->learner,
                $learnerSubscription,
                $invoice->amount_due / 100,
                $failureReason
            )
        );
        
        Log::warning('Stripe webhook: Payment failed', [
            'subscription_id' => $subscriptionId,
            'learner_id' => $learnerSubscription->learner_id,
        ]);
    }
}
