@extends('layouts.landing')

@section('title', 'SisuKai - Pass Your Certification Exam, Guaranteed')
@section('meta_description', 'Adaptive practice engine, comprehensive question banks, and personalized learning paths. Pass your certification exam with confidence.')

@section('content')

<!-- Hero Section -->
<section class="hero-section bg-light-custom" style="padding: 6rem 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">Pass Your Certification Exam, Guaranteed</h1>
                <p class="lead text-muted mb-4">
                    Master your certification with our adaptive practice engine and comprehensive question banks. 
                    Join thousands of professionals who have achieved exam success with SisuKai.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">
                        <i class="bi bi-rocket-takeoff me-2"></i>
                        Start Your {{ $trialDays }}-Day Free Trial
                    </a>
                    <a href="#features" class="btn btn-outline-custom btn-lg">
                        <i class="bi bi-play-circle me-2"></i>
                        Learn More
                    </a>
                </div>
                <div class="mt-4">
                    <small class="text-muted">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>No credit card required
                        <i class="bi bi-check-circle-fill text-success ms-3 me-2"></i>Cancel anytime
                    </small>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="{{ asset('images/dashboard-preview.webp') }}" 
                         alt="SisuKai Dashboard" 
                         class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="landing-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Why Professionals Choose SisuKai</h2>
            <p class="section-subtitle">Everything you need to pass your certification exam on the first try</p>
        </div>
        
        <div class="row g-4">
            <!-- Feature 1: Adaptive Practice Engine -->
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center">
                    <div class="icon bg-primary-custom text-white mx-auto">
                        <i class="bi bi-cpu"></i>
                    </div>
                    <h4 class="mb-3">Adaptive Practice Engine</h4>
                    <p class="text-muted">
                        Our intelligent system adapts to your learning style and focuses on areas where you need the most improvement.
                    </p>
                </div>
            </div>
            
            <!-- Feature 2: Comprehensive Question Bank -->
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center">
                    <div class="icon bg-success text-white mx-auto">
                        <i class="bi bi-question-circle"></i>
                    </div>
                    <h4 class="mb-3">Comprehensive Question Bank</h4>
                    <p class="text-muted">
                        Access thousands of practice questions across multiple certifications, all updated regularly to match current exam standards.
                    </p>
                </div>
            </div>
            
            <!-- Feature 3: Real Exam Simulation -->
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center">
                    <div class="icon bg-info text-white mx-auto">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <h4 class="mb-3">Real Exam Simulation</h4>
                    <p class="text-muted">
                        Practice with timed exams that replicate the actual certification test environment and difficulty level.
                    </p>
                </div>
            </div>
            
            <!-- Feature 4: Performance Analytics -->
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center">
                    <div class="icon bg-warning text-white mx-auto">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h4 class="mb-3">Performance Analytics</h4>
                    <p class="text-muted">
                        Track your progress with detailed analytics showing strengths, weaknesses, and readiness scores.
                    </p>
                </div>
            </div>
            
            <!-- Feature 5: Detailed Explanations -->
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center">
                    <div class="icon bg-danger text-white mx-auto">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <h4 class="mb-3">Detailed Explanations</h4>
                    <p class="text-muted">
                        Every question includes comprehensive explanations to help you understand concepts, not just memorize answers.
                    </p>
                </div>
            </div>
            
            <!-- Feature 6: Study on Any Device -->
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center">
                    <div class="icon bg-secondary text-white mx-auto">
                        <i class="bi bi-phone"></i>
                    </div>
                    <h4 class="mb-3">Study on Any Device</h4>
                    <p class="text-muted">
                        Access your study materials anytime, anywhere on desktop, tablet, or mobile devices.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Certifications Showcase Section -->
