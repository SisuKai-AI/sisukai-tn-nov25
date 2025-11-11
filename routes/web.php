<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\LearnerController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CertificationController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ExamSessionController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\LegalPageController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\NewsletterSubscriberController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Learner\AuthController as LearnerAuthController;
use App\Http\Controllers\Learner\DashboardController as LearnerDashboardController;
use App\Http\Controllers\Learner\BenchmarkController;
use App\Http\Controllers\Learner\PracticeSessionController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Api\LandingQuizController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\Learner\PaddleWebhookController;

// Webhook Routes (must be outside CSRF protection)
Route::post('/webhook/stripe', [StripeWebhookController::class, 'handle'])->name('webhook.stripe');
Route::post('/webhook/paddle', [PaddleWebhookController::class, 'handleWebhook'])->name('webhook.paddle');

// Landing Portal Routes (Public)
Route::name('landing.')->group(function () {
    Route::get('/', [LandingController::class, 'home'])->name('home');
    Route::get('/pricing', [LandingController::class, 'pricing'])->name('pricing');
    Route::get('/certifications', [LandingController::class, 'certifications'])->name('certifications.index');
    Route::get('/certifications/{slug}', [LandingController::class, 'certificationShow'])->name('certifications.show');
    Route::get('/about', [LandingController::class, 'about'])->name('about');
    Route::get('/contact', [LandingController::class, 'contact'])->name('contact');
    Route::post('/contact', [LandingController::class, 'contactSubmit'])->name('contact.submit');
    Route::get('/blog', [LandingController::class, 'blogIndex'])->name('blog.index');
    Route::get('/blog/{slug}', [LandingController::class, 'blogShow'])->name('blog.show');
    Route::get('/help', [LandingController::class, 'helpIndex'])->name('help.index');
    Route::get('/help/search', [LandingController::class, 'helpSearch'])->name('help.search')->middleware('throttle:60,1');
    Route::get('/help/article/{slug}', [LandingController::class, 'helpArticleShow'])->name('help.article.show');
    Route::post('/help/article/{slug}/feedback', [LandingController::class, 'helpArticleFeedback'])->name('help.article.feedback');
    Route::get('/legal/{slug}', [LandingController::class, 'legalShow'])->name('legal.show');
    Route::post('/newsletter/subscribe', [LandingController::class, 'newsletterSubscribe'])->name('newsletter.subscribe');
    
    // Landing Quiz API Routes
    Route::prefix('api/quiz')->name('api.quiz.')->group(function () {
        Route::get('/{certificationSlug}/questions', [LandingQuizController::class, 'getQuestions'])->name('questions');
        Route::post('/submit-answer', [LandingQuizController::class, 'submitAnswer'])->name('submit-answer');
        Route::post('/complete', [LandingQuizController::class, 'completeQuiz'])->name('complete');
        Route::post('/track-conversion', [LandingQuizController::class, 'trackConversion'])->name('track-conversion');
    });
});

