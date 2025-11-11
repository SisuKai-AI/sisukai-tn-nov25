# Certification Landing Page - Gap Implementation Plan

**Project:** SisuKai MVP Platform  
**Document:** Implementation Plan for Landing Page Requirements Gaps  
**Date:** November 11, 2025  
**Status:** 📋 Ready for Implementation  
**Reference:** LANDING_PAGE_REQUIREMENTS_REVIEW.md

---

## Table of Contents

1. [Executive Summary](#executive-summary)
2. [Gap Analysis](#gap-analysis)
3. [Implementation Strategy](#implementation-strategy)
4. [Phase 1: V1 Completion](#phase-1-v1-completion)
5. [Phase 2: V2 Foundation](#phase-2-v2-foundation)
6. [Phase 3: V2 Payment Integration](#phase-3-v2-payment-integration)
7. [Phase 4: V2 Trial Management](#phase-4-v2-trial-management)
8. [Phase 5: V2 Pricing & Conversion](#phase-5-v2-pricing--conversion)
9. [Testing Strategy](#testing-strategy)
10. [Success Criteria](#success-criteria)
11. [Timeline & Resources](#timeline--resources)
12. [Risk Mitigation](#risk-mitigation)

---

## Executive Summary

### Current State

**V1 Completion:** 71% (5/7 features)  
**V2 Completion:** 0% (0/6 features)  
**Overall Completion:** 36%

**Production Status:**
- ✅ Content & Engagement: Production-ready
- ❌ Monetization: Not implemented

### Target State

**V1 Completion:** 100% (7/7 features)  
**V2 Completion:** 100% (6/6 features)  
**Overall Completion:** 100%

**Production Status:**
- ✅ Content & Engagement: Production-ready
- ✅ Monetization: Production-ready

### Implementation Approach

**Strategy:** Phased rollout with V1 completion first, then V2 monetization

**Rationale:**
1. **V1 First:** Completes content/engagement features for immediate traffic value
2. **V2 Second:** Adds monetization infrastructure for revenue generation
3. **Incremental:** Each phase delivers value independently
4. **Risk Mitigation:** Can launch V1 while building V2

**Timeline:** 4 weeks (2 weeks V1, 2 weeks V2)

---

## Gap Analysis

### V1 Gaps (Content & Engagement)

| # | Feature | Status | Priority | Effort | Impact |
|---|---------|--------|----------|--------|--------|
| 1 | Landing Quiz Attempts Tracking | ❌ Missing | 🔴 High | 4h | Analytics |
| 2 | Structured Data (Schema.org) | 🟡 Removed | 🟡 Medium | 3h | SEO |
| 3 | Smart Registration Flow | 🟡 Unverified | 🟡 Medium | 2h | UX |

**Total V1 Gaps:** 3 features, 9 hours

### V2 Gaps (Monetization)

| # | Feature | Status | Priority | Effort | Impact |
|---|---------|--------|----------|--------|--------|
| 1 | Payment Integration (Stripe) | ❌ Missing | 🔴 Critical | 12h | Revenue |
| 2 | Trial Management System | ❌ Missing | 🔴 Critical | 8h | Conversion |
| 3 | Pricing Page Flow | 🟡 Unverified | 🔴 High | 6h | Conversion |
| 4 | Payment Processor Admin UI | ❌ Missing | 🟡 Medium | 4h | Admin |
| 5 | Paddle Integration | ❌ Missing | 🟢 Low | 6h | Global |
| 6 | Analytics & Tracking | ❌ Missing | 🟡 Medium | 4h | Optimization |

**Total V2 Gaps:** 6 features, 40 hours

**Grand Total:** 9 features, 49 hours (~1.5 weeks of development)

---

## Implementation Strategy

### Phased Approach

```
Week 1: V1 Completion
├── Day 1-2: Landing Quiz Attempts Tracking (4h)
├── Day 3: Structured Data Re-implementation (3h)
└── Day 4: Smart Registration Flow Verification (2h)

Week 2-3: V2 Foundation & Payment
├── Day 5-6: Payment Integration - Stripe (12h)
├── Day 7-8: Trial Management System (8h)
└── Day 9: Pricing Page Flow (6h)

Week 4: V2 Polish & Launch
├── Day 10: Payment Processor Admin UI (4h)
├── Day 11: Analytics & Tracking (4h)
├── Day 12: Paddle Integration (Optional) (6h)
└── Day 13-14: Testing & Deployment
```

### Dependency Chain

```
Phase 1 (V1) → Phase 2 (V2 Foundation) → Phase 3 (V2 Payment) → Phase 4 (V2 Trial) → Phase 5 (V2 Pricing)
     ↓                    ↓                       ↓                      ↓                    ↓
  Analytics         Database Schema        Stripe Setup          Trial Logic         Pricing Page
  Structured Data   Payment Models         Checkout Flow         Reminders           Context-Aware
  Registration      Seeder Updates         Webhooks              Paywall             Conversion
```

---

## Phase 1: V1 Completion (Week 1, 9 hours)

### Goal
Complete all V1 content and engagement features to achieve 100% V1 compliance.

---

### Task 1.1: Landing Quiz Attempts Tracking (4 hours)

**Objective:** Track guest quiz attempts for analytics and conversion tracking

**Deliverables:**

#### 1.1.1: Create Migration

```bash
php artisan make:migration create_landing_quiz_attempts_table
```

```php
// database/migrations/2025_11_11_create_landing_quiz_attempts_table.php
Schema::create('landing_quiz_attempts', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->foreignUuid('certification_id')->constrained()->onDelete('cascade');
    $table->string('session_id')->index();
    $table->integer('score')->comment('Score out of 5');
    $table->json('answers')->nullable()->comment('Array of {question_id, selected_answer, is_correct}');
    $table->timestamp('completed_at')->nullable()->index();
    $table->boolean('converted_to_registration')->default(false)->index();
    $table->foreignUuid('learner_id')->nullable()->constrained()->onDelete('set null');
    $table->string('ip_address', 45)->nullable();
    $table->text('user_agent')->nullable();
    $table->timestamps();
    
    $table->index(['certification_id', 'converted_to_registration']);
});
```

#### 1.1.2: Create Model

```php
// app/Models/LandingQuizAttempt.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LandingQuizAttempt extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'certification_id',
        'session_id',
        'score',
        'answers',
        'completed_at',
        'converted_to_registration',
        'learner_id',
        'ip_address',
        'user_agent',
    ];
    
    protected $casts = [
        'answers' => 'array',
        'completed_at' => 'datetime',
        'converted_to_registration' => 'boolean',
    ];
    
    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }
    
    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }
}
```

#### 1.1.3: Update Quiz Component

```javascript
// resources/views/landing/certifications/partials/quiz-component.blade.php
// Add to quizComponent() function:

async completeQuiz() {
    const score = this.questions.filter(q => q.userAnswer === q.correctAnswer).length;
    
    // Save quiz attempt to database
    try {
        const response = await fetch('/api/landing-quiz/complete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                certification_id: '{{ $certification->id }}',
                score: score,
                answers: this.questions.map(q => ({
                    question_id: q.id,
                    selected_answer: q.userAnswer,
                    is_correct: q.userAnswer === q.correctAnswer
                }))
            })
        });
        
        const data = await response.json();
        console.log('Quiz attempt saved:', data.attempt_id);
    } catch (error) {
        console.error('Failed to save quiz attempt:', error);
    }
    
    // Show results
    this.showResults = true;
}
```

#### 1.1.4: Create API Route & Controller

```php
// routes/api.php
Route::post('/landing-quiz/complete', [LandingQuizController::class, 'complete']);
```

```php
// app/Http/Controllers/Api/LandingQuizController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LandingQuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LandingQuizController extends Controller
{
    public function complete(Request $request)
    {
        $validated = $request->validate([
            'certification_id' => 'required|exists:certifications,id',
            'score' => 'required|integer|min:0|max:5',
            'answers' => 'required|array|size:5',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.selected_answer' => 'required|string',
            'answers.*.is_correct' => 'required|boolean',
        ]);
        
        $attempt = LandingQuizAttempt::create([
            'certification_id' => $validated['certification_id'],
            'session_id' => session()->getId(),
            'score' => $validated['score'],
            'answers' => $validated['answers'],
            'completed_at' => now(),
            'converted_to_registration' => false,
            'learner_id' => auth('learner')->id() ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        
        return response()->json([
            'success' => true,
            'attempt_id' => $attempt->id,
            'score' => $attempt->score,
        ]);
    }
}
```

#### 1.1.5: Track Conversion on Registration

```php
// app/Http/Controllers/Auth/LearnerRegisterController.php
// Add to store() method after learner creation:

// Check if user completed quiz before registering
$quizAttempt = LandingQuizAttempt::where('session_id', session()->getId())
    ->whereNull('learner_id')
    ->latest()
    ->first();

if ($quizAttempt) {
    $quizAttempt->update([
        'learner_id' => $learner->id,
        'converted_to_registration' => true,
    ]);
}
```

**Testing:**
```bash
php artisan migrate
# Complete quiz on landing page
# Check database: SELECT * FROM landing_quiz_attempts;
# Register and verify conversion tracking
```

---

### Task 1.2: Structured Data Re-implementation (3 hours)

**Objective:** Re-add Schema.org structured data without Blade compilation errors

**Issue:** Previous implementation caused Blade compilation errors due to @push/@section ordering

**Solution:** Use inline JSON-LD in the view instead of @push

**Deliverables:**

#### 1.2.1: Add Structured Data to View

```blade
<!-- resources/views/landing/certifications/show.blade.php -->
<!-- Add before closing </body> tag -->

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Course",
  "name": "{{ $certification->name }} Certification Preparation",
  "description": "{{ $certification->description }}",
  "provider": {
    "@type": "Organization",
    "name": "SisuKai",
    "url": "{{ url('/') }}"
  },
  "educationalLevel": "Professional",
  "numberOfQuestions": {{ $certification->questions_count }},
  "timeRequired": "PT{{ $certification->exam_duration }}M",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.8",
    "reviewCount": "{{ $certification->learners_count }}"
  },
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "USD",
    "availability": "https://schema.org/InStock",
    "validFrom": "{{ now()->toIso8601String() }}"
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "How many practice questions are included?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Our {{ $certification->name }} course includes {{ $certification->questions_count }}+ practice questions covering all exam domains."
      }
    },
    {
      "@type": "Question",
      "name": "How long does it take to prepare?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Most students are exam-ready within 2-4 weeks of consistent practice using our adaptive learning system."
      }
    },
    {
      "@type": "Question",
      "name": "Is there a money-back guarantee?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes! If you don't pass your exam after completing our course, we'll refund your purchase in full."
      }
    }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "{{ url('/') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Certifications",
      "item": "{{ route('certifications.index') }}"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "{{ $certification->name }}",
      "item": "{{ route('certifications.show', $certification->slug) }}"
    }
  ]
}
</script>
```

**Testing:**
```bash
# Test with Google Rich Results Test
# https://search.google.com/test/rich-results
# Paste URL: https://sisukai.com/certifications/aws-certified-cloud-practitioner
# Verify Course, FAQPage, and BreadcrumbList schemas are detected
```

---

### Task 1.3: Smart Registration Flow Verification (2 hours)

**Objective:** Verify and document certification-specific registration flow

**Deliverables:**

#### 1.3.1: Test Registration from Certification Page

**Test Steps:**
1. Navigate to `/certifications/aws-certified-cloud-practitioner`
2. Click "Start 7-Day Free Trial" or "Start Free Quiz"
3. Complete quiz (if applicable)
4. Click "Sign Up" or registration CTA
5. Complete registration form
6. Verify:
   - ✅ Redirected to dashboard or onboarding page
   - ✅ Certification context preserved (auto-enrolled?)
   - ✅ Trial started automatically
   - ✅ Welcome email mentions certification

#### 1.3.2: Update Registration Controller (if needed)

```php
// app/Http/Controllers/Auth/LearnerRegisterController.php

public function store(Request $request)
{
    // ... existing validation ...
    
    $learner = Learner::create([
        // ... existing fields ...
    ]);
    
    // Check if registration came from certification page
    $certificationId = session('registration_certification_id');
    
    if ($certificationId) {
        $certification = Certification::find($certificationId);
        
        if ($certification) {
            // Auto-enroll in certification
            $learner->certifications()->attach($certification->id, [
                'id' => Str::uuid(),
                'status' => 'enrolled',
                'enrolled_at' => now(),
            ]);
            
            // Start 7-day free trial
            $learner->update([
                'trial_started_at' => now(),
                'trial_ends_at' => now()->addDays(7),
                'trial_certification_id' => $certification->id,
                'has_had_trial' => true,
            ]);
            
            // Redirect to certification-specific onboarding
            return redirect()->route('learner.onboarding', [
                'certification' => $certification->slug
            ]);
        }
    }
    
    // Standard flow
    return redirect()->route('learner.dashboard');
}
```

#### 1.3.3: Add Certification Context to Registration Link

```blade
<!-- resources/views/landing/certifications/show.blade.php -->
<!-- Update all "Start Free Trial" links: -->

<a href="{{ route('learner.register', ['cert' => $certification->slug]) }}" 
   class="btn btn-primary"
   onclick="sessionStorage.setItem('registration_certification_id', '{{ $certification->id }}')">
    Start 7-Day Free Trial
</a>
```

```php
// routes/web.php
Route::get('/register', [LearnerRegisterController::class, 'create'])
    ->name('learner.register');
```

```php
// app/Http/Controllers/Auth/LearnerRegisterController.php

public function create(Request $request)
{
    // Store certification context in session
    if ($request->has('cert')) {
        $certification = Certification::where('slug', $request->cert)->first();
        if ($certification) {
            session(['registration_certification_id' => $certification->id]);
        }
    }
    
    return view('auth.learner.register');
}
```

**Testing:**
```bash
# Test flow:
1. Visit /certifications/aws-certified-cloud-practitioner
2. Click "Start Free Trial"
3. Verify URL: /register?cert=aws-certified-cloud-practitioner
4. Complete registration
5. Verify auto-enrollment in certification
6. Verify trial started
```

**Documentation:**
- Document expected behavior in `docs/SMART_REGISTRATION_FLOW.md`
- Include test cases and verification steps

---

## Phase 2: V2 Foundation (Day 5, 4 hours)

### Goal
Set up database schema and models for V2 monetization features

---

### Task 2.1: Verify Payment Tables (1 hour)

**Objective:** Ensure all payment-related tables exist

**Deliverables:**

#### 2.1.1: Check Existing Tables

```bash
php artisan tinker
>>> Schema::hasTable('payments')
>>> Schema::hasTable('payment_processor_settings')
>>> Schema::hasTable('single_certification_purchases')
>>> Schema::hasTable('subscription_plans')
>>> Schema::hasTable('learner_subscriptions')
```

#### 2.1.2: Create Missing Tables (if needed)

**If `payments` table doesn't exist:**

```bash
php artisan make:migration create_payments_table
```

```php
Schema::create('payments', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->foreignUuid('learner_id')->constrained()->onDelete('cascade');
    $table->string('payment_type'); // 'single_cert', 'subscription_monthly', 'subscription_annual'
    $table->foreignUuid('certification_id')->nullable()->constrained()->onDelete('set null');
    $table->foreignUuid('subscription_plan_id')->nullable()->constrained()->onDelete('set null');
    $table->decimal('amount', 10, 2);
    $table->string('currency', 3)->default('USD');
    $table->string('status'); // 'pending', 'completed', 'failed', 'refunded'
    $table->string('payment_processor'); // 'stripe', 'paddle'
    $table->string('processor_payment_id')->nullable();
    $table->string('processor_customer_id')->nullable();
    $table->json('metadata')->nullable();
    $table->timestamp('paid_at')->nullable();
    $table->timestamps();
    
    $table->index(['learner_id', 'status']);
    $table->index('processor_payment_id');
});
```

**If `single_certification_purchases` table doesn't exist:**

```bash
php artisan make:migration create_single_certification_purchases_table
```

```php
Schema::create('single_certification_purchases', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->foreignUuid('learner_id')->constrained()->onDelete('cascade');
    $table->foreignUuid('certification_id')->constrained()->onDelete('cascade');
    $table->foreignUuid('payment_id')->constrained()->onDelete('cascade');
    $table->boolean('is_active')->default(true);
    $table->timestamp('purchased_at');
    $table->timestamp('expires_at')->nullable();
    $table->timestamps();
    
    $table->unique(['learner_id', 'certification_id']);
    $table->index(['learner_id', 'is_active']);
});
```

#### 2.1.3: Run Migrations

```bash
php artisan migrate
```

---

### Task 2.2: Create Payment Models (1 hour)

**Deliverables:**

```php
// app/Models/Payment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Payment extends Model
{
    use HasUuids;
    
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
    ];
    
    protected $casts = [
        'metadata' => 'array',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];
    
    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }
    
    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }
    
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
    
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
    
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);
    }
}
```

```php
// app/Models/SingleCertificationPurchase.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SingleCertificationPurchase extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'learner_id',
        'certification_id',
        'payment_id',
        'is_active',
        'purchased_at',
        'expires_at',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'purchased_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
    
    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }
    
    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }
    
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
```

---

### Task 2.3: Update Subscription Plans Seeder (1 hour)

**Objective:** Ensure subscription plans match V2 pricing

**Deliverables:**

```php
// database/seeders/SubscriptionPlanSeeder.php

public function run()
{
    // Clear existing plans
    SubscriptionPlan::truncate();
    
    // Single Certification (One-time purchase, handled separately)
    // This is not a subscription plan, but we document it here for reference
    // Price: $39 one-time
    
    // All-Access Monthly
    SubscriptionPlan::create([
        'id' => Str::uuid(),
        'name' => 'All-Access Monthly',
        'slug' => 'all-access-monthly',
        'description' => 'Full access to all certifications with monthly billing. Cancel anytime.',
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
            'Cancel anytime',
        ],
        'has_analytics' => true,
        'has_practice_sessions' => true,
        'has_benchmark_exams' => true,
        'is_active' => true,
        'is_featured' => false,
        'is_popular' => true, // "Most Popular" badge
        'sort_order' => 2,
    ]);
    
    // All-Access Annual
    SubscriptionPlan::create([
        'id' => Str::uuid(),
        'name' => 'All-Access Annual',
        'slug' => 'all-access-annual',
        'description' => 'Full access to all certifications with annual billing. Save 31% vs monthly.',
        'price_monthly' => null,
        'price_annual' => 199.00,
        'trial_days' => 7,
        'certification_limit' => null, // unlimited
        'features' => [
            'All 18 certifications',
            'Unlimited practice questions',
            'Unlimited benchmark exams',
            'Performance analytics',
            'Study plan recommendations',
            'Priority support',
            'Downloadable study materials',
            'Save 31% vs monthly',
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
}
```

```bash
php artisan db:seed --class=SubscriptionPlanSeeder
```

---

### Task 2.4: Update Learner Model (1 hour)

**Objective:** Add trial and payment helper methods

**Deliverables:**

```php
// app/Models/Learner.php

// Add to existing model:

public function payments()
{
    return $this->hasMany(Payment::class);
}

public function singleCertificationPurchases()
{
    return $this->hasMany(SingleCertificationPurchase::class);
}

// Trial methods
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

// Subscription methods
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

// Access methods
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

---

## Phase 3: V2 Payment Integration (Days 5-6, 12 hours)

### Goal
Implement Stripe payment integration for single certification and subscription purchases

---

### Task 3.1: Install Stripe SDK (30 minutes)

**Deliverables:**

```bash
composer require stripe/stripe-php
```

```bash
# Add to .env
STRIPE_PUBLISHABLE_KEY=pk_test_...
STRIPE_SECRET_KEY=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
```

```bash
# Add to .env.example
STRIPE_PUBLISHABLE_KEY=
STRIPE_SECRET_KEY=
STRIPE_WEBHOOK_SECRET=
```

---

### Task 3.2: Create Payment Service (3 hours)

**Deliverables:**

```php
// app/Services/Payment/PaymentServiceInterface.php
namespace App\Services\Payment;

use App\Models\Learner;

interface PaymentServiceInterface
{
    public function createCheckoutSession(Learner $learner, string $planType, float $amount, array $metadata = []);
    public function handleWebhook(string $payload, string $signature);
    public function getCustomer(Learner $learner);
    public function createCustomer(Learner $learner);
}
```

```php
// app/Services/Payment/StripePaymentService.php
namespace App\Services\Payment;

use Stripe\StripeClient;
use Stripe\Exception\SignatureVerificationException;
use App\Models\Payment;
use App\Models\Learner;
use App\Models\PaymentProcessorSetting;

class StripePaymentService implements PaymentServiceInterface
{
    protected $stripe;
    protected $webhookSecret;
    
    public function __construct()
    {
        $settings = PaymentProcessorSetting::where('processor', 'stripe')
            ->where('is_active', true)
            ->first();
        
        if (!$settings) {
            throw new \Exception('Stripe is not configured');
        }
        
        $config = json_decode($settings->config, true);
        
        $this->stripe = new StripeClient($config['secret_key']);
        $this->webhookSecret = $config['webhook_secret'] ?? null;
    }
    
    public function createCheckoutSession(Learner $learner, string $planType, float $amount, array $metadata = [])
    {
        // Get or create Stripe customer
        $customer = $this->getOrCreateCustomer($learner);
        
        // Determine mode (payment or subscription)
        $mode = $planType === 'single_cert' ? 'payment' : 'subscription';
        
        // Create checkout session
        $session = $this->stripe->checkout->sessions->create([
            'customer' => $customer->id,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $metadata['product_name'] ?? 'SisuKai Certification',
                        'description' => $metadata['product_description'] ?? '',
                    ],
                    'unit_amount' => (int)($amount * 100), // Convert to cents
                    'recurring' => $mode === 'subscription' ? [
                        'interval' => $metadata['interval'] ?? 'month',
                    ] : null,
                ],
                'quantity' => 1,
            ]],
            'mode' => $mode,
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('pricing'),
            'metadata' => $metadata,
            'allow_promotion_codes' => true,
        ]);
        
        return $session;
    }
    
    protected function getOrCreateCustomer(Learner $learner)
    {
        // Check if learner already has Stripe customer ID
        if ($learner->stripe_customer_id) {
            try {
                return $this->stripe->customers->retrieve($learner->stripe_customer_id);
            } catch (\Exception $e) {
                // Customer not found, create new one
            }
        }
        
        // Create new customer
        $customer = $this->stripe->customers->create([
            'email' => $learner->email,
            'name' => $learner->name,
            'metadata' => [
                'learner_id' => $learner->id,
            ],
        ]);
        
        // Save customer ID to learner
        $learner->update(['stripe_customer_id' => $customer->id]);
        
        return $customer;
    }
    
    public function handleWebhook(string $payload, string $signature)
    {
        if (!$this->webhookSecret) {
            throw new \Exception('Stripe webhook secret not configured');
        }
        
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $signature,
                $this->webhookSecret
            );
        } catch (SignatureVerificationException $e) {
            throw new \Exception('Invalid webhook signature');
        }
        
        // Handle different event types
        switch ($event->type) {
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($event->data->object);
                break;
            
            case 'payment_intent.succeeded':
                $this->handlePaymentIntentSucceeded($event->data->object);
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
        }
    }
    
    protected function handleCheckoutSessionCompleted($session)
    {
        // Find payment by processor_payment_id
        $payment = Payment::where('processor_payment_id', $session->id)->first();
        
        if (!$payment) {
            \Log::warning('Payment not found for session: ' . $session->id);
            return;
        }
        
        // Mark payment as completed
        $payment->markAsCompleted();
        
        // Grant access based on payment type
        if ($payment->payment_type === 'single_cert') {
            $this->grantSingleCertificationAccess($payment);
        } else {
            $this->grantSubscriptionAccess($payment);
        }
    }
    
    protected function grantSingleCertificationAccess(Payment $payment)
    {
        SingleCertificationPurchase::create([
            'learner_id' => $payment->learner_id,
            'certification_id' => $payment->certification_id,
            'payment_id' => $payment->id,
            'is_active' => true,
            'purchased_at' => now(),
            'expires_at' => null, // Lifetime access
        ]);
        
        // Enroll learner in certification if not already enrolled
        $learner = $payment->learner;
        if (!$learner->certifications()->where('certification_id', $payment->certification_id)->exists()) {
            $learner->certifications()->attach($payment->certification_id, [
                'id' => Str::uuid(),
                'status' => 'enrolled',
                'enrolled_at' => now(),
            ]);
        }
    }
    
    protected function grantSubscriptionAccess(Payment $payment)
    {
        // Create or update learner subscription
        LearnerSubscription::updateOrCreate(
            [
                'learner_id' => $payment->learner_id,
                'subscription_plan_id' => $payment->subscription_plan_id,
            ],
            [
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => null,
                'stripe_subscription_id' => $payment->processor_payment_id,
            ]
        );
    }
    
    // ... other webhook handlers
}
```

---

### Task 3.3: Create Payment Controller (3 hours)

**Deliverables:**

```php
// app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use App\Services\Payment\StripePaymentService;
use App\Models\Payment;
use App\Models\Certification;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $stripeService;
    
    public function __construct(StripePaymentService $stripeService)
    {
        $this->middleware('auth:learner');
        $this->stripeService = $stripeService;
    }
    
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'plan_type' => 'required|in:single_cert,subscription_monthly,subscription_annual',
            'certification_id' => 'required_if:plan_type,single_cert|exists:certifications,id',
            'subscription_plan_id' => 'required_if:plan_type,subscription_monthly,subscription_annual|exists:subscription_plans,id',
        ]);
        
        $learner = auth('learner')->user();
        
        // Calculate amount and get product details
        [$amount, $productName, $productDescription, $interval] = $this->getPaymentDetails($validated);
        
        // Create pending payment record
        $payment = Payment::create([
            'learner_id' => $learner->id,
            'payment_type' => $validated['plan_type'],
            'certification_id' => $validated['certification_id'] ?? null,
            'subscription_plan_id' => $validated['subscription_plan_id'] ?? null,
            'amount' => $amount,
            'currency' => 'USD',
            'status' => 'pending',
            'payment_processor' => 'stripe',
            'processor_payment_id' => null, // Will be set after session creation
        ]);
        
        // Create Stripe checkout session
        $session = $this->stripeService->createCheckoutSession(
            $learner,
            $validated['plan_type'],
            $amount,
            [
                'payment_id' => $payment->id,
                'product_name' => $productName,
                'product_description' => $productDescription,
                'interval' => $interval,
                'learner_id' => $learner->id,
                'certification_id' => $validated['certification_id'] ?? null,
                'subscription_plan_id' => $validated['subscription_plan_id'] ?? null,
            ]
        );
        
        // Update payment with session ID
        $payment->update(['processor_payment_id' => $session->id]);
        
        return response()->json([
            'checkout_url' => $session->url
        ]);
    }
    
    protected function getPaymentDetails(array $validated)
    {
        if ($validated['plan_type'] === 'single_cert') {
            $certification = Certification::findOrFail($validated['certification_id']);
            return [
                39.00,
                $certification->name . ' Certification',
                'Lifetime access to ' . $certification->name . ' practice questions and exams',
                null,
            ];
        }
        
        $plan = SubscriptionPlan::findOrFail($validated['subscription_plan_id']);
        $amount = $plan->price_monthly ?? $plan->price_annual;
        $interval = $plan->price_monthly ? 'month' : 'year';
        
        return [
            $amount,
            $plan->name,
            $plan->description,
            $interval,
        ];
    }
    
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if (!$sessionId) {
            return redirect()->route('learner.dashboard')
                ->with('error', 'Invalid payment session');
        }
        
        // Find payment by session ID
        $payment = Payment::where('processor_payment_id', $sessionId)->first();
        
        if (!$payment) {
            return redirect()->route('learner.dashboard')
                ->with('error', 'Payment not found');
        }
        
        // Payment will be marked as completed by webhook
        // Show success message
        return view('payment.success', compact('payment'));
    }
    
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        
        try {
            $this->stripeService->handleWebhook($payload, $signature);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            \Log::error('Stripe webhook error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
```

---

### Task 3.4: Create Routes (30 minutes)

**Deliverables:**

```php
// routes/web.php

// Payment routes (learner auth required)
Route::middleware('auth:learner')->group(function () {
    Route::post('/payment/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
});

// Webhook route (no auth, verified by signature)
Route::post('/webhook/stripe', [PaymentController::class, 'webhook'])->name('payment.webhook.stripe');
```

---

### Task 3.5: Create Payment Success View (1 hour)

**Deliverables:**

```blade
<!-- resources/views/payment/success.blade.php -->
@extends('layouts.learner')

@section('title', 'Payment Successful')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h1 class="h2 mb-3">Payment Successful!</h1>
                    
                    <p class="text-muted mb-4">
                        Thank you for your purchase. You now have full access to your certification.
                    </p>
                    
                    <div class="bg-light rounded p-4 mb-4">
                        <div class="row text-start">
                            <div class="col-6">
                                <small class="text-muted">Payment ID</small>
                                <div class="fw-medium">{{ Str::substr($payment->id, 0, 8) }}...</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Amount Paid</small>
                                <div class="fw-medium">${{ number_format($payment->amount, 2) }}</div>
                            </div>
                            <div class="col-12 mt-3">
                                <small class="text-muted">Purchase</small>
                                <div class="fw-medium">
                                    @if($payment->payment_type === 'single_cert')
                                        {{ $payment->certification->name }}
                                    @else
                                        {{ $payment->subscriptionPlan->name }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('learner.dashboard') }}" class="btn btn-primary btn-lg">
                            Go to Dashboard
                        </a>
                        
                        @if($payment->payment_type === 'single_cert')
                            <a href="{{ route('certifications.show', $payment->certification->slug) }}" 
                               class="btn btn-outline-primary btn-lg">
                                Start Learning
                            </a>
                        @endif
                    </div>
                    
                    <p class="text-muted mt-4 mb-0">
                        <small>A receipt has been sent to your email address.</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

---

### Task 3.6: Add Stripe Customer ID to Learners Table (30 minutes)

**Deliverables:**

```bash
php artisan make:migration add_stripe_customer_id_to_learners_table
```

```php
Schema::table('learners', function (Blueprint $table) {
    $table->string('stripe_customer_id')->nullable()->after('email');
    $table->index('stripe_customer_id');
});
```

```bash
php artisan migrate
```

---

### Task 3.7: Update PaymentProcessorSettingsSeeder (1 hour)

**Deliverables:**

```php
// database/seeders/PaymentProcessorSettingsSeeder.php

public function run()
{
    // Stripe
    PaymentProcessorSetting::updateOrCreate(
        ['processor' => 'stripe'],
        [
            'is_active' => true,
            'is_default' => true,
            'config' => json_encode([
                'publishable_key' => env('STRIPE_PUBLISHABLE_KEY'),
                'secret_key' => env('STRIPE_SECRET_KEY'),
                'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
            ]),
        ]
    );
    
    // Paddle (inactive by default)
    PaymentProcessorSetting::updateOrCreate(
        ['processor' => 'paddle'],
        [
            'is_active' => false,
            'is_default' => false,
            'config' => json_encode([
                'vendor_id' => env('PADDLE_VENDOR_ID'),
                'vendor_auth_code' => env('PADDLE_VENDOR_AUTH_CODE'),
                'public_key' => env('PADDLE_PUBLIC_KEY'),
            ]),
        ]
    );
}
```

```bash
php artisan db:seed --class=PaymentProcessorSettingsSeeder
```

---

### Task 3.8: Testing (3 hours)

**Test Cases:**

1. **Single Certification Purchase**
   - Navigate to pricing page
   - Select single certification ($39)
   - Complete Stripe checkout (test mode)
   - Verify payment success page
   - Verify database: `payments`, `single_certification_purchases`
   - Verify access granted to certification

2. **Monthly Subscription Purchase**
   - Navigate to pricing page
   - Select monthly subscription ($24/mo)
   - Complete Stripe checkout
   - Verify payment success page
   - Verify database: `payments`, `learner_subscriptions`
   - Verify access granted to all certifications

3. **Annual Subscription Purchase**
   - Navigate to pricing page
   - Select annual subscription ($199/yr)
   - Complete Stripe checkout
   - Verify payment success page
   - Verify savings badge displayed
   - Verify access granted

4. **Webhook Handling**
   - Use Stripe CLI to trigger test webhooks
   - Verify `checkout.session.completed` updates payment status
   - Verify `payment_intent.succeeded` grants access
   - Verify webhook logs in Laravel

**Stripe Test Cards:**
- Success: 4242 4242 4242 4242
- Decline: 4000 0000 0000 0002
- Requires authentication: 4000 0025 0000 3155

---

## Phase 4: V2 Trial Management (Days 7-8, 8 hours)

### Goal
Implement 7-day free trial system with reminders and paywall

---

### Task 4.1: Trial Middleware (2 hours)

**Deliverables:**

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
        
        if (!$learner) {
            return redirect()->route('learner.login');
        }
        
        // Check if learner has active subscription or purchase
        $certification = $request->route('certification');
        
        if ($learner->hasActiveSubscription() || ($certification && $learner->hasCertificationAccess($certification))) {
            return $next($request);
        }
        
        // Check if trial is active
        if ($learner->isTrialActive()) {
            return $next($request);
        }
        
        // Trial expired or no access, redirect to pricing
        return redirect()->route('pricing', [
            'trial_expired' => true,
            'certification' => $certification->id ?? null
        ])->with('warning', 'Your free trial has ended. Upgrade to continue learning.');
    }
}
```

```php
// app/Http/Kernel.php
protected $middlewareAliases = [
    // ... existing middleware
    'trial' => \App\Http\Middleware\CheckTrialStatus::class,
];
```

**Apply to routes:**

```php
// routes/web.php
Route::middleware(['auth:learner', 'trial'])->group(function () {
    Route::get('/practice/{certification}', [PracticeController::class, 'index'])->name('practice.index');
    Route::get('/exam/{certification}', [ExamController::class, 'index'])->name('exam.index');
    // ... other protected routes
});
```

---

### Task 4.2: Trial Reminder Command (2 hours)

**Deliverables:**

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
        // Find learners with trial ending in 2 days (Day 5)
        $learnersDay5 = Learner::whereNotNull('trial_ends_at')
            ->whereDate('trial_ends_at', now()->addDays(2)->toDateString())
            ->whereDoesntHave('subscriptions', function($q) {
                $q->where('status', 'active');
            })
            ->get();
        
        foreach ($learnersDay5 as $learner) {
            Mail::to($learner->email)->send(new TrialEndingReminderMail($learner, 2));
            $this->info("Sent 2-day reminder to {$learner->email}");
        }
        
        // Find learners with trial ending in 1 day (Day 6)
        $learnersDay6 = Learner::whereNotNull('trial_ends_at')
            ->whereDate('trial_ends_at', now()->addDays(1)->toDateString())
            ->whereDoesntHave('subscriptions', function($q) {
                $q->where('status', 'active');
            })
            ->get();
        
        foreach ($learnersDay6 as $learner) {
            Mail::to($learner->email)->send(new TrialEndingReminderMail($learner, 1));
            $this->info("Sent 1-day reminder to {$learner->email}");
        }
        
        $this->info('Trial reminders sent successfully.');
        $this->info("Day 5 reminders: {$learnersDay5->count()}");
        $this->info("Day 6 reminders: {$learnersDay6->count()}");
    }
}
```

**Schedule:**

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->command('trial:send-reminders')->dailyAt('09:00');
}
```

---

### Task 4.3: Trial Reminder Email (1 hour)

**Deliverables:**

```php
// app/Mail/TrialEndingReminderMail.php
namespace App\Mail;

use App\Models\Learner;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrialEndingReminderMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $learner;
    public $daysRemaining;
    
    public function __construct(Learner $learner, int $daysRemaining)
    {
        $this->learner = $learner;
        $this->daysRemaining = $daysRemaining;
    }
    
    public function build()
    {
        return $this->subject("Your SisuKai trial ends in {$this->daysRemaining} day" . ($this->daysRemaining > 1 ? 's' : ''))
            ->markdown('emails.trial-ending-reminder');
    }
}
```

```blade
{{-- resources/views/emails/trial-ending-reminder.blade.php --}}
@component('mail::message')
# Your Free Trial is Ending Soon

