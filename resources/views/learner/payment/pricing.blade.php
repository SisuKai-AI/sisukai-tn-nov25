@extends('layouts.learner')

@section('title', 'Pricing Plans - SisuKai')

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">Choose Your Plan</h1>
        <p class="lead text-muted">Start your 7-day free trial. No credit card required.</p>
        @if($certification)
            <div class="alert alert-info mt-3">
                <i class="bi bi-info-circle me-2"></i>
                You're interested in <strong>{{ $certification->name }}</strong>
            </div>
        @endif
    </div>

    <!-- Pricing Cards -->
    <div class="row g-4 mb-5">
        @foreach($plans as $plan)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm {{ $plan->is_popular ? 'border-primary' : '' }}">
                    @if($plan->is_popular)
                        <div class="card-header bg-primary text-white text-center py-2">
                            <small class="fw-bold">MOST POPULAR</small>
                        </div>
                    @endif
                    @if($plan->is_featured && !$plan->is_popular)
                        <div class="card-header bg-success text-white text-center py-2">
                            <small class="fw-bold">BEST VALUE</small>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title text-center mb-3">{{ $plan->name }}</h3>
                        
                        <div class="text-center mb-4">
                            <div class="display-4 fw-bold">${{ number_format($plan->price, 0) }}</div>
                            <div class="text-muted">
                                per {{ $plan->billing_cycle === 'yearly' ? 'year' : 'month' }}
                            </div>
                            @if($plan->savings_percentage > 0)
                                <div class="badge bg-success mt-2">
                                    Save {{ $plan->savings_percentage }}%
                                </div>
                            @endif
                        </div>

                        <p class="text-muted text-center mb-4">{{ $plan->description }}</p>

                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Access to all certifications</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Unlimited practice questions</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Adaptive learning engine</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Performance analytics</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Timed exam simulations</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Mobile app access</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> {{ $plan->trial_period_days }}-day free trial</li>
                        </ul>

                        <form action="{{ route('learner.payment.subscription.checkout', $plan->id) }}" method="POST" class="mt-auto">
                            @csrf
                            <button type="submit" class="btn {{ $plan->is_popular ? 'btn-primary' : 'btn-outline-primary' }} w-100 btn-lg">
                                Start Free Trial
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Single Certification Option -->
    @if($certification)
        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-2">Just need {{ $certification->name }}?</h4>
                        <p class="text-muted mb-0">Get lifetime access to this certification only</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="h3 fw-bold mb-2">${{ number_format($certification->price_single_cert, 0) }}</div>
                        <form action="{{ route('learner.payment.certification.checkout', $certification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                Buy Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- FAQ Section -->
    <div class="row mt-5">
        <div class="col-md-8 mx-auto">
            <h3 class="text-center mb-4">Frequently Asked Questions</h3>
            
            <div class="accordion" id="pricingFAQ">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            How does the free trial work?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#pricingFAQ">
                        <div class="accordion-body">
                            Start your 7-day free trial with full access to all features. No credit card required. Cancel anytime during the trial period without being charged.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Can I cancel my subscription?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#pricingFAQ">
                        <div class="accordion-body">
                            Yes, you can cancel your subscription at any time. You'll continue to have access until the end of your current billing period.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            What's the difference between plans?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#pricingFAQ">
                        <div class="accordion-body">
                            All plans include the same features. The annual plan offers significant savings (31% off) compared to monthly billing.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            Do you offer refunds?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#pricingFAQ">
                        <div class="accordion-body">
                            Yes, we offer a 30-day money-back guarantee. If you're not satisfied, contact us for a full refund within 30 days of purchase.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trust Signals -->
    <div class="text-center mt-5 pt-5 border-top">
        <div class="row">
            <div class="col-md-3 col-6 mb-3">
                <div class="h2 fw-bold text-primary">10,000+</div>
                <div class="text-muted">Active Learners</div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="h2 fw-bold text-primary">87%</div>
                <div class="text-muted">Pass Rate</div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="h2 fw-bold text-primary">50,000+</div>
                <div class="text-muted">Practice Questions</div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="h2 fw-bold text-primary">18</div>
                <div class="text-muted">Certifications</div>
            </div>
        </div>
    </div>
</div>
@endsection
