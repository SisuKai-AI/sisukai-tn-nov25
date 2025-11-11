@extends('layouts.landing')

@section('title', 'Help Center - SisuKai')
@section('meta_description', 'Find answers to common questions about SisuKai certification exam preparation platform.')

@section('content')

<!-- Page Header -->
<section class="page-header bg-primary-custom text-white" style="padding: 4rem 0 3rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">Help Center</h1>
                <p class="lead mb-4">
                    Find answers to common questions and get the help you need
                </p>
                
                <!-- Search Box -->
                <form action="{{ route('landing.help.search') }}" method="GET">
                    <div class="input-group input-group-lg mb-0">
                        <input type="text" 
                               class="form-control" 
                               placeholder="Search for help..." 
                               name="q"
                               id="helpSearch"
                               value="{{ request('q') }}">
                        <button class="btn btn-light" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@if($featuredArticles->count() > 0)
<!-- Featured Articles -->
<section class="landing-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Featured Articles</h2>
            <p class="section-subtitle">Most helpful articles to get you started</p>
        </div>
        
        <div class="row g-4">
            @foreach($featuredArticles as $article)
            <div class="col-lg-4 col-md-6">
                <div class="landing-card h-100">
                    <div class="d-flex align-items-start mb-3">
                        <div class="icon bg-primary-custom text-white me-3">
                            <i class="bi {{ $article->category->icon ?? 'bi-file-text' }}"></i>
                        </div>
                        <div>
                            <span class="badge bg-light text-dark mb-2">{{ $article->category->name }}</span>
                            <h5 class="mb-0">{{ $article->title }}</h5>
                        </div>
                    </div>
                    <p class="text-muted mb-3">
                        {{ Str::limit(strip_tags($article->content), 120) }}
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('landing.help.article.show', $article->slug) }}" class="btn btn-sm btn-outline-custom">
                            Read More <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                        <small class="text-muted">
                            <i class="bi bi-eye me-1"></i>{{ number_format($article->views) }} views
                        </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Help Categories -->
<section class="landing-section bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Browse by Category</h2>
            <p class="section-subtitle">Find help articles organized by topic</p>
        </div>
        
        @foreach($categories as $category)
        <div class="mb-5">
            <div class="d-flex align-items-center mb-4">
                <div class="icon bg-primary-custom text-white me-3">
                    <i class="bi {{ $category->icon }}"></i>
                </div>
                <div>
                    <h3 class="mb-1">{{ $category->name }}</h3>
                    <p class="text-muted mb-0">{{ $category->description }}</p>
                </div>
            </div>
            
            @if($category->articles->count() > 0)
            <div class="row g-3">
                @foreach($category->articles as $article)
                <div class="col-lg-6">
                    <div class="landing-card h-100">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="mb-2">
                                    <a href="{{ route('landing.help.article.show', $article->slug) }}" class="text-decoration-none text-dark">
                                        {{ $article->title }}
                                    </a>
                                </h5>
                                <p class="text-muted mb-2 small">
                                    {{ Str::limit(strip_tags($article->content), 100) }}
                                </p>
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="bi bi-eye me-1"></i>
                                    <span>{{ number_format($article->views) }} views</span>
                                    @if($article->is_featured)
                                    <span class="badge bg-warning text-dark ms-2">Featured</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>No articles available in this category yet.
            </div>
            @endif
        </div>
        @endforeach
    </div>
</section>

<!-- Contact Support -->
<section class="cta-section bg-primary-custom text-white" style="padding: 4rem 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0 text-center text-lg-start">
                <h2 class="fw-bold mb-3">Still Need Help?</h2>
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

@endsection
