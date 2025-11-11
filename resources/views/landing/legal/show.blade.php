@extends('layouts.landing')

@section('title', $page->title . ' - SisuKai')
@section('meta_description', Str::limit(strip_tags($page->content), 155))

@section('content')

<!-- Page Header -->
<section class="page-header bg-light" style="padding: 4rem 0 3rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h1 class="display-5 fw-bold mb-3">{{ $page->title }}</h1>
                <p class="text-muted mb-0">
                    <i class="bi bi-calendar me-1"></i>
                    Last updated: {{ $page->updated_at->format('F d, Y') }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Legal Content -->
<section class="landing-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="landing-card">
                    <div class="legal-content">
                        {!! $page->content !!}
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="mt-4">
                    <h5 class="mb-3">Related Legal Documents</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('landing.legal.show', 'privacy-policy') }}" class="btn btn-outline-custom btn-sm">
                            Privacy Policy
                        </a>
                        <a href="{{ route('landing.legal.show', 'terms-of-service') }}" class="btn btn-outline-custom btn-sm">
                            Terms of Service
                        </a>
                        <a href="{{ route('landing.legal.show', 'cookie-policy') }}" class="btn btn-outline-custom btn-sm">
                            Cookie Policy
                        </a>
                        <a href="{{ route('landing.legal.show', 'acceptable-use-policy') }}" class="btn btn-outline-custom btn-sm">
                            Acceptable Use Policy
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="landing-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h3 class="mb-3">Questions About Our Policies?</h3>
                <p class="text-muted mb-4">
                    If you have any questions or concerns about our legal policies, please don't hesitate to contact us.
                </p>
                <a href="{{ route('landing.contact') }}" class="btn btn-primary-custom">
                    <i class="bi bi-envelope me-2"></i>Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
.legal-content {
    font-size: 1rem;
    line-height: 1.7;
}

.legal-content h2 {
    margin-top: 2.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
    font-size: 1.75rem;
}

.legal-content h3 {
    margin-top: 2rem;
    margin-bottom: 0.75rem;
    font-weight: 600;
    font-size: 1.5rem;
}

.legal-content h4 {
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
    font-size: 1.25rem;
}

.legal-content p {
    margin-bottom: 1rem;
}

.legal-content ul, .legal-content ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.legal-content li {
    margin-bottom: 0.5rem;
}

.legal-content strong {
    font-weight: 600;
}

.legal-content a {
    color: #696cff;
    text-decoration: underline;
}

.legal-content a:hover {
    color: #5f61e6;
}

.legal-content table {
    width: 100%;
    margin-bottom: 1rem;
    border-collapse: collapse;
}

.legal-content table th,
.legal-content table td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
}

.legal-content table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
</style>
@endpush
