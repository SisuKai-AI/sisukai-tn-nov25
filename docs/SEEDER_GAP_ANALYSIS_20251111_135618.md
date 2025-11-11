# Seeder Gap Analysis - SisuKai Platform

**Date:** November 10, 2025  
**Branch:** mvp-frontend  
**Purpose:** Identify database tables that need seeders for production-ready content

---

## 📊 Current Seeder Status

### ✅ Existing Seeders (18 total)

1. **AdminUserSeeder.php** - Seeds admin users
2. **BlogCategoriesSeeder.php** - Seeds blog categories (5 categories)
3. **BlogPostsSeeder.php** - Seeds blog posts (5 posts with WebP images)
4. **CertificationSeeder.php** - Seeds 18 certifications
5. **DatabaseSeeder.php** - Master seeder orchestrator
6. **DomainSeeder.php** - Seeds certification domains
7. **HelpCenterSeeder.php** - Seeds help center content (4 categories, 12 articles)
8. **LearnerSeeder.php** - Seeds test learner accounts
9. **LegalPageSeeder.php** - ⚠️ OLD VERSION (deprecated)
10. **LegalPagesSeeder.php** - ✅ NEW VERSION with comprehensive legal content
11. **PermissionSeeder.php** - Seeds permissions
12. **QuestionSeeder.php** - Seeds 1,268 practice questions across 18 certifications
13. **RolePermissionSeeder.php** - Seeds role-permission relationships
14. **RoleSeeder.php** - Seeds user roles
15. **SubscriptionPlanSeeder.php** - ✅ ACTIVE (seeds 3 plans with Stripe/Paddle IDs)
16. **SubscriptionPlansSeeder.php** - ⚠️ DUPLICATE/OLD VERSION
17. **TestimonialSeeder.php** - Seeds 10 testimonials
18. **TopicSeeder.php** - Seeds certification topics

---

## 🔴 Missing Seeders - Critical

### 1. **CertificationLandingQuizQuestionsSeeder** ❌ MISSING

**Table:** `certification_landing_quiz_questions`  
**Current Rows:** 0  
**Status:** EMPTY - No seeder exists

**Purpose:**  
Seeds the 5 sample quiz questions displayed on each certification landing page (e.g., `/certifications/cissp`).

**Schema:**
```php
- id (uuid)
- certification_id (uuid) → certifications.id
- question_id (uuid) → questions.id
- order (integer) - display order (1-5)
- timestamps
```

**Requirements:**
- Select 5 representative questions per certification
- Mix of difficulty levels (1-2 easy, 2-3 medium, 0-1 hard)
- Cover different domains/topics
- Questions should showcase the exam format
- Order matters for consistent display

**Question Availability per Certification:**
| Certification | Available Questions | Can Seed Quiz? |
|--------------|-------------------|----------------|
| PMP | 442 | ✅ Yes |
| CISSP | 240 | ✅ Yes |
| CompTIA A+ | 165 | ✅ Yes |
| AWS Cloud Practitioner | 114 | ✅ Yes |
| AWS Solutions Architect | 39 | ✅ Yes |
| CompTIA Security+ | 39 | ✅ Yes |
| Google Cloud Digital Leader | 37 | ✅ Yes |
| CKA | 37 | ✅ Yes |
| CEH | 21 | ✅ Yes |
| CCNA | 18 | ✅ Yes |
| ITIL 4 | 17 | ✅ Yes |
| CySA+ | 15 | ✅ Yes |
| GSEC | 15 | ✅ Yes |
| Network+ | 15 | ✅ Yes |
| CSM | 15 | ✅ Yes |
| Java SE | 15 | ✅ Yes |
| Azure Fundamentals | 12 | ✅ Yes |
| Azure Data Fundamentals | 12 | ✅ Yes |

**All 18 certifications have sufficient questions (12-442 each) to seed 5 quiz questions.**

**Priority:** 🔴 **HIGH** - Landing pages currently show no quiz content

---

### 2. **PaymentProcessorSettingsSeeder** ❌ MISSING

**Table:** `payment_processor_settings`  
**Current Rows:** 0  
**Status:** EMPTY - No seeder exists

**Purpose:**  
Seeds initial configuration for Stripe and Paddle payment processors.

**Schema:**
```php
- id (uuid)
- processor (enum: 'stripe', 'paddle')
- is_active (boolean)
- is_default (boolean)
- config (json) - encrypted API keys and settings
- timestamps
```

**Requirements:**
- Create records for both Stripe and Paddle
- Set Stripe as active and default (matches current `settings.active_payment_processor`)
- Config should include placeholder keys for:
  - API keys (public/secret for Stripe, vendor/auth for Paddle)
  - Webhook secrets
  - Environment (sandbox/production)
- Actual keys should be set via environment variables or admin panel

**Sample Structure:**
```php
[
    'processor' => 'stripe',
    'is_active' => true,
    'is_default' => true,
    'config' => [
        'public_key' => env('STRIPE_KEY'),
        'secret_key' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        'environment' => 'sandbox'
    ]
],
[
    'processor' => 'paddle',
    'is_active' => false,
    'is_default' => false,
    'config' => [
        'vendor_id' => env('PADDLE_VENDOR_ID'),
        'auth_code' => env('PADDLE_AUTH_CODE'),
        'public_key' => env('PADDLE_PUBLIC_KEY'),
        'webhook_secret' => env('PADDLE_WEBHOOK_SECRET'),
        'environment' => 'sandbox'
    ]
]
```

