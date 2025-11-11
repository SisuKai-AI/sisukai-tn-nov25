@extends('layouts.landing')

@section('title', $certification->name . ' Practice Questions & Exam Prep - SisuKai')
@section('meta_description', 'Pass the ' . $certification->name . ' exam with ' . ($certification->exam_question_count ?? 0) . '+ practice questions. 7-day free trial. Join ' . ($activeStudents ?? '10,000') . '+ successful students.')

@section('content')

<!-- Page Header -->
<section class="page-header bg-primary-custom text-white" style="padding: 4rem 0 3rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ route('landing.certifications.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Back to Catalog
                    </a>
                    <div>
                        <span class="badge bg-light text-primary me-2">{{ $certification->provider }}</span>
                        @if($certification->landingQuizQuestions()->count() == 5)
                            <span class="badge bg-success"><i class="bi bi-star-fill me-1"></i>Free Quiz Available</span>
                        @endif
                    </div>
                </div>
                <h1 class="display-4 fw-bold mb-3">{{ $certification->name }}</h1>
                <p class="lead mb-4">{{ $certification->description }}</p>
                
                <!-- Quick Stats -->
                <div class="row g-3 text-center">
                    <div class="col-6 col-md-3">
                        <div class="bg-white bg-opacity-10 rounded p-3">
                            <h3 class="mb-0">{{ $certification->exam_question_count ?? 0 }}+</h3>
                            <small>Practice Questions</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="bg-white bg-opacity-10 rounded p-3">
                            <h3 class="mb-0">{{ $activeStudents ?? '10,000' }}+</h3>
                            <small>Active Students</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="bg-white bg-opacity-10 rounded p-3">
                            <h3 class="mb-0">{{ $passRate ?? '87' }}%</h3>
                            <small>Pass Rate</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="bg-white bg-opacity-10 rounded p-3">
                            <h3 class="mb-0">{{ $certification->exam_duration_minutes ?? 90 }}</h3>
                            <small>Minutes Exam</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="landing-section">
    <div class="container">
        <div class="row">
            <!-- Main Content Column -->
            <div class="col-lg-8 mb-4 mb-lg-0">
                
                <!-- Certification Overview -->
                <div class="landing-card mb-4">
                    <h2 class="mb-4">Certification Overview</h2>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="icon bg-primary-custom text-white me-3" style="width: 48px; height: 48px; line-height: 48px;">
                                    <i class="bi bi-question-circle"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Question Bank</small>
                                    <strong>{{ $certification->exam_question_count ?? 0 }} Questions</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="icon bg-success text-white me-3" style="width: 48px; height: 48px; line-height: 48px;">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Exam Duration</small>
                                    <strong>{{ $certification->exam_duration_minutes ?? 'N/A' }} Minutes</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="icon bg-info text-white me-3" style="width: 48px; height: 48px; line-height: 48px;">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Passing Score</small>
                                    <strong>{{ $certification->passing_score ?? 'N/A' }}%</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="icon bg-warning text-white me-3" style="width: 48px; height: 48px; line-height: 48px;">
                                    <i class="bi bi-diagram-3"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Exam Domains</small>
                                    <strong>{{ $certification->domains_count ?? 0 }} Domains</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Why Choose SisuKai Section -->
                <div class="landing-card mb-4">
                    <h2 class="mb-4">Why Choose SisuKai for {{ $certification->name }}?</h2>
                    <p class="lead mb-4">SisuKai provides the most comprehensive and effective exam preparation platform for {{ $certification->name }}. Our adaptive learning engine ensures you're fully prepared to pass on your first attempt.</p>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="icon bg-primary-custom text-white me-3 flex-shrink-0" style="width: 40px; height: 40px; line-height: 40px; font-size: 1.25rem;">
                                    <i class="bi bi-check2-circle"></i>
                                </div>
                                <div>
                                    <h5 class="mb-2">Comprehensive Question Bank</h5>
                                    <p class="text-muted mb-0">{{ $certification->exam_question_count ?? 0 }}+ practice questions covering all exam objectives and domains.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="icon bg-success text-white me-3 flex-shrink-0" style="width: 40px; height: 40px; line-height: 40px; font-size: 1.25rem;">
                                    <i class="bi bi-graph-up-arrow"></i>
                                </div>
                                <div>
                                    <h5 class="mb-2">Adaptive Learning Engine</h5>
                                    <p class="text-muted mb-0">Our AI-powered system adapts to your learning style and focuses on your weak areas.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="icon bg-info text-white me-3 flex-shrink-0" style="width: 40px; height: 40px; line-height: 40px; font-size: 1.25rem;">
                                    <i class="bi bi-clipboard-data"></i>
                                </div>
                                <div>
                                    <h5 class="mb-2">Performance Analytics</h5>
                                    <p class="text-muted mb-0">Track your progress with detailed analytics and identify areas for improvement.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="icon bg-warning text-white me-3 flex-shrink-0" style="width: 40px; height: 40px; line-height: 40px; font-size: 1.25rem;">
                                    <i class="bi bi-stopwatch"></i>
                                </div>
                                <div>
                                    <h5 class="mb-2">Timed Exam Simulations</h5>
                                    <p class="text-muted mb-0">Practice under real exam conditions with timed mock exams.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Free Quiz Section -->
                @if($certification->landingQuizQuestions()->count() == 5)
                <div class="landing-card mb-4" id="quiz-section">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-2">Test Your Knowledge - Free 5-Question Quiz</h2>
                            <p class="text-muted mb-0">See how prepared you are for the {{ $certification->name }} exam</p>
                        </div>
                        <span class="badge bg-success"><i class="bi bi-star-fill me-1"></i>Free</span>
                    </div>
                    
                    @include('landing.certifications.partials.quiz-component')
                </div>
                @endif

                <!-- Exam Domains -->
                @if($certification->domains && $certification->domains->count() > 0)
                <div class="landing-card mb-4">
                    <h2 class="mb-4">{{ $certification->name }} Exam Domains</h2>
                    <p class="mb-4">The {{ $certification->name }} exam covers the following domains. Our practice questions are distributed across all domains to ensure comprehensive coverage.</p>
                    <div class="list-group list-group-flush">
                        @foreach($certification->domains as $domain)
                            <div class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h5 class="mb-2">{{ $domain->name }}</h5>
                                    <p class="text-muted mb-0">{{ $domain->description }}</p>
                                </div>
                                <span class="badge bg-primary-custom rounded-pill ms-3">
                                    {{ $domain->weight ?? 0 }}%
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Who Should Take This Certification -->
                <div class="landing-card mb-4">
                    <h2 class="mb-4">Who Should Take the {{ $certification->name }}?</h2>
                    <p class="mb-4">The {{ $certification->name }} certification is ideal for professionals looking to validate their skills and advance their careers in {{ $certification->provider }}.</p>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-person-check-fill text-primary-custom me-2 mt-1 fs-5"></i>
                                <div>
                                    <strong>IT Professionals</strong>
                                    <p class="text-muted small mb-0">Looking to validate and expand their technical expertise</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-person-check-fill text-primary-custom me-2 mt-1 fs-5"></i>
                                <div>
                                    <strong>Career Changers</strong>
                                    <p class="text-muted small mb-0">Transitioning into technology roles</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-person-check-fill text-primary-custom me-2 mt-1 fs-5"></i>
                                <div>
                                    <strong>Students & Graduates</strong>
                                    <p class="text-muted small mb-0">Building credentials for entry-level positions</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-person-check-fill text-primary-custom me-2 mt-1 fs-5"></i>
                                <div>
                                    <strong>Experienced Professionals</strong>
                                    <p class="text-muted small mb-0">Seeking career advancement and salary increases</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- How to Prepare -->
                <div class="landing-card mb-4">
                    <h2 class="mb-4">How to Prepare for the {{ $certification->name }} Exam</h2>
                    <p class="mb-4">Follow our proven 4-step preparation method to maximize your chances of passing the {{ $certification->name }} exam on your first attempt.</p>
                    
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="d-flex">
                                <div class="bg-primary-custom text-white rounded-circle me-3 flex-shrink-0" style="width: 48px; height: 48px; line-height: 48px; text-align: center; font-weight: bold;">
                                    1
                                </div>
                                <div>
                                    <h5 class="mb-2">Take a Benchmark Exam</h5>
                                    <p class="text-muted mb-0">Start with our diagnostic exam to identify your current knowledge level and weak areas.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex">
                                <div class="bg-primary-custom text-white rounded-circle me-3 flex-shrink-0" style="width: 48px; height: 48px; line-height: 48px; text-align: center; font-weight: bold;">
                                    2
                                </div>
                                <div>
                                    <h5 class="mb-2">Practice with Adaptive Questions</h5>
                                    <p class="text-muted mb-0">Use our adaptive learning engine to focus on your weak areas and reinforce your knowledge.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex">
                                <div class="bg-primary-custom text-white rounded-circle me-3 flex-shrink-0" style="width: 48px; height: 48px; line-height: 48px; text-align: center; font-weight: bold;">
                                    3
                                </div>
                                <div>
                                    <h5 class="mb-2">Review Performance Analytics</h5>
                                    <p class="text-muted mb-0">Track your progress and adjust your study plan based on detailed performance metrics.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex">
                                <div class="bg-primary-custom text-white rounded-circle me-3 flex-shrink-0" style="width: 48px; height: 48px; line-height: 48px; text-align: center; font-weight: bold;">
                                    4
                                </div>
                                <div>
                                    <h5 class="mb-2">Take Timed Mock Exams</h5>
                                    <p class="text-muted mb-0">Simulate the real exam experience with timed practice exams to build confidence.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="landing-card mb-4">
                    <h2 class="mb-4">Frequently Asked Questions</h2>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    How many practice questions are included?
                                </button>
                            </h3>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Our {{ $certification->name }} question bank includes {{ $certification->exam_question_count ?? 0 }}+ practice questions covering all exam domains and objectives. All questions include detailed explanations.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    How long does it take to prepare?
                                </button>
                            </h3>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Most students prepare in 4-6 weeks with consistent daily practice. Our adaptive learning engine helps you focus on weak areas to optimize your study time.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Is there a money-back guarantee?
                                </button>
                            </h3>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes! If you don't pass your exam after completing our full preparation program, we'll refund your subscription. Terms and conditions apply.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Can I access this on mobile devices?
                                </button>
                            </h3>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Absolutely! SisuKai is fully responsive and works on all devices including smartphones, tablets, and desktop computers. Study anywhere, anytime.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- CTA Card -->
                <div class="landing-card sticky-top mb-4" style="top: 2rem;">
                    <div class="text-center mb-4">
                        <div class="icon bg-primary-custom text-white mx-auto mb-3" style="width: 64px; height: 64px; line-height: 64px; font-size: 2rem;">
                            <i class="bi bi-award"></i>
                        </div>
                        <h4 class="mb-2">Start Your Free Trial</h4>
                        <p class="text-muted mb-3">
                            Join {{ $activeStudents ?? '10,000' }}+ students preparing for {{ $certification->name }}
                        </p>
                        
                        <!-- Urgency Element -->
                        <div class="alert alert-warning py-2 mb-3">
                            <small><i class="bi bi-people-fill me-1"></i><strong>{{ $studyingNow ?? '127' }}</strong> people studying this now</small>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mb-3">
                        <a href="{{ route('register') }}?cert={{ $certification->slug }}" class="btn btn-primary-custom btn-lg">
                            <i class="bi bi-rocket-takeoff me-2"></i>Start 7-Day Free Trial
                        </a>
                        <a href="{{ route('landing.pricing') }}" class="btn btn-outline-custom">
                            View Pricing Plans
                        </a>
                    </div>
                    
                    <div class="text-center mb-3">
                        <small class="text-muted">
                            <i class="bi bi-check-circle-fill text-success me-1"></i>7-day free trial<br>
                            <i class="bi bi-check-circle-fill text-success me-1"></i>No credit card required<br>
                            <i class="bi bi-check-circle-fill text-success me-1"></i>Cancel anytime
                        </small>
                    </div>
                    
                    <hr class="my-3">
                    
                    <!-- Trust Badges -->
                    <div class="text-center">
                        <small class="text-muted d-block mb-2">Trusted by professionals worldwide</small>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <span class="badge bg-light text-dark border">⭐ 4.8/5.0</span>
                            <span class="badge bg-light text-dark border">🔒 Secure</span>
                            <span class="badge bg-light text-dark border">✓ Verified</span>
                        </div>
                    </div>
                </div>

                <!-- Social Proof / Testimonials -->
                @if(isset($testimonials) && $testimonials->count() > 0)
                <div class="landing-card mb-4">
                    <h5 class="mb-3">What Students Say</h5>
                    @foreach($testimonials->take(2) as $testimonial)
                        <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-primary-custom text-white rounded-circle me-2" style="width: 32px; height: 32px; line-height: 32px; text-align: center; font-size: 0.875rem;">
                                    {{ substr($testimonial->name, 0, 1) }}
                                </div>
                                <div>
                                    <strong class="d-block small">{{ $testimonial->name }}</strong>
                                    <small class="text-muted">{{ $testimonial->title ?? 'Certified Professional' }}</small>
                                </div>
                            </div>
                            <div class="mb-2">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="bi bi-star-fill text-warning small"></i>
                                @endfor
                            </div>
                            <p class="small mb-0">"{{ Str::limit($testimonial->content, 120) }}"</p>
                        </div>
                    @endforeach
                </div>
                @endif

                <!-- Money Back Guarantee -->
                <div class="landing-card bg-success bg-opacity-10 border-success">
                    <div class="text-center">
                        <i class="bi bi-shield-check text-success fs-1 mb-2"></i>
                        <h6 class="mb-2">Money-Back Guarantee</h6>
                        <p class="small text-muted mb-0">Pass your exam or get your money back. We're confident in our preparation method.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Certifications -->
@if(isset($relatedCertifications) && $relatedCertifications->count() > 0)
<section class="landing-section bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Related Certifications</h2>
            <p class="section-subtitle">Expand your skills with these related certifications from {{ $certification->provider }}</p>
        </div>
        
        <div class="row g-4">
            @foreach($relatedCertifications->take(3) as $related)
                <div class="col-lg-4">
                    <div class="landing-card h-100">
                        <div class="d-flex align-items-start mb-3">
                            <div class="icon bg-primary-custom text-white me-3">
                                <i class="bi bi-award"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $related->name }}</h5>
                                <small class="text-muted">{{ $related->provider }}</small>
                            </div>
                        </div>
                        <p class="text-muted mb-3">{{ Str::limit($related->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center text-muted small mb-3">
                            <span><i class="bi bi-question-circle me-1"></i>{{ $related->exam_question_count ?? 0 }} Questions</span>
                            <span><i class="bi bi-clock me-1"></i>{{ $related->exam_duration_minutes ?? 'N/A' }} min</span>
                        </div>
                        <a href="{{ route('landing.certifications.show', $related->slug) }}" class="btn btn-outline-custom w-100">
                            Learn More
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
