@extends('layouts.landing')

@section('title', 'Certifications - SisuKai')
@section('meta_description', 'Browse our comprehensive catalog of certification exam preparation courses. Find the certification you need and start preparing today.')

@section('content')

<!-- Page Header -->
<section class="page-header bg-primary-custom text-white" style="padding: 4rem 0 3rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">Certification Catalog</h1>
                <p class="lead mb-0">
                    Choose from our comprehensive catalog of industry-recognized certifications
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Certifications Grid -->
<section class="landing-section">
    <div class="container">
        @if($certifications->count() > 0)
            <div class="row g-4">
                @foreach($certifications as $certification)
                    <div class="col-lg-4 col-md-6">
                        <div class="landing-card h-100">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon bg-primary-custom text-white me-3">
                                    <i class="bi bi-award"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">{{ $certification->name }}</h5>
                                    <small class="text-muted">{{ $certification->provider }}</small>
                                </div>
                            </div>
                            
                            <p class="text-muted mb-3">
                                {{ Str::limit($certification->description, 120) }}
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-question-circle me-1"></i>
                                    {{ $certification->exam_question_count ?? 0 }} Questions
                                </span>
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $certification->exam_duration_minutes ?? 'N/A' }} min
                                </span>
                            </div>
                            
                            <a href="{{ route('landing.certifications.show', $certification->slug) }}" 
                               class="btn btn-outline-custom w-100">
                                Learn More <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-5 d-flex justify-content-center">
                {{ $certifications->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="icon bg-light text-muted mx-auto mb-4" style="width: 80px; height: 80px; line-height: 80px; font-size: 2rem;">
                    <i class="bi bi-inbox"></i>
                </div>
                <h4 class="mb-3">No Certifications Available</h4>
                <p class="text-muted mb-4">We're working on adding new certifications. Check back soon!</p>
                <a href="{{ route('landing.home') }}" class="btn btn-primary-custom">
                    <i class="bi bi-house me-2"></i>Back to Home
                </a>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section bg-primary-custom text-white" style="padding: 4rem 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-3">Ready to Pass Your Certification Exam?</h2>
                <p class="mb-0 opacity-75">
                    Join thousands of professionals who have achieved certification success with SisuKai. 
                    Start your 7-day free trial today—no credit card required.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-rocket-takeoff me-2"></i>Start Free Trial Now
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