// Authentication Routes (Public)
Route::middleware('guest:learner')->group(function () {
    // Login & Registration
    Route::get('/login', [LearnerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LearnerAuthController::class, 'login']);
    Route::get('/register', [LearnerAuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [LearnerAuthController::class, 'register']);
    
    // Password Reset
    Route::get('/forgot-password', [LearnerAuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [LearnerAuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [LearnerAuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [LearnerAuthController::class, 'resetPassword'])->name('password.update');
    
    // Magic Link
    Route::post('/auth/magic-link/send', [LearnerAuthController::class, 'sendMagicLink'])->name('auth.magic-link.send');
    Route::get('/auth/magic-link/verify/{token}', [LearnerAuthController::class, 'verifyMagicLink'])->name('auth.magic-link.verify');
    
    // Google OAuth
    Route::get('/auth/google', [LearnerAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [LearnerAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    
    // LinkedIn OAuth
    Route::get('/auth/linkedin', [LearnerAuthController::class, 'redirectToLinkedIn'])->name('auth.linkedin');
    Route::get('/auth/linkedin/callback', [LearnerAuthController::class, 'handleLinkedInCallback'])->name('auth.linkedin.callback');
    
    // Facebook OAuth
    Route::get('/auth/facebook', [LearnerAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('/auth/facebook/callback', [LearnerAuthController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');
    
    // Two-Factor Authentication
    Route::get('/auth/two-factor', [LearnerAuthController::class, 'showTwoFactorForm'])->name('auth.two-factor');
    Route::post('/auth/two-factor/verify', [LearnerAuthController::class, 'verifyTwoFactor'])->name('auth.two-factor.verify');
    Route::post('/auth/two-factor/resend', [LearnerAuthController::class, 'resendTwoFactorCode'])->name('auth.two-factor.resend');
    Route::get('/auth/two-factor/verify/{code}', [LearnerAuthController::class, 'verifyTwoFactorLink'])->name('auth.two-factor.verify-link');
});

// Email Verification & Two-Factor (Authenticated)
Route::middleware('auth:learner')->group(function () {
    Route::get('/email/verify', [LearnerAuthController::class, 'showVerifyEmailForm'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [LearnerAuthController::class, 'verifyEmail'])->name('verification.verify');
    Route::post('/email/resend', [LearnerAuthController::class, 'resendVerificationEmail'])->name('verification.resend');
    
    Route::get('/two-factor-auth', [LearnerAuthController::class, 'showTwoFactorForm'])->name('two-factor.show');
    Route::post('/two-factor-auth', [LearnerAuthController::class, 'verifyTwoFactor'])->name('two-factor.verify');
});

// Admin Portal Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Authentication Routes (Guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    // Admin Protected Routes
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        // User Management
        Route::resource('users', UserController::class);
        
        // Role Management
        Route::resource('roles', RoleController::class);
        Route::get('roles/{role}/permissions', [RolePermissionController::class, 'edit'])->name('roles.permissions.edit');
        Route::put('roles/{role}/permissions', [RolePermissionController::class, 'update'])->name('roles.permissions.update');
        
        // Permission Management
        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('permissions/{permission}', [PermissionController::class, 'show'])->name('permissions.show');
        
        // Learner Management
        Route::resource('learners', LearnerController::class);
        Route::post('learners/{learner}/toggle-status', [LearnerController::class, 'toggleStatus'])->name('learners.toggleStatus');
        
        // Profile Management
        Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('profile/two-factor/toggle', [ProfileController::class, 'toggleTwoFactor'])->name('profile.two-factor.toggle');
        
        // Certification Management
        Route::resource('certifications', CertificationController::class);
        Route::post('certifications/{certification}/toggle-status', [CertificationController::class, 'toggleStatus'])->name('certifications.toggleStatus');
        
        // Domain Management (nested under certifications)
        Route::prefix('certifications/{certification}')->name('certifications.')->group(function () {
            Route::resource('domains', DomainController::class);
        });
        
        // Topic Management (nested under domains)
        Route::prefix('domains/{domain}')->name('domains.')->group(function () {
            Route::resource('topics', TopicController::class);
        });
        
        // Question Management (nested under topics)
        Route::prefix('topics/{topic}')->name('topics.')->group(function () {
            Route::resource('questions', QuestionController::class)->except(['index', 'show']);
        });
        
        // Question Management
        Route::resource('questions', QuestionController::class);
        Route::post('questions/{question}/approve', [QuestionController::class, 'approve'])->name('questions.approve');
        Route::post('questions/{question}/archive', [QuestionController::class, 'archive'])->name('questions.archive');
        Route::post('questions/bulk-approve', [QuestionController::class, 'bulkApprove'])->name('questions.bulk-approve');
        
        // Exam Session Management
        Route::resource('exam-sessions', ExamSessionController::class);
        Route::get('exam-sessions-analytics', [ExamSessionController::class, 'analytics'])->name('exam-sessions.analytics');
        
        // Landing Portal Content Management
        Route::resource('subscription-plans', SubscriptionPlanController::class);
        Route::resource('testimonials', TestimonialController::class);
        Route::resource('legal-pages', LegalPageController::class);
        Route::resource('blog-posts', BlogPostController::class);
        Route::resource('blog-categories', BlogCategoryController::class);
        Route::resource('help-categories', \App\Http\Controllers\Admin\HelpCategoryController::class);
        Route::resource('help-articles', \App\Http\Controllers\Admin\HelpArticleController::class);
        
        // Landing Quiz Questions Management
        Route::get('landing-quiz-questions', [\App\Http\Controllers\Admin\LandingQuizQuestionController::class, 'index'])->name('landing-quiz-questions.index');
        Route::get('landing-quiz-questions/analytics', [\App\Http\Controllers\Admin\LandingQuizQuestionController::class, 'analytics'])->name('landing-quiz-questions.analytics');
        Route::get('landing-quiz-questions/{certification}/edit', [\App\Http\Controllers\Admin\LandingQuizQuestionController::class, 'edit'])->name('landing-quiz-questions.edit');
        Route::put('landing-quiz-questions/{certification}', [\App\Http\Controllers\Admin\LandingQuizQuestionController::class, 'update'])->name('landing-quiz-questions.update');
        Route::delete('landing-quiz-questions/{certification}', [\App\Http\Controllers\Admin\LandingQuizQuestionController::class, 'destroy'])->name('landing-quiz-questions.destroy');
        
        // Payment Settings
        Route::get('payment-settings', [\App\Http\Controllers\Admin\PaymentSettingsController::class, 'index'])->name('payment-settings.index');
        Route::put('payment-settings', [\App\Http\Controllers\Admin\PaymentSettingsController::class, 'update'])->name('payment-settings.update');
        Route::post('payment-settings/test/{processor}', [\App\Http\Controllers\Admin\PaymentSettingsController::class, 'test'])->name('payment-settings.test');
        
        // Media Management
        Route::post('media/upload-image', [\App\Http\Controllers\Admin\MediaController::class, 'uploadImage'])->name('media.upload-image');
        Route::post('media/upload-blog-image', [\App\Http\Controllers\Admin\MediaController::class, 'uploadBlogImage'])->name('media.upload-blog-image');
        Route::delete('media/delete-image', [\App\Http\Controllers\Admin\MediaController::class, 'deleteImage'])->name('media.delete-image');
        
        // Newsletter Management
        Route::get('newsletter-subscribers', [NewsletterSubscriberController::class, 'index'])->name('newsletter-subscribers.index');
        Route::get('newsletter-subscribers/export', [NewsletterSubscriberController::class, 'export'])->name('newsletter-subscribers.export');
        Route::delete('newsletter-subscribers/{newsletterSubscriber}', [NewsletterSubscriberController::class, 'destroy'])->name('newsletter-subscribers.destroy');
        
        // Settings Management
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    });
});

// Learner Portal Routes
Route::prefix('learner')->name('learner.')->group(function () {
    // Learner Authentication Routes (Guest only)
    Route::middleware('guest:learner')->group(function () {
        Route::get('/login', [LearnerAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LearnerAuthController::class, 'login']);
        Route::get('/register', [LearnerAuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [LearnerAuthController::class, 'register']);
    });

    // Learner Protected Routes
    Route::middleware('learner')->group(function () {
        Route::get('/dashboard', [LearnerDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [LearnerAuthController::class, 'logout'])->name('logout');
        
        // Profile routes
        Route::get('/profile', [\App\Http\Controllers\Learner\ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [\App\Http\Controllers\Learner\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\Learner\ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/two-factor/toggle', [\App\Http\Controllers\Learner\ProfileController::class, 'toggleTwoFactor'])->name('profile.two-factor.toggle');
        
        // Certification routes
        Route::get('/certifications', [\App\Http\Controllers\Learner\CertificationController::class, 'index'])->name('certifications.index');
        Route::get('/certifications/{certification}', [\App\Http\Controllers\Learner\CertificationController::class, 'show'])->name('certifications.show');
        Route::post('/certifications/{certification}/enroll', [\App\Http\Controllers\Learner\CertificationController::class, 'enroll'])->name('certifications.enroll');
        Route::delete('/certifications/{certification}/unenroll', [\App\Http\Controllers\Learner\CertificationController::class, 'unenroll'])->name('certifications.unenroll');
        Route::get('/my-certifications', [\App\Http\Controllers\Learner\CertificationController::class, 'myCertifications'])->name('certifications.my');
        
        // Certification-specific onboarding
        Route::get('/certification/{certSlug}/onboarding', [\App\Http\Controllers\Learner\CertificationOnboardingController::class, 'show'])->name('certification.onboarding');
        
        // Payment routes
        Route::prefix('payment')->name('payment.')->group(function () {
            Route::get('/pricing', [\App\Http\Controllers\Learner\PaymentController::class, 'pricing'])->name('pricing');
            Route::post('/subscription/{planId}/checkout', [\App\Http\Controllers\Learner\PaymentController::class, 'createSubscriptionCheckout'])->name('subscription.checkout');
            Route::post('/certification/{certificationId}/checkout', [\App\Http\Controllers\Learner\PaymentController::class, 'createCertificationCheckout'])->name('certification.checkout');
            Route::get('/success', [\App\Http\Controllers\Learner\PaymentController::class, 'success'])->name('success');
            Route::get('/cancel', [\App\Http\Controllers\Learner\PaymentController::class, 'cancel'])->name('cancel');
            Route::get('/manage-subscription', [\App\Http\Controllers\Learner\PaymentController::class, 'manageSubscription'])->name('manage-subscription');
            Route::post('/subscription/cancel', [\App\Http\Controllers\Learner\PaymentController::class, 'cancelSubscription'])->name('subscription.cancel');
            Route::post('/subscription/resume', [\App\Http\Controllers\Learner\PaymentController::class, 'resumeSubscription'])->name('subscription.resume');
            Route::get('/billing-history', [\App\Http\Controllers\Learner\PaymentController::class, 'billingHistory'])->name('billing-history');
        });
        
        // Benchmark routes
        Route::prefix('benchmark')->name('benchmark.')->group(function () {
            Route::get('/{certification}/explain', [BenchmarkController::class, 'explain'])->name('explain');
            Route::post('/{certification}/create', [BenchmarkController::class, 'create'])->name('create');
            Route::get('/{certification}/start', [BenchmarkController::class, 'start'])->name('start');
        });
        
        // Practice Session routes
        Route::prefix('practice')->name('practice.')->group(function () {
            Route::get('/{certification}/recommendations', [PracticeSessionController::class, 'recommendations'])->name('recommendations');
            Route::post('/create', [PracticeSessionController::class, 'create'])->name('create');
            Route::get('/{id}/take', [PracticeSessionController::class, 'take'])->name('take');
            Route::post('/{id}/answer', [PracticeSessionController::class, 'submitAnswer'])->name('submit-answer');
            Route::post('/{id}/complete', [PracticeSessionController::class, 'complete'])->name('complete');
            Route::get('/{id}/results', [PracticeSessionController::class, 'results'])->name('results');
            Route::get('/history', [PracticeSessionController::class, 'history'])->name('history');
        });
        
        // Exam Session routes
        Route::prefix('exams')->name('exams.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Learner\ExamSessionController::class, 'index'])->name('index');
            Route::get('/history', [\App\Http\Controllers\Learner\ExamSessionController::class, 'history'])->name('history');
            Route::get('/{id}', [\App\Http\Controllers\Learner\ExamSessionController::class, 'show'])->name('show');
            Route::post('/{id}/start', [\App\Http\Controllers\Learner\ExamSessionController::class, 'start'])->name('start');
            Route::get('/{id}/take', [\App\Http\Controllers\Learner\ExamSessionController::class, 'take'])->name('take');
            Route::get('/{id}/question/{number}', [\App\Http\Controllers\Learner\ExamSessionController::class, 'getQuestion'])->name('get-question');
            Route::post('/{id}/answer', [\App\Http\Controllers\Learner\ExamSessionController::class, 'submitAnswer'])->name('submit-answer');
            Route::post('/{id}/flag/{questionId}', [\App\Http\Controllers\Learner\ExamSessionController::class, 'flagQuestion'])->name('flag-question');
            Route::post('/{id}/submit', [\App\Http\Controllers\Learner\ExamSessionController::class, 'submit'])->name('submit');
            Route::get('/{id}/results', [\App\Http\Controllers\Learner\ExamSessionController::class, 'results'])->name('results');
        });
    });
});