Hi {{ $learner->name }},

Your 7-day free trial of SisuKai will end in **{{ $daysRemaining }} day{{ $daysRemaining > 1 ? 's' : '' }}**.

@if($learner->trial_certification_id)
You've been studying for **{{ $learner->trialCertification->name }}**. Don't lose your progress!
@endif

## Upgrade Now to Continue Learning

Choose the plan that works best for you:

- **Single Certification** - $39 (lifetime access)
- **All-Access Monthly** - $24/month (cancel anytime)
- **All-Access Annual** - $199/year (save 31%)

@component('mail::button', ['url' => route('pricing')])
View Pricing Plans
@endcomponent

Thanks,<br>
The SisuKai Team
@endcomponent
```

---

### Task 4.4: Dashboard Trial Banner (1 hour)

**Deliverables:**

```blade
<!-- resources/views/learner/dashboard.blade.php -->
<!-- Add at top of content section -->

@if(auth('learner')->user()->isTrialActive())
    @php
        $daysRemaining = auth('learner')->user()->trialDaysRemaining();
        $alertClass = $daysRemaining <= 2 ? 'alert-warning' : 'alert-info';
    @endphp
    
    <div class="alert {{ $alertClass }} mb-4 d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-clock-history me-2"></i>
            <strong>Free Trial Active</strong>
            <span class="ms-2">
                {{ $daysRemaining }} day{{ $daysRemaining != 1 ? 's' : '' }} remaining
            </span>
            @if($daysRemaining <= 2)
                <span class="ms-2 text-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Upgrade soon to keep your progress!
                </span>
            @endif
        </div>
        <a href="{{ route('pricing') }}" class="btn btn-sm btn-primary">
            Upgrade Now
        </a>
    </div>
