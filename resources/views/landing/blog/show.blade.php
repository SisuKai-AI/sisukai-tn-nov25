@extends('layouts.landing')

@section('title', $post->title . ' - SisuKai Blog')
@section('meta_description', Str::limit($post->excerpt ?? strip_tags($post->content), 155))

@section('content')

<!-- Page Header -->
<section class="page-header bg-light" style="padding: 4rem 0 3rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <a href="{{ route('landing.blog.index') }}" class="btn btn-sm btn-outline-custom mb-3">
                    <i class="bi bi-arrow-left me-1"></i>Back to Blog
                </a>
                
                @if($post->category)
                    <span class="badge bg-primary-custom mb-3">{{ $post->category->name }}</span>
                @endif
                
                <h1 class="display-5 fw-bold mb-3">{{ $post->title }}</h1>
                
                <div class="d-flex align-items-center text-muted">
                    <small>
                        <i class="bi bi-calendar me-1"></i>
                        {{ $post->published_at->format('F d, Y') }}
                    </small>
                    <small class="ms-3">
                        <i class="bi bi-clock me-1"></i>
                        {{ $post->reading_time ?? '5' }} min read
                    </small>
                    <small class="ms-3">
                        <i class="bi bi-eye me-1"></i>
                        {{ number_format($post->view_count) }} views
                    </small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Post Content -->
<section class="landing-section" style="padding: 3rem 0;">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 mx-auto">
                @if($post->featured_image)
                    <div class="mb-4">
                        <img src="{{ $post->featured_image }}" 
                             alt="{{ $post->title }}" 
                             class="img-fluid rounded shadow">
                    </div>
                @endif
                
                <div class="landing-card">
                    <div class="blog-content">
                        {!! $post->content_html !!}
                    </div>
                    
                    @if($post->tags)
                        <div class="mt-4 pt-4 border-top">
                            <strong class="me-2">Tags:</strong>
                            @foreach(json_decode($post->tags, true) ?? [] as $tag)
                                <span class="badge bg-light text-dark me-1">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Share Buttons -->
                <div class="landing-card mt-4">
                    <h5 class="mb-3">Share this post</h5>
                    <div class="d-flex gap-2">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" 
                           target="_blank" 
                           class="btn btn-outline-custom">
                            <i class="bi bi-twitter me-1"></i>Twitter
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank" 
                           class="btn btn-outline-custom">
                            <i class="bi bi-facebook me-1"></i>Facebook
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                           target="_blank" 
                           class="btn btn-outline-custom">
                            <i class="bi bi-linkedin me-1"></i>LinkedIn
                        </a>
                        <button onclick="copyToClipboard()" class="btn btn-outline-custom">
                            <i class="bi bi-link-45deg me-1"></i>Copy Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Posts -->
@if($relatedPosts->count() > 0)
<section class="landing-section bg-light" style="padding: 3rem 0;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Related Articles</h2>
            <p class="section-subtitle">Continue reading with these related posts</p>
        </div>
        
        <div class="row g-4">
            @foreach($relatedPosts as $related)
                <div class="col-lg-4">
                    <div class="landing-card h-100">
                        @if($related->featured_image)
                            <img src="{{ $related->featured_image }}" 
                                 alt="{{ $related->title }}" 
                                 class="img-fluid rounded mb-3">
                        @endif
                        
                        <div class="d-flex align-items-center mb-2">
                            @if($related->category)
                                <span class="badge bg-primary-custom me-2">
                                    {{ $related->category->name }}
                                </span>
                            @endif
                            <small class="text-muted">
                                {{ $related->published_at->format('M d, Y') }}
                            </small>
                        </div>
                        
                        <h5 class="mb-3">
                            <a href="{{ route('landing.blog.show', $related->slug) }}" 
                               class="text-decoration-none text-dark">
                                {{ $related->title }}
                            </a>
                        </h5>
                        
                        <p class="text-muted mb-3">
                            {{ Str::limit($related->excerpt ?? strip_tags($related->content), 100) }}
                        </p>
                        
                        <a href="{{ route('landing.blog.show', $related->slug) }}" 
                           class="btn btn-outline-custom btn-sm">
                            Read More <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="cta-section bg-primary-custom text-white" style="padding: 3rem 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0 text-center text-lg-start">
                <h2 class="fw-bold mb-3">Ready to Start Your Certification Journey?</h2>
                <p class="mb-0 opacity-75">
                    Join thousands of professionals who have passed their certification exams with SisuKai.
                </p>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-rocket-takeoff me-2"></i>Start Free Trial
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
.blog-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.blog-content h2 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.blog-content h3 {
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    font-weight: 600;
}

.blog-content p {
    margin-bottom: 1.25rem;
}

.blog-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1.5rem 0;
}

.blog-content ul, .blog-content ol {
    margin-bottom: 1.25rem;
    padding-left: 2rem;
}

.blog-content li {
    margin-bottom: 0.5rem;
}

.blog-content blockquote {
    border-left: 4px solid #696cff;
    padding-left: 1.5rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6c757d;
}

.blog-content code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.9em;
}

.blog-content pre {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
}
</style>
@endpush

@push('scripts')
<script>
function copyToClipboard() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        alert('Link copied to clipboard!');
    }).catch(err => {
        console.error('Failed to copy:', err);
    });
}
</script>
@endpush
