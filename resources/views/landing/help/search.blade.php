@extends('layouts.landing')

@section('title', 'Search Results: ' . $query . ' - Help Center - SisuKai')
@section('meta_description', 'Search results for ' . $query . ' in SisuKai Help Center')

@section('content')

<!-- Page Header -->
<section class="page-header bg-primary-custom text-white" style="padding: 4rem 0 3rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold mb-3">Search Results</h1>
                <p class="lead mb-4">
                    Showing results for: <strong>"{{ $query }}"</strong>
                </p>
                
                <!-- Search Box -->
                <form action="{{ route('landing.help.search') }}" method="GET">
                    <div class="input-group input-group-lg mb-0">
                        <input type="text" 
                               class="form-control" 
                               placeholder="Search for help..." 
                               name="q"
                               value="{{ $query }}">
                        <button class="btn btn-light" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Search Results -->
<section class="landing-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                @if($articles->count() > 0)
                    <div class="mb-4">
                        <p class="text-muted">
                            Found <strong>{{ $articles->total() }}</strong> {{ Str::plural('result', $articles->total()) }}
                        </p>
                    </div>
                    
                    <!-- Results List -->
                    @foreach($articles as $article)
                    <div class="landing-card mb-4">
                        <div class="d-flex align-items-start">
                            <div class="icon bg-primary-custom text-white me-3 flex-shrink-0">
                                <i class="bi {{ $article->category->icon ?? 'bi-file-text' }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="mb-2">
                                    <span class="badge bg-light text-dark">{{ $article->category->name }}</span>
                                    @if($article->is_featured)
                                    <span class="badge bg-warning text-dark ms-1">Featured</span>
                                    @endif
                                </div>
                                <h4 class="mb-2">
                                    <a href="{{ route('landing.help.article.show', $article->slug) }}" class="text-decoration-none text-dark">
                                        {{ $article->title }}
                                    </a>
                                </h4>
                                <p class="text-muted mb-2">
                                    {{ Str::limit(strip_tags($article->content), 200) }}
                                </p>
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="bi bi-eye me-1"></i>
                                    <span class="me-3">{{ number_format($article->views) }} views</span>
                                    <i class="bi bi-clock me-1"></i>
                                    <span>Updated {{ $article->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <!-- Pagination -->
                    @if($articles->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $articles->appends(['q' => $query])->links() }}
                    </div>
                    @endif
                    
                @else
                    <!-- No Results -->
                    <div class="text-center py-5">
                        <div class="icon bg-light text-muted mx-auto mb-4" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 2rem;">
                            <i class="bi bi-search"></i>
                        </div>
                        <h3 class="mb-3">No Results Found</h3>
                        <p class="text-muted mb-4">
                            We couldn't find any articles matching "<strong>{{ $query }}</strong>".
                        </p>
                        <div class="mb-4">
                            <p class="mb-2"><strong>Suggestions:</strong></p>
                            <ul class="list-unstyled text-muted">
                                <li>• Check your spelling</li>
                                <li>• Try different keywords</li>
                                <li>• Use more general terms</li>
                                <li>• Browse our categories below</li>
                            </ul>
                        </div>
                        <a href="{{ route('landing.help.index') }}" class="btn btn-primary-custom">
                            <i class="bi bi-arrow-left me-2"></i>Back to Help Center
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Browse Categories -->
@if($articles->count() === 0)
<section class="landing-section bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Browse by Category</h2>
            <p class="section-subtitle">Explore our help articles organized by topic</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center h-100">
                    <div class="icon bg-primary-custom text-white mx-auto mb-3">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <h5 class="mb-3">Getting Started</h5>
                    <a href="{{ route('landing.help.index') }}#getting-started" class="btn btn-sm btn-outline-custom">
                        View Articles <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center h-100">
                    <div class="icon bg-success text-white mx-auto mb-3">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <h5 class="mb-3">Billing & Subscriptions</h5>
                    <a href="{{ route('landing.help.index') }}#billing" class="btn btn-sm btn-outline-custom">
                        View Articles <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="landing-card text-center h-100">
                    <div class="icon bg-info text-white mx-auto mb-3">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <h5 class="mb-3">Taking Exams</h5>
                    <a href="{{ route('landing.help.index') }}#exams" class="btn btn-sm btn-outline-custom">
                        View Articles <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

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