@endif
```

---

### Task 4.5: Paywall Component (2 hours)

**Deliverables:**

```blade
<!-- resources/views/components/paywall.blade.php -->
@props(['feature' => 'this feature', 'certification' => null])

<div class="modal fade" id="paywallModal" tabindex="-1" aria-labelledby="paywallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <i class="bi bi-lock-fill text-primary" style="font-size: 3rem;"></i>
                </div>
                
                <h3 class="mb-3">Upgrade to Access {{ $feature }}</h3>
                
                <p class="text-muted mb-4">
                    Your free trial has ended. Upgrade to continue learning and unlock all features.
                </p>
                
                @if($certification)
                    <div class="bg-light rounded p-3 mb-4">
                        <small class="text-muted d-block mb-1">Continue studying:</small>
                        <strong>{{ $certification->name }}</strong>
                    </div>
                @endif
                
                <div class="d-grid gap-2">
                    <a href="{{ route('pricing', ['certification' => $certification->id ?? null]) }}" 
                       class="btn btn-primary btn-lg">
                        View Pricing Plans
                    </a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Maybe Later
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
```

**Usage:**

```blade
<!-- In any view that needs paywall -->
@if(!auth('learner')->user()->canAccessFeature('practice_sessions'))
    <x-paywall feature="Practice Questions" :certification="$certification" />
    
    <script>
        // Show paywall when user tries to access locked feature
        document.addEventListener('DOMContentLoaded', function() {
            const paywallModal = new bootstrap.Modal(document.getElementById('paywallModal'));
            
            document.querySelectorAll('.locked-feature').forEach(element => {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    paywallModal.show();
                });
            });
        });
    </script>
