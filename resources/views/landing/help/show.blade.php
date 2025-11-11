@extends('layouts.landing')

@section('title', $article->title . ' - Help Center - SisuKai')
@section('meta_description', Str::limit(strip_tags($article->content), 155))

@section('content')

<!-- Page Header -->
<section class="page-header bg-light" style="padding: 3rem 0 2rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('landing.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('landing.help.index') }}">Help Center</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $article->category->name }}</li>
                    </ol>
                </nav>
                
                <!-- Category Badge -->
                <div class="mb-3">
                    <span class="badge bg-primary-custom">
                        <i class="bi {{ $article->category->icon }} me-1"></i>
                        {{ $article->category->name }}
                    </span>
                    @if($article->is_featured)
                    <span class="badge bg-warning text-dark ms-2">
                        <i class="bi bi-star-fill me-1"></i>Featured
                    </span>
                    @endif
                </div>
                
                <!-- Article Title -->
                <h1 class="display-5 fw-bold mb-3">{{ $article->title }}</h1>
                
                <!-- Article Meta -->
                <div class="d-flex align-items-center text-muted mb-4">
                    <i class="bi bi-clock me-2"></i>
                    <span class="me-3">Updated {{ $article->updated_at->diffForHumans() }}</span>
                    <i class="bi bi-eye me-2"></i>
                    <span>{{ number_format($article->views) }} views</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="landing-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Article Body -->
                <div class="article-content mb-5">
                    {!! $article->content !!}
                </div>
                
                <!-- Article Footer -->
                <div class="border-top pt-4 mb-5">
                    @if($hasVoted)
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            Thank you for your feedback! We appreciate your input.
                        </div>
                    @else
                        <div class="d-flex justify-content-between align-items-center" id="feedback-section">
                            <div>
                                <p class="text-muted mb-0">Was this article helpful?</p>
                            </div>
                            <div>
                                <form action="{{ route('landing.help.article.feedback', $article->slug) }}" method="POST" class="d-inline" id="feedback-form-yes">
                                    @csrf
                                    <input type="hidden" name="is_helpful" value="1">
                                    <button type="submit" class="btn btn-sm btn-outline-success me-2">
                                        <i class="bi bi-hand-thumbs-up me-1"></i>Yes
                                    </button>
                                </form>
                                <form action="{{ route('landing.help.article.feedback', $article->slug) }}" method="POST" class="d-inline" id="feedback-form-no">
                                    @csrf
                                    <input type="hidden" name="is_helpful" value="0">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-hand-thumbs-down me-1"></i>No
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
                
                @if($relatedArticles->count() > 0)
                <!-- Related Articles -->
                <div class="bg-light p-4 rounded">
                    <h4 class="mb-4">Related Articles</h4>
                    <div class="row g-3">
                        @foreach($relatedArticles as $related)
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div class="icon bg-primary-custom text-white me-3 flex-shrink-0">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">
                                        <a href="{{ route('landing.help.article.show', $related->slug) }}" class="text-decoration-none text-dark">
                                            {{ $related->title }}
                                        </a>
                                    </h6>
                                    <p class="text-muted mb-0 small">
                                        {{ Str::limit(strip_tags($related->content), 100) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Contact Support -->
<section class="cta-section bg-primary-custom text-white" style="padding: 3rem 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0 text-center text-lg-start">
                <h3 class="fw-bold mb-2">Still Need Help?</h3>
                <p class="mb-0 opacity-75">
                    Can't find what you're looking for? Our support team is here to help you.
                </p>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <a href="{{ route('landing.contact') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-envelope me-2"></i>Contact Support
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.article-content h2 {
    font-size: 1.75rem;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.article-content h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

.article-content p {
    margin-bottom: 1rem;
}

.article-content ul, .article-content ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}

.article-content code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.9em;
}

.article-content pre {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
}

.article-content blockquote {
    border-left: 4px solid var(--bs-primary);
    padding-left: 1rem;
    margin: 1.5rem 0;
    color: #6c757d;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1.5rem 0;
}

.article-content table {
    width: 100%;
    margin-bottom: 1rem;
    border-collapse: collapse;
}

.article-content table th,
.article-content table td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
}

.article-content table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
</style>

@endsection
