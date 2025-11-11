@extends('layouts.landing')

@section('title', 'Pricing - SisuKai')
@section('meta_description', 'Simple, transparent pricing for certification exam preparation. Choose the plan that fits your needs and start your free trial today.')

@section('content')

<!-- Page Header -->
<section class="page-header bg-primary-custom text-white" style="padding: 4rem 0 3rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">Simple, Transparent Pricing</h1>
                <p class="lead mb-0">
                    Choose the plan that fits your needs. All plans include a {{ $trialDays }}-day free trial.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Plans -->
<section class="landing-section">
    <div class="container">
        @if($plans->count() > 0)
            <div class="row g-4 justify-content-center">
                @foreach($plans as $plan)
                    <div class="col-lg-4 col-md-6">
                        <div class="landing-card h-100 {{ $plan->is_popular ? 'border-primary' : '' }}" style="position: relative;">
                            @if($plan->is_popular)
                                <div class="position-absolute top-0 start-50 translate-middle">
                                    <span class="badge bg-primary-custom">Most Popular</span>
                                </div>
                            @endif
                            
                            <div class="text-center mb-4">
                                <h3 class="mb-2">{{ $plan->name }}</h3>
                                <p class="text-muted mb-4">{{ $plan->description }}</p>
                                
                                <div class="mb-3">
                                    @if($plan->price_monthly > 0 && $plan->certification_limit == 1)
                                        {{-- Single Certification: One-time payment --}}
                                        <span class="display-4 fw-bold">${{ number_format($plan->price_monthly, 0) }}</span>
                                        <span class="text-muted">one-time</span>
                                    @elseif($plan->price_monthly > 0)
                                        {{-- Monthly subscription --}}
                                        <span class="display-4 fw-bold">${{ number_format($plan->price_monthly, 2) }}</span>
                                        <span class="text-muted">/ month</span>
                                    @elseif($plan->price_annual > 0)
                                        {{-- Annual subscription --}}
                                        <span class="display-4 fw-bold">${{ number_format($plan->price_annual, 2) }}</span>
                                        <span class="text-muted">/ year</span>
                                    @endif
                                </div>
                                
                                @if($plan->price_annual > 0 && $plan->price_monthly > 0)
                                    <p class="text-muted small mb-0">
                                        or ${{ number_format($plan->price_annual, 2) }}/year (save {{ round((1 - ($plan->price_annual / ($plan->price_monthly * 12))) * 100) }}%)
                                    </p>
                                @endif
                                
                                @if($plan->trial_days > 0)
                                    <small class="text-success">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        {{ $plan->trial_days }}-day free trial
                                    </small>
                                @endif
                            </div>
                            
                            <div class="mb-4">
                                <h6 class="mb-3">Features:</h6>
                                <ul class="list-unstyled">
                                    @if($plan->features)
                                        @foreach((is_array($plan->features) ? $plan->features : json_decode($plan->features, true)) as $feature)
                                            <li class="mb-2">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                {{ $feature }}
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            
                            <div class="mt-auto">
                                @auth('learner')
                                    <form action="{{ route('learner.payment.subscription.checkout', $plan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn {{ $plan->is_popular ? 'btn-primary-custom' : 'btn-outline-custom' }} w-100">
                                            @if($plan->trial_days > 0)
                                                Start {{ $plan->trial_days }}-Day Free Trial
                                            @else
                                                Subscribe Now
                                            @endif
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('register') }}" 
                                       class="btn {{ $plan->is_popular ? 'btn-primary-custom' : 'btn-outline-custom' }} w-100">
                                        @if($plan->trial_days > 0)
                                            Start {{ $plan->trial_days }}-Day Free Trial
                                        @else
                                            Get Started
                                        @endif
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <div class="icon bg-light text-muted mx-auto mb-4" style="width: 80px; height: 80px; line-height: 80px; font-size: 2rem;">
                    <i class="bi bi-inbox"></i>
                </div>
                <h4 class="mb-3">No Pricing Plans Available</h4>
                <p class="text-muted mb-4">We're working on our pricing. Check back soon!</p>
            </div>
        @endif
    </div>
</section>

<!-- Trust Badges Section -->
<section class="landing-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="p-3">
                    <i class="bi bi-shield-check text-success" style="font-size: 2.5rem;"></i>
                    <h6 class="mt-3 mb-2 fw-bold">Secure Payments</h6>
                    <p class="text-muted small mb-0">Bank-level encryption & PCI DSS compliant</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="p-3">
                    <i class="bi bi-arrow-repeat text-primary-custom" style="font-size: 2.5rem;"></i>
                    <h6 class="mt-3 mb-2 fw-bold">Cancel Anytime</h6>
                    <p class="text-muted small mb-0">No long-term commitment required</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="p-3">
                    <i class="bi bi-cash-coin text-warning" style="font-size: 2.5rem;"></i>
                    <h6 class="mt-3 mb-2 fw-bold">30-Day Guarantee</h6>
                    <p class="text-muted small mb-0">Full refund if not satisfied</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="p-3">
                    <i class="bi bi-credit-card text-info" style="font-size: 2.5rem;"></i>
                    <h6 class="mt-3 mb-2 fw-bold">Flexible Billing</h6>
                    <p class="text-muted small mb-0">Monthly or annual payment options</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="landing-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="text-center mb-5">
                    <h2 class="section-title">Frequently Asked Questions</h2>
                    <p class="section-subtitle">Everything you need to know about our pricing</p>
                </div>
                
                <div class="accordion" id="pricingFAQ">
                    <!-- FAQ 1 -->
                    <div class="accordion-item mb-3 border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                How does the free trial work?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#pricingFAQ">
                            <div class="accordion-body">
                                You get full access to all features for {{ $trialDays }} days, completely free. No credit card required. 
                                After the trial, you can choose to subscribe to continue accessing our platform.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 2 -->
                    <div class="accordion-item mb-3 border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Can I cancel my subscription anytime?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#pricingFAQ">
                            <div class="accordion-body">
                                Yes! You can cancel your subscription at any time from your account settings. 
                                You'll continue to have access until the end of your current billing period.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 3 -->
                    <div class="accordion-item mb-3 border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#pricingFAQ">
                            <div class="accordion-body">
                                We accept all major credit cards (Visa, MasterCard, American Express), debit cards, and digital wallets including Apple Pay and Google Pay. 
                                All payments are processed securely through industry-leading payment processors with bank-level encryption and PCI DSS compliance.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 4 -->
                    <div class="accordion-item mb-3 border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Can I switch plans later?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#pricingFAQ">
                            <div class="accordion-body">
                                Absolutely! You can upgrade or downgrade your plan at any time. 
                                Changes will be prorated and reflected in your next billing cycle.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 5 -->
                    <div class="accordion-item mb-3 border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                Do you offer refunds?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#pricingFAQ">
                            <div class="accordion-body">
                                We offer a 30-day money-back guarantee. If you're not satisfied with SisuKai within the first 30 days, 
                                contact our support team for a full refund.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 6 -->
                    <div class="accordion-item border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                Are there any hidden fees?
                            </button>
                        </h2>
                        <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#pricingFAQ">
                            <div class="accordion-body">
                                No hidden fees, ever. The price you see is the price you pay. 
                                We believe in transparent pricing with no surprises.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section bg-primary-custom text-white" style="padding: 4rem 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0 text-center text-lg-start">
                <h2 class="fw-bold mb-3">Still Have Questions?</h2>
                <p class="mb-0 opacity-75">
                    Our team is here to help. Contact us and we'll get back to you within 24 hours.
                </p>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <a href="{{ route('landing.contact') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-envelope me-2"></i>Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