@endif
```

---

## Phase 5: V2 Pricing & Conversion (Day 9, 6 hours)

### Goal
Create context-aware pricing page with conversion optimization

---

### Task 5.1: Pricing Page Controller (2 hours)

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
        // Get all active subscription plans
        $plans = SubscriptionPlan::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        // Get certification context (if coming from cert page or trial expired)
        $certification = null;
        $certificationId = $request->get('certification') ?? session('pricing_certification_id');
        
        if ($certificationId) {
            $certification = Certification::find($certificationId);
        }
        
        // Check if trial expired
        $trialExpired = $request->get('trial_expired', false);
        
        // Get learner's progress (if authenticated)
        $learner = auth('learner')->user();
        $progress = null;
        
        if ($learner && $certification) {
            $progress = [
                'questions_answered' => $learner->practiceAttempts()
                    ->whereHas('question', function($q) use ($certification) {
                        $q->whereHas('topic.domain', function($q2) use ($certification) {
                            $q2->where('certification_id', $certification->id);
                        });
                    })
                    ->count(),
                'exams_taken' => $learner->examAttempts()
                    ->where('certification_id', $certification->id)
                    ->count(),
                'days_active' => $learner->created_at->diffInDays(now()),
            ];
        }
        
        return view('pricing.index', compact('plans', 'certification', 'trialExpired', 'progress'));
    }
}
```

