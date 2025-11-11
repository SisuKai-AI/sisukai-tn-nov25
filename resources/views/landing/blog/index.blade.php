@extends('layouts.landing')

@section('title', 'Blog - SisuKai')
@section('meta_description', 'Read the latest articles, tips, and insights on certification exam preparation, study strategies, and career development.')

@section('content')

<!-- Page Header -->
<section class="page-header bg-primary-custom text-white" style="padding: 4rem 0 3rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">SisuKai Blog</h1>
                <p class="lead mb-0">
                    Tips, insights, and strategies to help you pass your certification exam
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Blog Posts -->
<section class="landing-section">
    <div class="container">
        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-lg-8">
                @if($posts->count() > 0)
                    <div class="row g-4">
                        @foreach($posts as $post)
                            <div class="col-12">
                                <div class="landing-card">
                                    <div class="row g-0">
                                        @if($post->featured_image)
                                            <div class="col-md-5">
                                                <img src="{{ asset($post->featured_image) }}" 
                                                     alt="{{ $post->title }}" 
                                                     class="img-fluid rounded-3 h-100" 
                                                     style="object-fit: cover; aspect-ratio: 16/9;">
                                            </div>
                                            <div class="col-md-7">
                                        @else
                                            <div class="col-12">
                                        @endif
                                                <div class="p-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        @if($post->category)
                                                            <span class="badge bg-primary-custom me-2">
                                                                {{ $post->category->name }}
                                                            </span>
                                                        @endif
                                                        <small class="text-muted">
                                                            <i class="bi bi-calendar me-1"></i>
                                                            {{ $post->published_at->format('M d, Y') }}
                                                        </small>
                                                        <small class="text-muted ms-3">
                                                            <i class="bi bi-eye me-1"></i>
                                                            {{ number_format($post->views) }} views
                                                        </small>
                                                    </div>
                                                    
                                                    <h4 class="mb-3">
                                                        <a href="{{ route('landing.blog.show', $post->slug) }}" 
                                                           class="text-decoration-none text-dark">
                                                            {{ $post->title }}
                                                        </a>
                                                    </h4>
                                                    
                                                    <p class="text-muted mb-3">
                                                        {{ Str::limit($post->excerpt ?? strip_tags($post->content), 150) }}
                                                    </p>
                                                    
                                                    <a href="{{ route('landing.blog.show', $post->slug) }}" 
                                                       class="btn btn-outline-custom btn-sm">
                                                        Read More <i class="bi bi-arrow-right ms-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $posts->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="landing-card text-center py-5">
                        <div class="icon bg-light text-muted mx-auto mb-4" style="width: 80px; height: 80px; line-height: 80px; font-size: 2rem;">
                            <i class="bi bi-inbox"></i>
                        </div>
                        <h4 class="mb-3">No Blog Posts Yet</h4>
                        <p class="text-muted mb-4">We're working on creating great content. Check back soon!</p>
                        <a href="{{ route('landing.home') }}" class="btn btn-primary-custom">
                            <i class="bi bi-house me-2"></i>Back to Home
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4 align-self-start">
                <!-- Categories -->
                @if($categories->count() > 0)
                    <div class="landing-card mb-4">
                        <h5 class="mb-3">Categories</h5>
                        <div class="list-group list-group-flush">
                            @foreach($categories as $category)
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    {{ $category->name }}
                                    <span class="badge bg-primary-custom rounded-pill">
                                        {{ $category->posts_count }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Newsletter -->
                <div class="landing-card bg-primary-custom text-white">
                    <h5 class="mb-3">Subscribe to Our Newsletter</h5>
                    <p class="mb-3 opacity-75">
                        Get the latest tips and insights delivered to your inbox.
                    </p>
                    <form id="newsletterForm">
                        @csrf
                        <div class="input-group mb-2">
                            <input type="email" 
                                   class="form-control" 
                                   placeholder="Your email" 
                                   name="email" 
                                   required>
                            <button type="submit" class="btn btn-light">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                        <small class="opacity-75">We respect your privacy. Unsubscribe anytime.</small>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.getElementById('newsletterForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = this;
    const email = form.querySelector('input[name="email"]').value;
    const button = form.querySelector('button[type="submit"]');
    const originalButtonText = button.innerHTML;
    
    button.disabled = true;
    button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    
    try {
        const response = await fetch('{{ route("landing.newsletter.subscribe") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Thank you for subscribing!');
            form.reset();
        } else {
            alert(data.message || 'Something went wrong. Please try again.');
        }
    } catch (error) {
        alert('Something went wrong. Please try again.');
    } finally {
        button.disabled = false;
        button.innerHTML = originalButtonText;
    }
});
</script>
@endpush