<section class="landing-section bg-light-custom">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Popular Certifications</h2>
            <p class="section-subtitle">Choose from our comprehensive catalog of industry-recognized certifications</p>
        </div>
        
        <div class="row g-4">
            @forelse($certifications as $certification)
            <div class="col-lg-4 col-md-6">
                <div class="landing-card">
                    <div class="d-flex align-items-start mb-3">
                        <div class="icon bg-primary-custom text-white me-3" style="width: 50px; height: 50px; font-size: 1.5rem;">
                            <i class="bi bi-award"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $certification->name }}</h5>
                            <small class="text-muted">{{ $certification->code }}</small>
                        </div>
                    </div>
                    <p class="text-muted mb-3">{{ Str::limit($certification->description, 120) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-light text-dark">
                            <i class="bi bi-question-circle me-1"></i>
                            {{ $certification->questions_count ?? 0 }} Questions
                        </span>
                        <a href="{{ route('landing.certifications.show', $certification->slug) }}" class="btn btn-sm btn-outline-custom">
                            Learn More <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">No certifications available at the moment.</p>
            </div>
            @endforelse
        </div>
        
        @if($certifications->count() > 0)
        <div class="text-center mt-5">
            <a href="{{ route('landing.certifications.index') }}" class="btn btn-primary-custom btn-lg">
                View All Certifications <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Pricing Section -->
<section class="landing-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Simple, Transparent Pricing</h2>
            <p class="section-subtitle">Choose the plan that fits your certification goals</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            @foreach($plans as $plan)
            <div class="col-lg-4 col-md-6">
                <div class="landing-card {{ $plan->is_popular ? 'border-primary' : '' }}" style="position: relative;">
                    @if($plan->is_popular)
                    <div class="position-absolute top-0 start-50 translate-middle">
                        <span class="badge bg-primary-custom">Most Popular</span>
                    </div>
                    @endif
                    
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">{{ $plan->name }}</h4>
                        <div class="my-3">
                            @if($plan->price_monthly > 0 && $plan->certification_limit == 1)
                                {{-- Single Certification: One-time payment --}}
                                <span class="display-5 fw-bold text-primary-custom">${{ number_format($plan->price_monthly, 0) }}</span>
                                <span class="text-muted">one-time</span>
                            @elseif($plan->price_monthly > 0)
                                {{-- Monthly subscription --}}
                                <span class="display-5 fw-bold text-primary-custom">${{ number_format($plan->price_monthly, 2) }}</span>
                                <span class="text-muted">/month</span>
                            @elseif($plan->price_annual > 0)
                                {{-- Annual subscription --}}
                                <span class="display-5 fw-bold text-primary-custom">${{ number_format($plan->price_annual, 2) }}</span>
                                <span class="text-muted">/year</span>
                            @endif
                        </div>
                        @if($plan->price_annual > 0 && $plan->price_monthly > 0)
                        <small class="text-muted">
                            or ${{ number_format($plan->price_annual, 2) }}/year (save {{ round((1 - ($plan->price_annual / ($plan->price_monthly * 12))) * 100) }}%)
                        </small>
                        @endif
                    </div>
                    
                    <ul class="list-unstyled mb-4">
                        @if($plan->trial_days > 0)
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            {{ $plan->trial_days }}-day free trial
                        </li>
                        @endif
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            @if($plan->certification_limit == 0)
                                Unlimited certifications
                            @else
                                {{ $plan->certification_limit }} certification{{ $plan->certification_limit > 1 ? 's' : '' }}
                            @endif
                        </li>
                        @if($plan->features)
                            @foreach((is_array($plan->features) ? $plan->features : json_decode($plan->features, true)) as $feature)
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                {{ $feature }}
                            </li>
                            @endforeach
                        @endif
                    </ul>
                    
                    <div class="d-grid">
                        <a href="{{ route('register') }}" class="btn {{ $plan->is_popular ? 'btn-primary-custom' : 'btn-outline-custom' }}">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('landing.pricing') }}" class="btn btn-link">
                View detailed pricing comparison <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="landing-section bg-light-custom">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Trusted by Professionals Worldwide</h2>
            <p class="section-subtitle">See what our successful learners have to say</p>
        </div>
        
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($testimonials->chunk(3) as $index => $chunk)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach($chunk as $testimonial)
                        <div class="col-lg-4">
                            <div class="landing-card h-100">
                                <div class="mb-3">
                                    @for($i = 0; $i < $testimonial->rating; $i++)
                                    <i class="bi bi-star-fill text-warning"></i>
                                    @endfor
                                </div>
                                <p class="mb-4">"{{ $testimonial->content }}"</p>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary-custom text-white d-flex align-items-center justify-content-center me-3" 
                                         style="width: 50px; height: 50px; font-size: 1.25rem;">
                                        {{ substr($testimonial->author_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $testimonial->author_name }}</h6>
                                        <small class="text-muted">{{ $testimonial->author_title }}</small>
                                        @if($testimonial->company)
                                        <br><small class="text-muted">{{ $testimonial->company }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($testimonials->count() > 3)
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif
        </div>
    </div>
</section>

<!-- Final CTA Section -->
<section class="landing-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="section-title">Ready to Pass Your Certification Exam?</h2>
                <p class="section-subtitle">
                    Join thousands of professionals who have achieved certification success with SisuKai. 
                    Start your {{ $trialDays }}-day free trial today—no credit card required.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">
                        <i class="bi bi-rocket-takeoff me-2"></i>
                        Start Your Free Trial Now
                    </a>
                    <a href="{{ route('landing.contact') }}" class="btn btn-outline-custom btn-lg">
                        <i class="bi bi-envelope me-2"></i>
                        Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Newsletter modal auto-popup
    // Show modal after 5 seconds if user hasn't seen it in this session
    if (!sessionStorage.getItem('newsletterShown')) {
        setTimeout(function() {
            const newsletterModal = new bootstrap.Modal(document.getElementById('newsletterModal'));
            newsletterModal.show();
            sessionStorage.setItem('newsletterShown', 'true');
        }, 5000);
    }
</script>
@endpush