```php
// routes/web.php
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
```

---

### Task 5.2: Pricing Page View (3 hours)

**Deliverables:**

```blade
<!-- resources/views/pricing/index.blade.php -->
@extends('layouts.landing')

@section('title', 'Pricing Plans')

@section('content')
<div class="container py-5">
    {{-- Trial Expired Banner --}}
    @if($trialExpired)
        <div class="alert alert-warning mb-5 text-center">
            <h4 class="alert-heading">
                <i class="bi bi-clock-history me-2"></i>
                Your Free Trial Has Ended
            </h4>
            <p class="mb-0">
                Upgrade now to continue learning and keep your progress.
            </p>
        </div>
    @endif
    
    {{-- Certification Context --}}
    @if($certification)
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold mb-3">
                Continue Learning {{ $certification->name }}
            </h1>
            <p class="lead text-muted">
                Choose a plan to unlock full access and achieve your certification goals
            </p>
            
            @if($progress)
                <div class="row justify-content-center mt-4">
                    <div class="col-md-8">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-3">Your Progress So Far</h6>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="h3 mb-0">{{ $progress['questions_answered'] }}</div>
                                        <small class="text-muted">Questions Answered</small>
                                    </div>
                                    <div class="col-4">
                                        <div class="h3 mb-0">{{ $progress['exams_taken'] }}</div>
                                        <small class="text-muted">Exams Taken</small>
                                    </div>
                                    <div class="col-4">
                                        <div class="h3 mb-0">{{ $progress['days_active'] }}</div>
                                        <small class="text-muted">Days Active</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-0 mt-3">
                                    <small>Don't lose your progress! Upgrade to continue.</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @else
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold mb-3">
                Choose Your Plan
            </h1>
            <p class="lead text-muted">
                Start your 7-day free trial. No credit card required.
            </p>
        </div>
    @endif
    
    {{-- Pricing Cards --}}
    <div class="row g-4 mb-5">
        {{-- Single Certification --}}
        @if($certification)
            <div class="col-lg-4">
                <div class="card border-2 h-100">
                    <div class="card-body d-flex flex-column">
                        <h4 class="card-title">Single Certification</h4>
                        <p class="text-muted">{{ $certification->name }}</p>
                        
                        <div class="mb-4">
                            <span class="h2 mb-0">$39</span>
                            <span class="text-muted">/one-time</span>
                        </div>
                        
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Lifetime access
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                {{ $certification->questions_count }}+ practice questions
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Unlimited benchmark exams
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Performance analytics
                            </li>
                        </ul>
                        
                        <button class="btn btn-outline-primary btn-lg mt-auto"
                                onclick="checkout('single_cert', '{{ $certification->id }}')">
                            Purchase Now
                        </button>
                    </div>
                </div>
            </div>
        @endif
        
        {{-- Monthly Subscription --}}
        <div class="col-lg-4">
            <div class="card border-2 h-100 {{ $plans->where('is_popular', true)->first()?->slug === 'all-access-monthly' ? 'border-primary' : '' }}">
                @if($plans->where('is_popular', true)->first()?->slug === 'all-access-monthly')
                    <div class="card-header bg-primary text-white text-center">
                        <strong>Most Popular</strong>
                    </div>
                @endif
                
                <div class="card-body d-flex flex-column">
                    <h4 class="card-title">All-Access Monthly</h4>
                    <p class="text-muted">All certifications, cancel anytime</p>
                    
                    <div class="mb-4">
                        <span class="h2 mb-0">$24</span>
                        <span class="text-muted">/month</span>
                    </div>
                    
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            All 18 certifications
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Unlimited practice questions
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Unlimited benchmark exams
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Performance analytics
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Study plan recommendations
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Cancel anytime
                        </li>
                    </ul>
                    
                    <button class="btn btn-primary btn-lg mt-auto"
                            onclick="checkout('subscription_monthly', '{{ $plans->where('slug', 'all-access-monthly')->first()->id }}')">
                        Start Free Trial
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Annual Subscription --}}
        <div class="col-lg-4">
            <div class="card border-2 h-100 {{ $plans->where('is_featured', true)->first()?->slug === 'all-access-annual' ? 'border-success' : '' }}">
                @if($plans->where('is_featured', true)->first()?->slug === 'all-access-annual')
                    <div class="card-header bg-success text-white text-center">
                        <strong>Best Value - Save 31%</strong>
                    </div>
                @endif
                
                <div class="card-body d-flex flex-column">
                    <h4 class="card-title">All-Access Annual</h4>
                    <p class="text-muted">All certifications, billed annually</p>
                    
                    <div class="mb-4">
                        <span class="h2 mb-0">$199</span>
                        <span class="text-muted">/year</span>
                        <div class="text-success small">
                            <strong>$16.58/month</strong> - Save $89/year
                        </div>
                    </div>
                    
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            All 18 certifications
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Unlimited practice questions
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Unlimited benchmark exams
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Performance analytics
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Study plan recommendations
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Priority support
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Downloadable study materials
                        </li>
                    </ul>
                    
                    <button class="btn btn-success btn-lg mt-auto"
                            onclick="checkout('subscription_annual', '{{ $plans->where('slug', 'all-access-annual')->first()->id }}')">
                        Start Free Trial
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Money-Back Guarantee --}}
    <div class="text-center py-5 bg-light rounded">
        <h3 class="mb-3">
            <i class="bi bi-shield-check text-success me-2"></i>
            30-Day Money-Back Guarantee
        </h3>
        <p class="text-muted mb-0">
            If you don't pass your exam after completing our course, we'll refund your purchase in full. No questions asked.
        </p>
    </div>
</div>

<script>
async function checkout(planType, id) {
    try {
        const response = await fetch('/payment/checkout', {
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
        });
        
        const data = await response.json();
        
        if (data.checkout_url) {
            window.location.href = data.checkout_url;
        }
    } catch (error) {
        console.error('Checkout error:', error);
        alert('Failed to start checkout. Please try again.');
    }
}
</script>
@endsection
```

