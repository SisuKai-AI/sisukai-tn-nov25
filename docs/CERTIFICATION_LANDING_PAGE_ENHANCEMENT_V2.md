# Certification Landing Page Enhancement - Implementation Plan v2.0

**Project:** SisuKai MVP Platform  
**Feature:** Enhanced Certification Detail Pages with Quiz, SEO, Payment Integration, and Smart Onboarding  
**Date:** November 10, 2025  
**Status:** 📋 Ready for Implementation  
**Version:** 2.0 (With Complete Payment Integration)

---

## Table of Contents

1. [Executive Summary](#executive-summary)
2. [Payment & Pricing Strategy](#payment--pricing-strategy)
3. [Goals & Success Metrics](#goals--success-metrics)
4. [Technical Architecture](#technical-architecture)
5. [Database Schema](#database-schema)
6. [Pricing Optimization](#pricing-optimization)
7. [Implementation Phases](#implementation-phases)
8. [User Flows with Payment](#user-flows-with-payment)
9. [Payment Integration](#payment-integration)
10. [Free Trial Management](#free-trial-management)
11. [SEO Strategy](#seo-strategy)
12. [Analytics & Tracking](#analytics--tracking)
13. [Testing Plan](#testing-plan)
14. [Deployment Checklist](#deployment-checklist)

---

## Executive Summary

### Problem Statement

Current certification detail pages are basic and don't maximize conversion potential:
- ❌ No engagement mechanism for guests
- ❌ Limited SEO-optimized content
- ❌ No trust signals or social proof
- ❌ Generic registration flow (no certification context)
- ❌ Missed opportunity to qualify leads before registration
- ❌ **No clear path from free trial to paid conversion**
- ❌ **Payment flow not integrated into onboarding**

### Solution

Enhance certification detail pages with:
- ✅ **5-question quiz** from certification's own question bank
- ✅ **SEO-rich content** (Why, Who, How, FAQs, Study Tips)
- ✅ **Trust signals** (testimonials, success rates, student count)
- ✅ **Smart registration flow** with certification-specific onboarding
- ✅ **7-day free trial** (no credit card required)
- ✅ **Hybrid pricing model** (single cert + subscription options)
- ✅ **Seamless payment integration** (Stripe + Paddle support)
- ✅ **Conversion-optimized paywall** (soft, value-reinforcing)
- ✅ **Structured data** (Schema.org for better search visibility)

### Key Principles

1. **Conversion-First:** Every element optimized for trial → paid conversion
2. **No Over-engineering:** Reuse existing infrastructure where possible
3. **Backward Compatible:** Standard flows remain unchanged
4. **SEO-Optimized:** Every section targets organic traffic
5. **User-Centric:** Transparent pricing, clear value, no dark patterns
6. **Flexible Payment:** Support multiple processors (Stripe, Paddle)

---

## Payment & Pricing Strategy

### **Model: Hybrid Pricing with 7-Day Free Trial**

#### **Free Trial Structure**
- **Duration:** 7 days
- **Credit Card:** Not required
- **Access:** Full access to 1 certification
- **Limits:**
  - ✅ Unlimited benchmark exam attempts
  - ✅ 50 practice questions per day
  - ✅ Full performance tracking
  - ✅ Study plan and recommendations
  - ❌ Cannot enroll in 2nd certification (upgrade required)
  - ❌ Cannot download study materials (upgrade required)
  - ❌ Cannot access mock exams (upgrade required)

#### **Pricing Tiers (Optimized for Conversion)**

| Plan | Price | Type | Target Audience | Conversion Goal |
|------|-------|------|-----------------|-----------------|
| **Single Certification** | **$39** | One-time | Focused learners, single cert goal | Immediate conversion |
| **All-Access Monthly** | **$24/mo** | Subscription | Multi-cert learners, explorers | Recurring revenue |
| **All-Access Annual** | **$199/yr** | Subscription | Serious learners, career changers | Highest LTV |

**Pricing Rationale:**

1. **Single Cert ($39):**
   - **Why $39?** Psychological pricing (under $40 threshold)
   - **Competitor analysis:** Most competitors charge $49-$79
   - **Value prop:** Lifetime access, unlimited practice
   - **Target:** 40% of conversions

2. **Monthly ($24/mo):**
   - **Why $24?** Under $25 threshold, feels "affordable"
   - **Annual equivalent:** $288/year (makes annual look like great deal)
   - **Value prop:** Try multiple certs, cancel anytime
   - **Target:** 30% of conversions

3. **Annual ($199/yr):**
   - **Why $199?** Under $200 threshold, 31% savings vs monthly
   - **Monthly equivalent:** $16.58/month (emphasize this)
   - **Value prop:** Best value, 2+ months free
   - **Target:** 30% of conversions (highest LTV)

**Revenue Projections:**

Assuming 1,000 trial users/month with 20% conversion:
- 200 conversions/month
- 80 single cert ($39) = $3,120
- 60 monthly ($24) = $1,440/mo × 12 = $17,280/yr
- 60 annual ($199) = $11,940
- **Total Year 1:** $32,340/month average = **$388,080/year**

---

### **Payment Processor Strategy**

#### **Dual Processor Support: Stripe + Paddle**

**Why Both?**

| Feature | Stripe | Paddle | Winner |
|---------|--------|--------|--------|
| **Transaction Fee** | 2.9% + $0.30 | 5% + $0.50 | Stripe |
| **Global Tax Handling** | Manual | Automatic (Merchant of Record) | Paddle |
| **Subscription Management** | Excellent | Excellent | Tie |
| **Developer Experience** | Best in class | Good | Stripe |
| **Compliance** | DIY | Handled by Paddle | Paddle |
| **Payout** | 2 days | 30 days | Stripe |

**Recommendation:**
- **Primary:** Stripe (lower fees, faster payouts, better UX)
- **Secondary:** Paddle (for international markets with complex tax requirements)
- **Admin Toggle:** Allow switching per region or globally

#### **Admin Payment Settings**

```php
// Admin can configure:
- Default payment processor (Stripe/Paddle)
- Stripe API keys (publishable, secret, webhook secret)
- Paddle vendor ID and auth code
- Tax handling preferences
- Currency settings
- Webhook endpoints
```

---

## Goals & Success Metrics

### Primary Goals

1. **Increase Organic Traffic:** Rank for "[certification name] practice questions" keywords
2. **Improve Trial Conversion:** 20%+ conversion from trial to paid
3. **Maximize Revenue per User:** Average $50+ per paying customer
4. **Reduce Churn:** <5% monthly churn for subscriptions
5. **Accelerate Onboarding:** Get users to benchmark exam in <10 minutes

### Success Metrics

| Metric | Baseline | Target | Measurement |
|--------|----------|--------|-------------|
| Organic Traffic to Cert Pages | TBD | +50% in 3 months | Google Analytics |
| Quiz Completion Rate | N/A | 40%+ | `landing_quiz_attempts` table |
| Quiz → Registration Conversion | N/A | 15%+ | `converted_to_registration` field |
| Trial → Paid Conversion | N/A | 20%+ | `learner_subscriptions` + `payments` |
| Average Revenue Per User (ARPU) | N/A | $50+ | Payment analytics |
| Time to First Benchmark Exam | TBD | <10 minutes | User journey tracking |
| Monthly Recurring Revenue (MRR) | TBD | $10,000+ in 6 months | Subscription analytics |
| Customer Lifetime Value (LTV) | TBD | $150+ | Cohort analysis |

---

## Technical Architecture

### System Components with Payment Integration

```
┌─────────────────────────────────────────────────────────────────────┐
│                    Certification Detail Page (Landing)               │
│  ┌─────────────┐  ┌──────────────┐  ┌──────────────────┐           │
│  │ SEO Content │  │ Quiz Section │  │ Trust Signals    │           │
│  │ - Why       │  │ - 5 Questions│  │ - Testimonials   │           │
│  │ - Who       │  │ - Results    │  │ - Success Rate   │           │
│  │ - How       │  │ - CTA        │  │ - Student Count  │           │
│  │ - FAQs      │  └──────┬───────┘  └──────────────────┘           │
│  └─────────────┘         │                                           │
└──────────────────────────┼───────────────────────────────────────────┘
                           │
                           ▼
                  ┌────────────────┐
                  │ Registration   │
                  │ (Free Trial)   │
                  └────────┬───────┘
                           │
              ┌────────────┴────────────┐
              │                         │
              ▼                         ▼
    ┌──────────────────┐    ┌──────────────────────┐
    │ Standard Flow    │    │ Cert-Specific Flow   │
    │ → Dashboard      │    │ → Auto-enroll        │
    │                  │    │ → Onboarding Page    │
    └────────┬─────────┘    └──────────┬───────────┘
             │                         │
             └────────────┬────────────┘
                          │
                          ▼
                ┌─────────────────────┐
                │ 7-Day Free Trial    │
                │ - Full Access       │
                │ - No CC Required    │
                │ - 1 Certification   │
                └─────────┬───────────┘
                          │
                          ▼
                ┌─────────────────────┐
                │ Trial Reminders     │
                │ - Day 5: Email      │
                │ - Day 6: Dashboard  │
                │ - Day 7: Paywall    │
                └─────────┬───────────┘
                          │
                          ▼
                ┌─────────────────────┐
                │ Pricing Page        │
                │ - Context-Aware     │
                │ - Progress Display  │
                │ - 3 Options         │
                └─────────┬───────────┘
                          │
              ┌───────────┼───────────┐
              │           │           │
              ▼           ▼           ▼
        ┌─────────┐ ┌─────────┐ ┌─────────┐
        │ Single  │ │ Monthly │ │ Annual  │
        │ $39     │ │ $24/mo  │ │ $199/yr │
        └────┬────┘ └────┬────┘ └────┬────┘
             │           │           │
             └───────────┼───────────┘
                         │
                         ▼
                ┌─────────────────────┐
                │ Payment Processor   │
                │ - Stripe (Primary)  │
                │ - Paddle (Secondary)│
                └─────────┬───────────┘
                          │
                          ▼
                ┌─────────────────────┐
                │ Payment Success     │
                │ - Update Sub Status │
                │ - Grant Access      │
                │ - Send Receipt      │
                └─────────┬───────────┘
                          │
                          ▼
                ┌─────────────────────┐
                │ Continue Learning   │
                │ - Unlimited Access  │
                │ - All Features      │
                └─────────────────────┘
```

---

## Database Schema

### **New Tables**

#### 1. `certification_landing_quiz_questions`

**Purpose:** Map 5 selected questions from each certification's question bank for landing page quiz.

```sql
CREATE TABLE certification_landing_quiz_questions (
    id CHAR(36) PRIMARY KEY,
    certification_id CHAR(36) NOT NULL,
    question_id CHAR(36) NOT NULL,
    `order` INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (certification_id) REFERENCES certifications(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    
    UNIQUE KEY unique_cert_question (certification_id, question_id),
    INDEX idx_certification (certification_id),
    INDEX idx_order (certification_id, `order`)
);
```

---

#### 2. `landing_quiz_attempts`

**Purpose:** Track guest quiz attempts for analytics and conversion tracking.

```sql
CREATE TABLE landing_quiz_attempts (
    id CHAR(36) PRIMARY KEY,
    certification_id CHAR(36) NOT NULL,
    session_id VARCHAR(255) NOT NULL,
    score INT NOT NULL COMMENT 'Score out of 5',
    answers JSON NULL COMMENT 'Array of {question_id, selected_answer, is_correct}',
    completed_at TIMESTAMP NULL,
    converted_to_registration BOOLEAN DEFAULT FALSE,
    learner_id CHAR(36) NULL COMMENT 'Set after registration if conversion happens',
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (certification_id) REFERENCES certifications(id) ON DELETE CASCADE,
    FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE SET NULL,
    
    INDEX idx_session (session_id),
    INDEX idx_certification (certification_id),
    INDEX idx_completed (completed_at),
    INDEX idx_converted (converted_to_registration),
    INDEX idx_cert_converted (certification_id, converted_to_registration)
);
```

---

#### 3. `payments` (New)

**Purpose:** Track all payment transactions (one-time and recurring).

```sql
CREATE TABLE payments (
    id CHAR(36) PRIMARY KEY,
    learner_id CHAR(36) NOT NULL,
    payment_type ENUM('single_cert', 'subscription_monthly', 'subscription_annual') NOT NULL,
    certification_id CHAR(36) NULL COMMENT 'For single cert purchases',
    subscription_plan_id CHAR(36) NULL COMMENT 'For subscription purchases',
    amount DECIMAL(10, 2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'USD',
    status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    payment_processor ENUM('stripe', 'paddle') NOT NULL,
    processor_payment_id VARCHAR(255) NULL COMMENT 'Stripe payment intent ID or Paddle order ID',
    processor_customer_id VARCHAR(255) NULL COMMENT 'Stripe customer ID or Paddle customer ID',
    metadata JSON NULL COMMENT 'Additional payment data',
    paid_at TIMESTAMP NULL,
    refunded_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
    FOREIGN KEY (certification_id) REFERENCES certifications(id) ON DELETE SET NULL,
    FOREIGN KEY (subscription_plan_id) REFERENCES subscription_plans(id) ON DELETE SET NULL,
    
    INDEX idx_learner (learner_id),
    INDEX idx_status (status),
    INDEX idx_processor (payment_processor, processor_payment_id),
    INDEX idx_paid_at (paid_at)
);
```

---

#### 4. `single_certification_purchases` (New)

**Purpose:** Track lifetime access purchases for individual certifications.

```sql
CREATE TABLE single_certification_purchases (
    id CHAR(36) PRIMARY KEY,
    learner_id CHAR(36) NOT NULL,
    certification_id CHAR(36) NOT NULL,
    payment_id CHAR(36) NOT NULL,
    price_paid DECIMAL(10, 2) NOT NULL,
    purchased_at TIMESTAMP NOT NULL,
    expires_at TIMESTAMP NULL COMMENT 'NULL = lifetime access',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
    FOREIGN KEY (certification_id) REFERENCES certifications(id) ON DELETE CASCADE,
    FOREIGN KEY (payment_id) REFERENCES payments(id) ON DELETE CASCADE,
    
    UNIQUE KEY unique_learner_cert (learner_id, certification_id),
    INDEX idx_learner (learner_id),
    INDEX idx_certification (certification_id),
    INDEX idx_active (is_active)
);
```

---

#### 5. `payment_processor_settings` (New)

**Purpose:** Store payment processor configuration (admin-configurable).

```sql
CREATE TABLE payment_processor_settings (
    id CHAR(36) PRIMARY KEY,
    processor ENUM('stripe', 'paddle') NOT NULL,
    is_active BOOLEAN DEFAULT FALSE,
    is_default BOOLEAN DEFAULT FALSE,
    config JSON NOT NULL COMMENT 'Encrypted API keys and settings',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    UNIQUE KEY unique_processor (processor)
);
```

**Config JSON Structure:**

```json
// Stripe
{
    "publishable_key": "pk_live_...",
    "secret_key": "sk_live_...", // Encrypted
    "webhook_secret": "whsec_...", // Encrypted
    "currency": "USD",
    "statement_descriptor": "SISUKAI"
}

// Paddle
{
    "vendor_id": "12345",
    "vendor_auth_code": "abc123...", // Encrypted
    "public_key": "pk_...",
    "environment": "production", // or "sandbox"
    "currency": "USD"
}
```

---

### **Modified Tables**

#### 1. `subscription_plans` (Update)

**Add fields for better pricing display:**

```sql
ALTER TABLE subscription_plans 
ADD COLUMN stripe_price_id_monthly VARCHAR(255) NULL AFTER price_monthly,
ADD COLUMN stripe_price_id_annual VARCHAR(255) NULL AFTER price_annual,
ADD COLUMN paddle_plan_id_monthly VARCHAR(255) NULL AFTER stripe_price_id_annual,
ADD COLUMN paddle_plan_id_annual VARCHAR(255) NULL AFTER paddle_plan_id_monthly,
ADD COLUMN savings_percentage INT NULL COMMENT 'Annual savings vs monthly',
ADD COLUMN is_popular BOOLEAN DEFAULT FALSE COMMENT 'Show "Most Popular" badge';
```

---

#### 2. `learner_subscriptions` (Update)

**Add payment processor tracking:**

```sql
ALTER TABLE learner_subscriptions 
ADD COLUMN payment_processor ENUM('stripe', 'paddle') NULL AFTER subscription_plan_id,
ADD COLUMN processor_subscription_id VARCHAR(255) NULL COMMENT 'Stripe subscription ID or Paddle subscription ID',
ADD COLUMN processor_customer_id VARCHAR(255) NULL COMMENT 'Stripe customer ID or Paddle customer ID',
ADD COLUMN next_billing_date TIMESTAMP NULL,
ADD COLUMN auto_renew BOOLEAN DEFAULT TRUE;
```

---

#### 3. `learners` (Update)

**Add trial tracking:**

```sql
ALTER TABLE learners 
ADD COLUMN trial_started_at TIMESTAMP NULL,
ADD COLUMN trial_ends_at TIMESTAMP NULL,
ADD COLUMN trial_certification_id CHAR(36) NULL COMMENT 'Certification enrolled during trial',
ADD COLUMN has_had_trial BOOLEAN DEFAULT FALSE COMMENT 'Prevent multiple trials',
ADD COLUMN stripe_customer_id VARCHAR(255) NULL,
ADD COLUMN paddle_customer_id VARCHAR(255) NULL;
```

---

## Pricing Optimization

### **Conversion-Optimized Pricing Structure**

#### **Pricing Psychology Applied:**

1. **Anchor Pricing:** Show annual plan first (highest value)
2. **Decoy Effect:** Monthly plan makes annual look like better deal
3. **Loss Aversion:** Show what they'll lose if trial expires
4. **Social Proof:** "Most popular" badge on recommended plan
5. **Urgency:** "X people upgraded today"

#### **Pricing Display (Optimized Layout):**

```
┌─────────────────────────────────────────────────────────────┐
│              Choose Your Plan to Continue Learning           │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐     │
│  │ Single Cert  │  │ All-Access   │  │ All-Access   │     │
│  │              │  │ Monthly      │  │ Annual       │     │
│  │              │  │ [MOST POPULAR]│  │ [BEST VALUE] │     │
│  ├──────────────┤  ├──────────────┤  ├──────────────┤     │
│  │              │  │              │  │              │     │
│  │    $39       │  │   $24/mo     │  │   $199/yr    │     │
│  │  one-time    │  │              │  │  ($16.58/mo) │     │
│  │              │  │              │  │              │     │
│  ├──────────────┤  ├──────────────┤  ├──────────────┤     │
│  │ ✓ Lifetime   │  │ ✓ All 18     │  │ ✓ All 18     │     │
│  │   access to  │  │   certs      │  │   certs      │     │
│  │   AWS CCP    │  │ ✓ Unlimited  │  │ ✓ Unlimited  │     │
│  │ ✓ Unlimited  │  │   practice   │  │   practice   │     │
│  │   practice   │  │ ✓ Cancel     │  │ ✓ Save 31%   │     │
│  │ ✓ Tracking   │  │   anytime    │  │ ✓ 2 months   │     │
│  │              │  │              │  │   FREE       │     │
│  ├──────────────┤  ├──────────────┤  ├──────────────┤     │
│  │ [Select]     │  │ [Select]     │  │ [Select]     │     │
│  └──────────────┘  └──────────────┘  └──────────────┘     │
│                                                              │
│  💳 Secure payment powered by Stripe                        │
│  🔒 30-day money-back guarantee                             │
│  ⚡ Instant access after payment                            │
└─────────────────────────────────────────────────────────────┘
```

#### **Dynamic Pricing Recommendations:**

Based on user behavior, show personalized recommendations:

| User Behavior | Recommended Plan | Reason |
|---------------|------------------|--------|
| Took quiz for 1 cert only | Single Cert ($39) | Focused learner |
| Viewed 3+ cert pages | All-Access Monthly | Exploring multiple certs |
| High quiz score (4-5/5) | All-Access Annual | Serious, likely to commit |
| Low quiz score (1-2/5) | All-Access Monthly | Needs more time, lower commitment |
| Returning visitor | All-Access Annual | Higher intent |

---

### **Pricing Consistency Across Platform**

#### **Landing Page (Guest):**
- Show all 3 pricing options
- Emphasize "7-day free trial, no credit card"
- CTA: "Start Free Trial"

#### **Learner Dashboard (Trial Active):**
- Show trial countdown
- Soft CTA: "Upgrade anytime"
- No aggressive upselling during trial

#### **Paywall (Trial Ended):**
- Show progress stats (questions answered, score improvement)
- Emphasize value: "Don't lose your progress"
- Recommended plan based on usage

#### **Admin Portal:**
- View all pricing plans
- Edit prices (with audit log)
- Set featured/popular badges
- Configure payment processors
- View conversion metrics by plan

---

## Implementation Phases

### **Phase 1: Database Setup & Payment Infrastructure** (2 hours)

**Tasks:**
1. Create migrations for new tables
2. Update existing tables (subscriptions, learners)
3. Create models with relationships
4. Seed default subscription plans
5. Create payment processor settings table

**Deliverables:**
- ✅ `2025_11_10_create_certification_landing_quiz_questions_table.php`
- ✅ `2025_11_10_create_landing_quiz_attempts_table.php`
- ✅ `2025_11_10_create_payments_table.php`
- ✅ `2025_11_10_create_single_certification_purchases_table.php`
- ✅ `2025_11_10_create_payment_processor_settings_table.php`
- ✅ `2025_11_10_update_subscription_plans_table.php`
- ✅ `2025_11_10_update_learner_subscriptions_table.php`
- ✅ `2025_11_10_update_learners_table.php`
- ✅ Models: `Payment`, `SingleCertificationPurchase`, `PaymentProcessorSetting`
- ✅ Seeder: `SubscriptionPlansSeeder` (3 plans with optimized pricing)

**Subscription Plans Seed Data:**

```php
SubscriptionPlan::create([
    'name' => 'All-Access Monthly',
    'slug' => 'all-access-monthly',
    'description' => 'Full access to all certifications with monthly billing',
    'price_monthly' => 24.00,
    'price_annual' => null,
    'trial_days' => 7,
    'certification_limit' => null, // unlimited
    'features' => [
        'All 18 certifications',
        'Unlimited practice questions',
        'Unlimited benchmark exams',
        'Performance analytics',
        'Study plan recommendations',
        'Cancel anytime'
    ],
    'has_analytics' => true,
    'has_practice_sessions' => true,
    'has_benchmark_exams' => true,
    'is_active' => true,
    'is_featured' => false,
    'is_popular' => true, // "Most Popular" badge
    'sort_order' => 2,
]);

SubscriptionPlan::create([
    'name' => 'All-Access Annual',
    'slug' => 'all-access-annual',
    'description' => 'Full access to all certifications with annual billing (save 31%)',
    'price_monthly' => null,
    'price_annual' => 199.00,
    'trial_days' => 7,
    'certification_limit' => null,
    'features' => [
        'All 18 certifications',
        'Unlimited practice questions',
        'Unlimited benchmark exams',
        'Performance analytics',
        'Study plan recommendations',
        'Priority support',
        'Downloadable study materials',
        'Save 31% vs monthly'
    ],
    'has_analytics' => true,
    'has_practice_sessions' => true,
    'has_benchmark_exams' => true,
    'is_active' => true,
    'is_featured' => true, // "Best Value" badge
    'is_popular' => false,
    'savings_percentage' => 31,
    'sort_order' => 3,
]);
```

---

### **Phase 2: Payment Processor Integration** (3 hours)

**Tasks:**
1. Install Stripe PHP SDK
2. Install Paddle PHP SDK
3. Create payment service classes
4. Implement webhook handlers
5. Create admin settings interface
6. Test payment flows

**Deliverables:**

#### **2.1: Install Dependencies**

```bash
composer require stripe/stripe-php
composer require paddle/paddle-php-sdk
```

#### **2.2: Payment Service Classes**

```php
// app/Services/Payment/StripePaymentService.php
namespace App\Services\Payment;

use Stripe\StripeClient;
use App\Models\Payment;
use App\Models\Learner;

class StripePaymentService implements PaymentServiceInterface
{
    protected $stripe;
    
    public function __construct()
    {
        $settings = PaymentProcessorSetting::where('processor', 'stripe')->first();
        $config = json_decode($settings->config, true);
        
        $this->stripe = new StripeClient($config['secret_key']);
    }
    
    public function createCheckoutSession(Learner $learner, $planType, $amount, $metadata = [])
    {
        // Create or retrieve Stripe customer
        $customer = $this->getOrCreateCustomer($learner);
        
        // Create checkout session
        $session = $this->stripe->checkout->sessions->create([
            'customer' => $customer->id,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $metadata['product_name'] ?? 'SisuKai Subscription',
                    ],
                    'unit_amount' => $amount * 100, // Convert to cents
                ],
                'quantity' => 1,
            ]],
            'mode' => $planType === 'single_cert' ? 'payment' : 'subscription',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('pricing'),
            'metadata' => $metadata,
        ]);
        
        return $session;
    }
    
    public function handleWebhook($payload, $signature)
    {
        // Verify webhook signature
        // Process events: payment_intent.succeeded, subscription.created, etc.
        // Update database accordingly
    }
    
    // ... more methods
}
```

```php
// app/Services/Payment/PaddlePaymentService.php
namespace App\Services\Payment;

use Paddle\SDK\Client as PaddleClient;

class PaddlePaymentService implements PaymentServiceInterface
{
    protected $paddle;
    
    public function __construct()
    {
        $settings = PaymentProcessorSetting::where('processor', 'paddle')->first();
        $config = json_decode($settings->config, true);
        
        $this->paddle = new PaddleClient($config['vendor_auth_code']);
    }
    
    // Similar methods as Stripe
}
```

#### **2.3: Payment Controller**

```php
// app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use App\Services\Payment\PaymentServiceFactory;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'plan_type' => 'required|in:single_cert,subscription_monthly,subscription_annual',
            'certification_id' => 'required_if:plan_type,single_cert',
            'subscription_plan_id' => 'required_if:plan_type,subscription_monthly,subscription_annual',
        ]);
        
        $learner = auth('learner')->user();
        
        // Get payment processor (default or user preference)
        $processor = $this->getPaymentProcessor();
        
        // Create payment service
        $paymentService = PaymentServiceFactory::make($processor);
        
        // Calculate amount
        $amount = $this->calculateAmount($validated);
        
        // Create checkout session
        $session = $paymentService->createCheckoutSession($learner, $validated['plan_type'], $amount, [
            'learner_id' => $learner->id,
            'plan_type' => $validated['plan_type'],
            'certification_id' => $validated['certification_id'] ?? null,
            'subscription_plan_id' => $validated['subscription_plan_id'] ?? null,
        ]);
        
        // Store pending payment in database
        Payment::create([
            'learner_id' => $learner->id,
            'payment_type' => $validated['plan_type'],
            'certification_id' => $validated['certification_id'] ?? null,
            'subscription_plan_id' => $validated['subscription_plan_id'] ?? null,
            'amount' => $amount,
            'status' => 'pending',
            'payment_processor' => $processor,
            'processor_payment_id' => $session->id,
        ]);
        
        return response()->json([
            'checkout_url' => $session->url
        ]);
    }
    
    public function success(Request $request)
    {
        // Handle successful payment
        // Update payment status
        // Grant access to certification or subscription
        // Send confirmation email
        
        return redirect()->route('learner.dashboard')
            ->with('success', 'Payment successful! You now have full access.');
    }
    
    public function webhook(Request $request, $processor)
    {
        $paymentService = PaymentServiceFactory::make($processor);
        $paymentService->handleWebhook($request->getContent(), $request->header('Stripe-Signature'));
        
        return response()->json(['status' => 'success']);
    }
}
```

#### **2.4: Admin Payment Settings**

```php
// app/Http/Controllers/Admin/PaymentSettingsController.php
namespace App\Http\Controllers\Admin;

use App\Models\PaymentProcessorSetting;
use Illuminate\Http\Request;

class PaymentSettingsController extends Controller
{
    public function index()
    {
        $processors = PaymentProcessorSetting::all();
        return view('admin.settings.payment', compact('processors'));
    }
    
    public function update(Request $request, $processor)
    {
        $validated = $request->validate([
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'config' => 'required|array',
        ]);
        
        // Encrypt sensitive keys
        $config = $validated['config'];
        if (isset($config['secret_key'])) {
            $config['secret_key'] = encrypt($config['secret_key']);
        }
        if (isset($config['webhook_secret'])) {
            $config['webhook_secret'] = encrypt($config['webhook_secret']);
        }
        
        PaymentProcessorSetting::updateOrCreate(
            ['processor' => $processor],
            [
                'is_active' => $validated['is_active'],
                'is_default' => $validated['is_default'],
                'config' => json_encode($config),
            ]
        );
        
        return back()->with('success', 'Payment settings updated successfully.');
    }
}
```

**Admin View:**

```blade
<!-- resources/views/admin/settings/payment.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1>Payment Processor Settings</h1>
    
    <div class="row g-4 mt-3">
        <!-- Stripe Settings -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Stripe Configuration</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.payment-settings.update', 'stripe') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="stripe_active" value="1">
                                <label class="form-check-label" for="stripe_active">Enable Stripe</label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_default" id="stripe_default" value="1">
                                <label class="form-check-label" for="stripe_default">Set as Default</label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="stripe_publishable_key" class="form-label">Publishable Key</label>
                            <input type="text" class="form-control" name="config[publishable_key]" id="stripe_publishable_key" placeholder="pk_live_...">
                        </div>
                        
                        <div class="mb-3">
                            <label for="stripe_secret_key" class="form-label">Secret Key</label>
                            <input type="password" class="form-control" name="config[secret_key]" id="stripe_secret_key" placeholder="sk_live_...">
                            <small class="text-muted">Will be encrypted before storage</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="stripe_webhook_secret" class="form-label">Webhook Secret</label>
                            <input type="password" class="form-control" name="config[webhook_secret]" id="stripe_webhook_secret" placeholder="whsec_...">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save Stripe Settings</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Paddle Settings -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Paddle Configuration</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.payment-settings.update', 'paddle') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="paddle_active" value="1">
                                <label class="form-check-label" for="paddle_active">Enable Paddle</label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_default" id="paddle_default" value="1">
                                <label class="form-check-label" for="paddle_default">Set as Default</label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="paddle_vendor_id" class="form-label">Vendor ID</label>
                            <input type="text" class="form-control" name="config[vendor_id]" id="paddle_vendor_id" placeholder="12345">
                        </div>
                        
                        <div class="mb-3">
                            <label for="paddle_auth_code" class="form-label">Vendor Auth Code</label>
                            <input type="password" class="form-control" name="config[vendor_auth_code]" id="paddle_auth_code">
                            <small class="text-muted">Will be encrypted before storage</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="paddle_environment" class="form-label">Environment</label>
                            <select class="form-select" name="config[environment]" id="paddle_environment">
                                <option value="sandbox">Sandbox (Testing)</option>
                                <option value="production">Production</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save Paddle Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

---

### **Phase 3: Free Trial Management** (2 hours)

**Tasks:**
1. Create trial middleware
2. Implement trial start logic
3. Create trial reminder system
4. Build paywall component
5. Add trial status to dashboard

**Deliverables:**

#### **3.1: Trial Middleware**

```php
// app/Http/Middleware/CheckTrialStatus.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTrialStatus
{
    public function handle(Request $request, Closure $next)
    {
        $learner = auth('learner')->user();
        
        // Check if learner has active subscription or purchase
        if ($learner->hasActiveSubscription() || $learner->hasCertificationAccess($request->route('certification'))) {
            return $next($request);
        }
        
        // Check if trial is active
        if ($learner->isTrialActive()) {
            return $next($request);
        }
        
        // Trial expired, redirect to pricing
        return redirect()->route('pricing', [
            'trial_expired' => true,
            'certification' => $request->route('certification')->id ?? null
        ])->with('warning', 'Your free trial has ended. Upgrade to continue learning.');
    }
}
```

#### **3.2: Learner Model Methods**

```php
// app/Models/Learner.php (add methods)

public function startTrial(Certification $certification)
{
    $this->update([
        'trial_started_at' => now(),
        'trial_ends_at' => now()->addDays(7),
        'trial_certification_id' => $certification->id,
        'has_had_trial' => true,
    ]);
    
    // Auto-enroll in certification
    $this->certifications()->attach($certification->id, [
        'id' => Str::uuid(),
        'status' => 'enrolled',
        'enrolled_at' => now(),
    ]);
}

public function isTrialActive()
{
    return $this->trial_ends_at && $this->trial_ends_at->isFuture();
}

public function trialDaysRemaining()
{
    if (!$this->isTrialActive()) {
        return 0;
    }
    
    return now()->diffInDays($this->trial_ends_at, false);
}

public function hasActiveSubscription()
{
    return $this->subscriptions()
        ->where('status', 'active')
        ->where(function($q) {
            $q->whereNull('ends_at')
              ->orWhere('ends_at', '>', now());
        })
        ->exists();
}

public function hasCertificationAccess($certification)
{
    // Check if has active subscription (all certs)
    if ($this->hasActiveSubscription()) {
        return true;
    }
    
    // Check if purchased single cert
    return $this->singleCertificationPurchases()
        ->where('certification_id', $certification->id)
        ->where('is_active', true)
        ->exists();
}

public function canAccessFeature($feature)
{
    // During trial, full access
    if ($this->isTrialActive()) {
        return true;
    }
    
    // Check subscription plan features
    if ($this->hasActiveSubscription()) {
        $subscription = $this->subscriptions()->where('status', 'active')->first();
        return $subscription->plan->{"has_$feature"} ?? false;
    }
    
    return false;
}
```

#### **3.3: Trial Reminder Command**

```php
// app/Console/Commands/SendTrialReminders.php
namespace App\Console\Commands;

use App\Models\Learner;
use App\Mail\TrialEndingReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTrialReminders extends Command
{
    protected $signature = 'trial:send-reminders';
    protected $description = 'Send trial ending reminders to learners';
    
    public function handle()
    {
        // Find learners with trial ending in 2 days
        $learnersDay5 = Learner::whereNotNull('trial_ends_at')
            ->whereDate('trial_ends_at', now()->addDays(2)->toDateString())
            ->get();
        
        foreach ($learnersDay5 as $learner) {
            Mail::to($learner->email)->send(new TrialEndingReminderMail($learner, 2));
            $this->info("Sent 2-day reminder to {$learner->email}");
        }
        
        // Find learners with trial ending in 1 day
        $learnersDay6 = Learner::whereNotNull('trial_ends_at')
            ->whereDate('trial_ends_at', now()->addDays(1)->toDateString())
            ->get();
        
        foreach ($learnersDay6 as $learner) {
            Mail::to($learner->email)->send(new TrialEndingReminderMail($learner, 1));
            $this->info("Sent 1-day reminder to {$learner->email}");
        }
        
        $this->info('Trial reminders sent successfully.');
    }
}
```

**Schedule in `app/Console/Kernel.php`:**

```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('trial:send-reminders')->daily();
}
```

#### **3.4: Dashboard Trial Banner**

```blade
<!-- resources/views/learner/dashboard.blade.php -->
@if(auth('learner')->user()->isTrialActive())
    <div class="alert alert-info mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-clock-history me-2"></i>
                <strong>Free Trial Active</strong>
                <span class="ms-2">{{ auth('learner')->user()->trialDaysRemaining() }} days remaining</span>
            </div>
            <a href="{{ route('pricing') }}" class="btn btn-sm btn-primary">
                Upgrade Now
            </a>
        </div>
    </div>
@endif
```

---

### **Phase 4: Pricing Page** (2 hours)

**Tasks:**
1. Create pricing page controller
2. Build context-aware pricing view
3. Implement plan selection logic
4. Add progress stats display
5. Integrate with payment checkout

**Deliverables:**

```php
// app/Http/Controllers/PricingController.php
namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\Certification;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index(Request $request)
    {
        $context = [
            'source' => $request->query('source'), // 'trial_end', 'quiz', 'homepage'
            'certification_id' => $request->query('cert'),
            'trial_expired' => $request->query('trial_expired', false),
        ];
        
        $certification = null;
        if ($context['certification_id']) {
            $certification = Certification::where('slug', $context['certification_id'])
                ->orWhere('id', $context['certification_id'])
                ->first();
        }
        
        // Get subscription plans
        $plans = SubscriptionPlan::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        // Get learner stats (if authenticated and trial ending)
        $stats = null;
        if (auth('learner')->check() && $context['source'] === 'trial_end') {
            $learner = auth('learner')->user();
            $stats = [
                'questions_answered' => $learner->practiceSessionQuestions()->count(),
                'average_score' => round($learner->practiceSessions()->avg('score_percentage'), 1),
                'study_streak' => $this->calculateStudyStreak($learner),
                'domains_mastered' => $this->calculateDomainsMastered($learner),
            ];
        }
        
        return view('pricing', compact('plans', 'certification', 'context', 'stats'));
    }
    
    private function calculateStudyStreak($learner)
    {
        // Reuse logic from DashboardController
        // ...
    }
    
    private function calculateDomainsMastered($learner)
    {
        // Count domains where learner has >80% accuracy
        // ...
    }
}
```

**Pricing View:**

```blade
<!-- resources/views/pricing.blade.php -->
@extends('layouts.app')

@section('title', 'Choose Your Plan')

@section('content')
<div class="pricing-page py-5">
    <div class="container">
        <!-- Hero Section -->
        <div class="text-center mb-5">
            @if($context['source'] === 'trial_end')
                <h1 class="display-4 mb-3">Continue Your Learning Journey</h1>
                <p class="lead">Don't lose your progress! Choose a plan to keep learning.</p>
                
                @if($stats)
                    <div class="progress-summary mt-4">
                        <div class="row g-3 justify-content-center">
                            <div class="col-auto">
                                <div class="stat-card">
                                    <div class="stat-value">{{ $stats['questions_answered'] }}</div>
                                    <div class="stat-label">Questions Answered</div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stat-card">
                                    <div class="stat-value">{{ $stats['average_score'] }}%</div>
                                    <div class="stat-label">Average Score</div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stat-card">
                                    <div class="stat-value">{{ $stats['study_streak'] }}</div>
                                    <div class="stat-label">Day Streak</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <h1 class="display-4 mb-3">Choose Your Plan</h1>
                <p class="lead">Start your 7-day free trial. No credit card required.</p>
            @endif
        </div>
        
        <!-- Pricing Cards -->
        <div class="row g-4 justify-content-center">
            <!-- Single Certification -->
            @if($certification)
                <div class="col-lg-4">
                    <div class="pricing-card">
                        <div class="card h-100">
                            <div class="card-body p-4">
                                <h3 class="card-title">{{ $certification->name }}</h3>
                                <div class="price-display my-4">
                                    <span class="price">${{ number_format($certification->price_single_cert, 0) }}</span>
                                    <span class="period">one-time</span>
                                </div>
                                <ul class="feature-list list-unstyled">
                                    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Lifetime access</li>
                                    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Unlimited practice questions</li>
                                    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Unlimited benchmark exams</li>
                                    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Performance tracking</li>
                                </ul>
                                <button class="btn btn-outline-primary w-100 mt-4" 
                                        onclick="selectPlan('single_cert', '{{ $certification->id }}')">
                                    Select Plan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- All-Access Monthly -->
            <div class="col-lg-4">
                <div class="pricing-card">
                    <div class="card h-100 border-primary">
                        <div class="card-header bg-primary text-white text-center">
                            <strong>MOST POPULAR</strong>
                        </div>
                        <div class="card-body p-4">
                            <h3 class="card-title">All-Access Monthly</h3>
                            <div class="price-display my-4">
                                <span class="price">$24</span>
                                <span class="period">/month</span>
                            </div>
                            <ul class="feature-list list-unstyled">
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>All 18 certifications</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Unlimited everything</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Performance analytics</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Study plan recommendations</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Cancel anytime</li>
                            </ul>
                            <button class="btn btn-primary w-100 mt-4" 
                                    onclick="selectPlan('subscription_monthly', '{{ $plans->where('slug', 'all-access-monthly')->first()->id }}')">
                                Select Plan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- All-Access Annual -->
            <div class="col-lg-4">
                <div class="pricing-card">
                    <div class="card h-100 border-success">
                        <div class="card-header bg-success text-white text-center">
                            <strong>BEST VALUE</strong>
                        </div>
                        <div class="card-body p-4">
                            <h3 class="card-title">All-Access Annual</h3>
                            <div class="price-display my-4">
                                <span class="price">$199</span>
                                <span class="period">/year</span>
                                <div class="text-muted small mt-1">($16.58/month)</div>
                                <div class="badge bg-success mt-2">Save 31%</div>
                            </div>
                            <ul class="feature-list list-unstyled">
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>All 18 certifications</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Unlimited everything</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Priority support</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Downloadable materials</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>2 months FREE</li>
                            </ul>
                            <button class="btn btn-success w-100 mt-4" 
                                    onclick="selectPlan('subscription_annual', '{{ $plans->where('slug', 'all-access-annual')->first()->id }}')">
                                Select Plan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Trust Signals -->
        <div class="text-center mt-5">
            <p class="text-muted">
                <i class="bi bi-shield-check me-2"></i>Secure payment powered by Stripe
                <span class="mx-3">•</span>
                <i class="bi bi-arrow-clockwise me-2"></i>30-day money-back guarantee
                <span class="mx-3">•</span>
                <i class="bi bi-lightning-charge me-2"></i>Instant access
            </p>
        </div>
    </div>
</div>

<script>
function selectPlan(planType, id) {
    // Send to payment checkout
    fetch('/payment/checkout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            plan_type: planType,
            certification_id: planType === 'single_cert' ? id : null,
            subscription_plan_id: planType.startsWith('subscription') ? id : null
        })
    })
    .then(response => response.json())
    .then(data => {
        // Redirect to Stripe/Paddle checkout
        window.location.href = data.checkout_url;
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
    });
}
</script>
@endsection
```

---

### **Phase 5-10: Continue with Quiz, SEO, Analytics, Testing**

(Same as original plan, just integrated with payment flows)

---

## User Flows with Payment

### **Flow 1: Enhanced Flow (Cert Page → Quiz → Trial → Payment)**

```
1. User searches "AWS Cloud Practitioner practice questions" on Google
   ↓
2. Lands on /certifications/aws-certified-cloud-practitioner
   ↓
3. Reads SEO content, sees trust signals
   ↓
4. Takes 5-question quiz (2-3 minutes)
   ↓
5. Scores 3/5, sees: "Sign up for 7-day free trial to unlock full readiness report"
   ↓
6. Clicks "Start Free Trial"
   ↓
7. Registration form (no CC required)
   ↓
8. Submits form
   ↓
9. Trial started (trial_started_at, trial_ends_at set)
   ↓
10. Auto-enrolled in AWS CCP
   ↓
11. Redirects to /learner/certifications/{id}/onboarding
   ↓
12. Sees: "Welcome! Your 7-day trial started. Take benchmark exam."
   ↓
13. Takes benchmark exam
   ↓
14. Practices for 5-7 days
   ↓
15. Day 5: Email reminder "2 days left in trial"
   ↓
16. Day 6: Dashboard banner "1 day left - Upgrade now"
   ↓
17. Day 7: Soft paywall appears
   ↓
18. Shows progress: "45 questions, 78% score, 3-day streak"
   ↓
19. "Don't lose your progress! Choose a plan:"
   ↓
20. Pricing page with 3 options
   ↓
21. Selects "All-Access Annual ($199/yr)"
   ↓
22. Redirects to Stripe checkout
   ↓
23. Enters payment info
   ↓
24. Payment successful
   ↓
25. Webhook updates database:
    - Payment status: completed
    - Subscription status: active
    - Trial ends, subscription starts
   ↓
26. Redirects to dashboard
   ↓
27. Continues learning with full access
```

**Time to Conversion:** 7 days (trial period)  
**Expected Conversion Rate:** 20-25%

---

### **Flow 2: Standard Flow (Home → Trial → Payment)**

```
1. User lands on homepage
   ↓
2. Clicks "Start Free Trial"
   ↓
3. Registration form
   ↓
4. Trial started
   ↓
5. Dashboard → Browse certifications
   ↓
6. Enrolls in certification
   ↓
7. Takes benchmark, practices
   ↓
8. Day 7: Paywall
   ↓
9. Pricing page
   ↓
10. Payment
   ↓
11. Continues learning
```

**Time to Conversion:** 7 days  
**Expected Conversion Rate:** 15-20% (lower than enhanced flow)

---

## Free Trial Limits & Recommendations

### **Current Implementation (MVP):**

| Feature | Free Trial (7 days) | Paid Access |
|---------|---------------------|-------------|
| Certifications | 1 certification | Unlimited (subscription) or 1 (single cert) |
| Practice Questions | 50 per day | Unlimited |
| Benchmark Exams | Unlimited attempts | Unlimited |
| Mock Exams | ❌ Not available | ✅ Available |
| Study Materials Download | ❌ Not available | ✅ Available |
| Performance Analytics | ✅ Basic | ✅ Advanced |
| Study Plan | ✅ Basic | ✅ Personalized |

### **Future Recommendations:**

#### **Option A: Freemium Forever (Post-MVP)**

Convert trial to permanent free tier with limits:

| Feature | Free Forever | Paid |
|---------|--------------|------|
| Certifications | 1 | Unlimited |
| Practice Questions | 10 per day | Unlimited |
| Benchmark Exams | 1 attempt per month | Unlimited |
| Mock Exams | ❌ | ✅ |
| Explanations | Basic | Detailed |
| Analytics | ❌ | ✅ |

**Pros:**
- Larger user base
- More word-of-mouth growth
- Lower barrier to entry

**Cons:**
- Lower conversion rate (5-10%)
- Higher infrastructure costs
- Potential abuse

---

#### **Option B: Extended Trial for Referrals**

Reward users who refer friends:

- Base trial: 7 days
- +7 days per successful referral (friend signs up)
- Max 30 days total

**Pros:**
- Viral growth mechanism
- Higher engagement
- Qualified referrals

**Cons:**
- Complex tracking
- Potential gaming of system

---

#### **Option C: Feature-Gated Trial**

Instead of time limit, limit by features:

- Unlimited time
- But limited to:
  - 1 certification
  - 100 total practice questions (not per day)
  - 1 benchmark exam
  - No analytics

**Pros:**
- No pressure to convert quickly
- Users can fully evaluate
- Better for slow learners

**Cons:**
- Lower urgency
- Harder to track "trial end"
- May reduce conversion

---

**Recommendation for Post-MVP:** Stick with 7-day trial for now, then A/B test Option A (Freemium) vs current model after 6 months of data.

---

## Payment Integration

### **Stripe Integration Details**

#### **Products to Create in Stripe:**

1. **Single Certification (One-time Payment)**
   - Product: "SisuKai - [Certification Name]"
   - Price: $39 USD
   - Type: One-time payment
   - Metadata: `certification_id`, `type: single_cert`

2. **All-Access Monthly (Subscription)**
   - Product: "SisuKai All-Access"
   - Price: $24/month USD
   - Type: Recurring subscription
   - Trial: 7 days
   - Metadata: `plan_slug: all-access-monthly`

3. **All-Access Annual (Subscription)**
   - Product: "SisuKai All-Access Annual"
   - Price: $199/year USD
   - Type: Recurring subscription
   - Trial: 7 days
   - Metadata: `plan_slug: all-access-annual`

#### **Webhook Events to Handle:**

| Event | Action |
|-------|--------|
| `checkout.session.completed` | Create payment record, grant access |
| `payment_intent.succeeded` | Update payment status to completed |
| `payment_intent.payment_failed` | Update payment status to failed, notify user |
| `customer.subscription.created` | Create subscription record |
| `customer.subscription.updated` | Update subscription status |
| `customer.subscription.deleted` | Cancel subscription, revoke access |
| `invoice.payment_succeeded` | Record recurring payment |
| `invoice.payment_failed` | Notify user, retry payment |

---

### **Paddle Integration Details**

(Similar structure to Stripe, adjusted for Paddle's API)

---

## Analytics & Tracking

### **Payment Funnel Metrics**

```
Landing Page Views
    ↓ (40% take quiz)
Quiz Completions
    ↓ (15% click signup)
Registration Clicks
    ↓ (80% complete registration)
Trial Starts
    ↓ (20% convert to paid)
Paid Conversions
```

### **Revenue Metrics**

- **MRR (Monthly Recurring Revenue):** Sum of all active monthly subscriptions
- **ARR (Annual Recurring Revenue):** MRR × 12 + annual subscriptions
- **ARPU (Average Revenue Per User):** Total revenue / total users
- **LTV (Lifetime Value):** ARPU × average customer lifespan
- **CAC (Customer Acquisition Cost):** Marketing spend / new customers
- **LTV:CAC Ratio:** Should be >3:1 for healthy business

---

## Testing Plan

### **Payment Testing Checklist**

- [ ] Stripe test mode checkout works
- [ ] Paddle sandbox checkout works
- [ ] Single cert purchase grants access
- [ ] Monthly subscription grants access
- [ ] Annual subscription grants access
- [ ] Trial countdown displays correctly
- [ ] Trial reminders send on schedule
- [ ] Paywall appears after trial ends
- [ ] Webhook handlers process events correctly
- [ ] Payment records created in database
- [ ] Subscription status updates correctly
- [ ] Access revoked after subscription cancellation
- [ ] Refunds processed correctly
- [ ] Admin can view payment analytics
- [ ] Admin can switch payment processors

---

## Deployment Checklist

### **Pre-Deployment**

- [ ] Create Stripe account and get API keys
- [ ] Create Paddle account and get credentials
- [ ] Set up webhook endpoints in Stripe/Paddle
- [ ] Test payment flows in sandbox/test mode
- [ ] Configure email templates for trial reminders
- [ ] Set up cron job for trial reminders
- [ ] Review pricing and ensure consistency
- [ ] Test all user flows end-to-end

### **Deployment**

- [ ] Run database migrations
- [ ] Seed subscription plans
- [ ] Configure payment processor settings in admin
- [ ] Switch to production API keys
- [ ] Verify webhook endpoints are reachable
- [ ] Test one real payment (refund after)
- [ ] Monitor error logs for 24 hours

### **Post-Deployment**

- [ ] Set up revenue tracking dashboard
- [ ] Configure alerts for failed payments
- [ ] Monitor conversion funnel
- [ ] A/B test pricing page variations
- [ ] Collect user feedback on pricing

---

## Conclusion

This enhanced implementation plan integrates payment processing seamlessly into the certification landing page experience, creating a conversion-optimized funnel from guest → trial → paid customer.

**Key Features:**
- ✅ 7-day free trial (no CC required)
- ✅ Hybrid pricing (single cert + subscriptions)
- ✅ Dual payment processor support (Stripe + Paddle)
- ✅ Context-aware pricing page
- ✅ Soft paywall (value-reinforcing, not blocking)
- ✅ Admin payment settings
- ✅ Comprehensive analytics

**Expected Results:**
- 20%+ trial → paid conversion
- $50+ ARPU
- $10,000+ MRR in 6 months
- Scalable, maintainable payment infrastructure

**Total Implementation Time:** ~15-20 hours (including payment integration)

---

**Document Version:** 2.0 (With Payment Integration)  
**Last Updated:** November 10, 2025  
**Status:** Ready for Implementation 🚀
