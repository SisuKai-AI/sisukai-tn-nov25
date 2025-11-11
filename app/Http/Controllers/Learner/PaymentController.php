<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\Payment;
use App\Models\PaymentProcessorSetting;
use App\Models\SingleCertificationPurchase;
use App\Models\SubscriptionPlan;
use App\Services\PaddleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PaymentController extends Controller
{
    /**
     * Get active payment processor
     */
    private function getActiveProcessor()
    {
        $processor = config('services.payment.default_processor', 'stripe');
        
        // Check if processor is active in database
        $setting = PaymentProcessorSetting::where('processor', $processor)
            ->where('is_active', true)
            ->first();
        
        if (!$setting) {
            // Fallback to Stripe if default is not active
            $setting = PaymentProcessorSetting::where('processor', 'stripe')
                ->where('is_active', true)
                ->first();
            
            if (!$setting) {
                throw new \Exception('No payment processor is configured');
            }
            
            $processor = 'stripe';
        }
        
        return $processor;
    }
    
    /**
     * Initialize Stripe with API key
     */
    private function initializeStripe()
    {
        $setting = PaymentProcessorSetting::where('processor', 'stripe')
            ->where('is_active', true)
            ->first();
        
        if (!$setting) {
            throw new \Exception('Stripe is not configured');
        }
        
        Stripe::setApiKey($setting->getDecryptedSecretKey());
        
        return $setting;
    }
    
    /**
     * Create Stripe customer for learner if not exists
     */
    private function getOrCreateStripeCustomer($learner)
    {
        if ($learner->stripe_customer_id) {
            return $learner->stripe_customer_id;
        }
        
        $this->initializeStripe();
        
        $customer = \Stripe\Customer::create([
            'email' => $learner->email,
            'name' => $learner->name,
            'metadata' => [
                'learner_id' => $learner->id,
            ],
        ]);
        
        $learner->update(['stripe_customer_id' => $customer->id]);
        
        return $customer->id;
    }
    
    /**
     * Create checkout session for subscription
     */
    public function createSubscriptionCheckout(Request $request, $planId)
    {
        try {
            $processor = $this->getActiveProcessor();
            $plan = SubscriptionPlan::findOrFail($planId);
            $learner = Auth::guard('learner')->user();
            
            // Route to appropriate processor
            if ($processor === 'paddle') {
                return $this->createPaddleSubscriptionCheckout($learner, $plan);
            }
            
            // Default to Stripe
            $this->initializeStripe();
            $customerId = $this->getOrCreateStripeCustomer($learner);
            
            // Prepare line items
            $lineItems = [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $plan->name,
                        'description' => $plan->description,
                    ],
                    'unit_amount' => $plan->price * 100, // Convert to cents
                    'recurring' => [
                        'interval' => $plan->billing_cycle === 'yearly' ? 'year' : 'month',
                    ],
                ],
                'quantity' => 1,
            ]];
            
            // Create checkout session
            $session = StripeSession::create([
                'customer' => $customerId,
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'subscription',
                'success_url' => route('learner.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('learner.payment.cancel'),
                'subscription_data' => [
                    'trial_period_days' => $plan->trial_period_days ?? 7,
                    'metadata' => [
                        'learner_id' => $learner->id,
                        'plan_id' => $plan->id,
                    ],
                ],
                'metadata' => [
                    'learner_id' => $learner->id,
                    'plan_id' => $plan->id,
                    'type' => 'subscription',
                ],
            ]);
            
            return redirect($session->url);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Create checkout session for single certification
     */
    public function createCertificationCheckout(Request $request, $certificationId)
    {
        try {
            $processor = $this->getActiveProcessor();
            $certification = Certification::findOrFail($certificationId);
            $learner = Auth::guard('learner')->user();
            
            // Check if already purchased
            $existingPurchase = SingleCertificationPurchase::where('learner_id', $learner->id)
                ->where('certification_id', $certification->id)
                ->where('status', 'active')
                ->first();
            
            if ($existingPurchase) {
                return redirect()->route('learner.certifications.show', $certification->id)
                    ->with('info', 'You already have access to this certification');
            }
            
            // Route to appropriate processor
            if ($processor === 'paddle') {
                return $this->createPaddleCertificationCheckout($learner, $certification);
            }
            
            // Default to Stripe
            $this->initializeStripe();
            $customerId = $this->getOrCreateStripeCustomer($learner);
            
            // Prepare line items
            $lineItems = [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $certification->name,
                        'description' => 'Lifetime access to ' . $certification->name . ' practice questions',
                        'images' => [$certification->icon_url ?? ''],
                    ],
                    'unit_amount' => $certification->price_single_cert * 100, // Convert to cents
                ],
                'quantity' => 1,
            ]];
            
            // Create checkout session
            $session = StripeSession::create([
                'customer' => $customerId,
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('learner.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('learner.payment.cancel'),
                'metadata' => [
                    'learner_id' => $learner->id,
                    'certification_id' => $certification->id,
                    'type' => 'single_certification',
                ],
            ]);
            
            return redirect($session->url);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Handle successful payment
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        
        if (!$sessionId) {
            return redirect()->route('learner.dashboard')
                ->with('error', 'Invalid payment session');
        }
        
        try {
            $this->initializeStripe();
            $session = StripeSession::retrieve($sessionId);
            
            $learner = Auth::guard('learner')->user();
            
            // Verify session belongs to current user
            if ($session->metadata->learner_id != $learner->id) {
                return redirect()->route('learner.dashboard')
                    ->with('error', 'Invalid payment session');
            }
            
            return view('learner.payment.success', [
                'session' => $session,
                'type' => $session->metadata->type ?? 'subscription',
            ]);
            
        } catch (\Exception $e) {
            return redirect()->route('learner.dashboard')
                ->with('error', 'Could not verify payment: ' . $e->getMessage());
        }
    }
    
    /**
     * Handle cancelled payment
     */
    public function cancel()
    {
        return view('learner.payment.cancel');
    }
    
    /**
     * Show pricing page
     */
    public function pricing(Request $request)
    {
        $plans = SubscriptionPlan::where('is_active', true)
            ->orderBy('price', 'asc')
            ->get();
        
        // Get certification context if provided
        $certification = null;
        if ($request->has('cert')) {
            $certification = Certification::where('slug', $request->query('cert'))->first();
        }
        
        return view('learner.payment.pricing', [
            'plans' => $plans,
            'certification' => $certification,
        ]);
    }
    
    /**
     * Manage subscription (cancel, resume, etc.)
     */
    public function manageSubscription(Request $request)
    {
        $learner = Auth::guard('learner')->user();
        $subscription = $learner->activeSubscription;
        
        if (!$subscription) {
            return redirect()->route('learner.payment.pricing')
                ->with('info', 'You don\'t have an active subscription');
        }
        
        return view('learner.payment.manage-subscription', [
            'subscription' => $subscription,
        ]);
    }
    
    /**
     * Cancel subscription
     */
    public function cancelSubscription(Request $request)
    {
        try {
            $learner = Auth::guard('learner')->user();
            $subscription = $learner->activeSubscription;
            
            if (!$subscription || !$subscription->stripe_subscription_id) {
                return redirect()->back()
                    ->with('error', 'No active subscription found');
            }
            
            $this->initializeStripe();
            
            // Cancel at period end (don't cancel immediately)
            $stripeSubscription = \Stripe\Subscription::update(
                $subscription->stripe_subscription_id,
                ['cancel_at_period_end' => true]
            );
            
            $subscription->update([
                'status' => 'canceling',
                'ends_at' => now()->addDays(30), // Approximate, will be updated by webhook
            ]);
            
            return redirect()->route('learner.payment.manage-subscription')
                ->with('success', 'Subscription will be cancelled at the end of the current billing period');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to cancel subscription: ' . $e->getMessage());
        }
    }
    
    /**
     * Resume cancelled subscription
     */
    public function resumeSubscription(Request $request)
    {
        try {
            $learner = Auth::guard('learner')->user();
            $subscription = $learner->activeSubscription;
            
            if (!$subscription || !$subscription->stripe_subscription_id) {
                return redirect()->back()
                    ->with('error', 'No subscription found');
            }
            
            $this->initializeStripe();
            
            // Resume subscription
            $stripeSubscription = \Stripe\Subscription::update(
                $subscription->stripe_subscription_id,
                ['cancel_at_period_end' => false]
            );
            
            $subscription->update([
                'status' => 'active',
                'ends_at' => null,
            ]);
            
            return redirect()->route('learner.payment.manage-subscription')
                ->with('success', 'Subscription resumed successfully');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to resume subscription: ' . $e->getMessage());
        }
    }
    
    /**
     * Show billing history
     */
    public function billingHistory()
    {
        $learner = Auth::guard('learner')->user();
        
        $payments = Payment::where('learner_id', $learner->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $totalPaid = Payment::where('learner_id', $learner->id)
            ->where('status', 'completed')
            ->sum('amount');
        
        return view('learner.subscription.billing-history', compact('payments', 'totalPaid'));
    }
    
    /**
     * Create Paddle subscription checkout
     */
    private function createPaddleSubscriptionCheckout($learner, $plan)
    {
        $paddleService = new PaddleService();
        
        // Get Paddle price ID from plan
        $priceId = $plan->billing_cycle === 'yearly' 
            ? $plan->paddle_price_id_yearly 
            : $plan->paddle_price_id_monthly;
        
        if (!$priceId) {
            throw new \Exception('Paddle price ID not configured for this plan');
        }
        
        $checkout = $paddleService->createSubscriptionCheckout(
            $learner,
            $plan->id,
            $priceId
        );
        
        // Redirect to Paddle checkout
        return redirect($checkout['data']['url']);
    }
    
    /**
     * Create Paddle certification checkout
     */
    private function createPaddleCertificationCheckout($learner, $certification)
    {
        $paddleService = new PaddleService();
        
        $checkout = $paddleService->createCertificationCheckout(
            $learner,
            $certification
        );
        
        // Redirect to Paddle checkout
        return redirect($checkout['data']['url']);
    }
}