---

### Task 5.3: Testing (1 hour)

**Test Cases:**

1. **Pricing Page - No Context**
   - Navigate to `/pricing`
   - Verify 3 pricing tiers displayed
   - Verify "Most Popular" and "Best Value" badges
   - Verify trial messaging

2. **Pricing Page - Certification Context**
   - Navigate to `/certifications/aws-certified-cloud-practitioner`
   - Click "Start Free Trial"
   - Verify certification name in heading
   - Verify single certification option shown

3. **Pricing Page - Trial Expired**
   - Set trial_ends_at to past date
   - Access protected route
   - Verify redirect to pricing with warning banner
   - Verify progress stats displayed

4. **Checkout Flow**
   - Click "Purchase Now" on single cert
   - Verify Stripe checkout opens
   - Complete payment
   - Verify redirect to success page

---

## Testing Strategy

### Unit Tests

```bash
php artisan make:test LandingQuizAttemptTest
php artisan make:test PaymentTest
php artisan make:test TrialManagementTest
```

### Feature Tests

```bash
php artisan make:test PricingPageTest
php artisan make:test CheckoutFlowTest
php artisan make:test TrialReminderTest
```

### Manual Testing Checklist

**V1 Features:**
- [ ] Landing quiz displays 5 questions
- [ ] Quiz attempt saved to database
- [ ] Quiz completion tracked
- [ ] Conversion tracked on registration
- [ ] Structured data validates in Google Rich Results Test
- [ ] Smart registration preserves certification context