**Priority:** 🔴 **HIGH** - Required for payment system to function

---

## 🟡 Missing Seeders - Medium Priority

### 3. **SettingsSeeder** (Enhancement)

**Table:** `settings`  
**Current Rows:** 4 (seeded via migration)  
**Status:** MINIMAL - Could be enhanced

**Current Settings:**
- `trial_period_days` = 7
- `site_name` = SisuKai
- `support_email` = support@sisukai.com
- `active_payment_processor` = stripe

**Potential Additional Settings:**
- `contact_email` - General contact email
- `sales_email` - Sales inquiries
- `privacy_email` - Privacy/GDPR requests (privacy@sisukai.com)
- `security_email` - Security vulnerability reports (security@sisukai.com)
- `max_practice_questions_per_session` - Default 50
- `passing_score_percentage` - Default 70%
- `enable_social_login` - Default false
- `enable_two_factor` - Default true
- `session_timeout_minutes` - Default 30
- `max_login_attempts` - Default 5
- `lockout_duration_minutes` - Default 15
- `enable_analytics` - Default true
- `google_analytics_id` - GA4 measurement ID
- `enable_newsletter` - Default true
- `maintenance_mode` - Default false
- `maintenance_message` - Custom message

**Priority:** 🟡 **MEDIUM** - Current settings work, but more would be useful

---

## 🟢 Tables That Don't Need Seeders

### Transaction/Runtime Tables (User-Generated Data)
- `learner_subscriptions` - Created when users subscribe
- `payments` - Created during payment transactions
- `single_certification_purchases` - Created when users buy single certs
- `landing_quiz_attempts` - Created when visitors take landing page quizzes
- `practice_sessions` - Created when learners practice
- `practice_session_questions` - Created during practice sessions
- `practice_answers` - Created when learners answer questions
- `exam_attempts` - Created when learners take exams
- `exam_attempt_questions` - Created during exam attempts
- `exam_answers` - Created when learners answer exam questions
- `flagged_questions` - Created when learners flag questions
- `certificates` - Created when learners pass exams
- `learner_certification` - Created when learners enroll
- `newsletter_subscribers` - Created when visitors subscribe
- `help_article_feedback` - Created when users rate help articles
- `media` - Created when files are uploaded

### System Tables (Managed by Laravel)
- `users` - Admin users (seeded via AdminUserSeeder)
- `learners` - Learner accounts (seeded via LearnerSeeder for testing)
- `roles` - Seeded via RoleSeeder
- `permissions` - Seeded via PermissionSeeder
- `user_roles` - Seeded via RoleSeeder
- `permission_role` - Seeded via RolePermissionSeeder

### Content Tables (Already Seeded)
- `certifications` - ✅ Seeded (18 certifications)
- `domains` - ✅ Seeded via DomainSeeder
- `topics` - ✅ Seeded via TopicSeeder
- `questions` - ✅ Seeded (1,268 questions)
- `answers` - ✅ Seeded with questions
- `blog_categories` - ✅ Seeded (5 categories)
- `blog_posts` - ✅ Seeded (5 posts)
- `legal_pages` - ✅ Seeded (5 comprehensive legal pages)
- `testimonials` - ✅ Seeded (10 testimonials)
- `help_categories` - ✅ Seeded (4 categories)
- `help_articles` - ✅ Seeded (12 articles)
- `subscription_plans` - ✅ Seeded (3 plans)

---

## 📋 Action Items

### Immediate (Before Production Launch)

1. ✅ **Create CertificationLandingQuizQuestionsSeeder**
   - Select 5 questions per certification (90 total)
   - Mix difficulty levels
   - Ensure diverse topic coverage
   - Set proper ordering

2. ✅ **Create PaymentProcessorSettingsSeeder**
   - Seed Stripe configuration (active, default)
   - Seed Paddle configuration (inactive)
   - Use environment variables for sensitive keys
   - Document required .env variables

3. ⚠️ **Clean Up Duplicate Seeders**
   - Remove or deprecate `LegalPageSeeder.php` (old version)
   - Remove or deprecate `SubscriptionPlansSeeder.php` (duplicate)
   - Update `DatabaseSeeder.php` to use correct seeders

### Optional Enhancements

4. 🟡 **Enhance SettingsSeeder**
   - Add email addresses for different departments
   - Add practice/exam configuration defaults
   - Add security settings
   - Add analytics configuration
   - Move settings from migration to dedicated seeder

---

## 🎯 Summary

| Category | Count | Status |
|----------|-------|--------|
| **Existing Seeders** | 18 | ✅ Complete |
| **Missing Critical Seeders** | 2 | ❌ Need Creation |
| **Duplicate/Old Seeders** | 2 | ⚠️ Need Cleanup |
| **Optional Enhancements** | 1 | 🟡 Nice to Have |

**Total Seeders Needed:** 2 (CertificationLandingQuizQuestionsSeeder, PaymentProcessorSettingsSeeder)

---

**Next Steps:**
1. Create `CertificationLandingQuizQuestionsSeeder.php`
2. Create `PaymentProcessorSettingsSeeder.php`
3. Update `DatabaseSeeder.php` to call new seeders
4. Test all seeders with fresh database
5. Document seeder execution order and dependencies