**V2 Features:**
- [ ] Stripe checkout works for single cert
- [ ] Stripe checkout works for monthly subscription
- [ ] Stripe checkout works for annual subscription
- [ ] Payment success page displays correctly
- [ ] Access granted after payment
- [ ] Trial starts on registration
- [ ] Trial banner shows on dashboard
- [ ] Trial reminder emails sent (Day 5, Day 6)
- [ ] Paywall blocks access after trial expires
- [ ] Pricing page shows certification context
- [ ] Pricing page shows progress stats

---

## Success Criteria

### V1 Success Criteria

| Metric | Target | Measurement |
|--------|--------|-------------|
| Quiz Completion Rate | 40%+ | `landing_quiz_attempts.completed_at IS NOT NULL` |
| Quiz → Registration Conversion | 15%+ | `landing_quiz_attempts.converted_to_registration = true` |
| Structured Data Validation | 100% | Google Rich Results Test |
| Smart Registration Success | 100% | Auto-enrollment verification |

### V2 Success Criteria

| Metric | Target | Measurement |
|--------|--------|-------------|
| Payment Success Rate | 95%+ | `payments.status = 'completed'` / total attempts |
| Trial → Paid Conversion | 20%+ | Paid subscriptions / trial starts |
| Trial Reminder Delivery | 100% | Email logs |
| Paywall Effectiveness | 100% | No unauthorized access |
| Pricing Page Load Time | <2s | Google PageSpeed Insights |

---

## Timeline & Resources

### Timeline

| Phase | Duration | Start | End |
|-------|----------|-------|-----|
| **Phase 1: V1 Completion** | 2 days | Day 1 | Day 2 |
| **Phase 2: V2 Foundation** | 1 day | Day 3 | Day 3 |
| **Phase 3: V2 Payment** | 2 days | Day 4 | Day 5 |
| **Phase 4: V2 Trial** | 2 days | Day 6 | Day 7 |
| **Phase 5: V2 Pricing** | 1 day | Day 8 | Day 8 |
| **Testing & QA** | 2 days | Day 9 | Day 10 |
| **Deployment** | 1 day | Day 11 | Day 11 |
| **Total** | **11 days** | Day 1 | Day 11 |

### Resources

**Development:**
- 1 Full-stack Developer (Laravel + JavaScript)
- 49 hours total development time
- ~5 hours/day over 11 days

**Design:**
- Email templates (trial reminders, payment receipts)
- Pricing page design (if not using existing)

**Testing:**
- Stripe test account (free)
- Test credit cards
- Email testing service (Mailtrap or similar)

**Infrastructure:**
- Stripe webhook endpoint (production)
- Cron job for trial reminders
- SSL certificate for payment pages

---

## Risk Mitigation

### Technical Risks

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| Stripe integration issues | Medium | High | Use Stripe test mode, extensive testing |
| Webhook delivery failures | Medium | High | Implement retry logic, logging |
| Trial reminder email delivery | Low | Medium | Use reliable email service (SendGrid, SES) |
| Paywall bypass | Low | High | Thorough middleware testing |
| Database migration issues | Low | High | Backup before migrations, rollback plan |

### Business Risks

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| Low conversion rate | Medium | High | A/B test pricing, optimize messaging |
| High trial abandonment | Medium | Medium | Improve onboarding, reminder emails |
| Payment processor fees | Low | Medium | Monitor costs, consider Paddle for international |
| Churn rate | Medium | High | Focus on value delivery, retention features |

### Rollback Plan

**If V2 fails:**
1. Disable payment routes
2. Revert to V1 (free trial without payment)
3. Collect emails for future launch
4. Fix issues offline

**Database Rollback:**
```bash
php artisan migrate:rollback --step=5
```

**Code Rollback:**
```bash
git revert <commit-hash>
git push origin mvp-frontend
```

---

## Conclusion

This implementation plan provides a comprehensive roadmap to close all gaps identified in the Certification Landing Page Requirements Review. By following a phased approach, we can:

1. **Complete V1** (2 days) - Achieve 100% content/engagement compliance
2. **Build V2** (6 days) - Add full monetization infrastructure
3. **Test & Deploy** (3 days) - Ensure production readiness

**Total Timeline:** 11 days  
**Total Effort:** 49 hours  
**Expected Outcome:** Production-ready landing page with full monetization capability

**Next Steps:**
1. Review and approve this plan
2. Set up Stripe test account
3. Begin Phase 1 implementation
4. Track progress against success criteria
