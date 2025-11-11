@extends('layouts.learner')

@section('title', 'Browse Certifications')

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Browse Certifications</h4>
        <p class="text-muted mb-0">Explore and enroll in industry-recognized certifications</p>
    </div>
</div>

<!-- Search and Filter Bar -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('learner.certifications.index') }}">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="search" placeholder="Search certifications..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="provider">
                        <option value="">All Providers</option>
                        @foreach($providers as $provider)
                            <option value="{{ $provider }}" {{ request('provider') == $provider ? 'selected' : '' }}>
                                {{ $provider }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Certifications Grid -->
@if($certifications->count() > 0)
    <div class="row g-4">
        @foreach($certifications as $certification)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 hover-shadow">
                    <div class="card-body d-flex flex-column">
                        <!-- Provider Badge -->
                        <div class="mb-3">
                            <span class="badge bg-primary">{{ $certification->provider }}</span>
                            @if(in_array($certification->id, $enrolledIds))
                                <span class="badge bg-success ms-1">
                                    <i class="bi bi-check-circle me-1"></i>Enrolled
                                </span>
                            @endif
                        </div>
                        
                        <!-- Certification Name -->
                        <h5 class="card-title mb-3">{{ $certification->name }}</h5>
                        
                        <!-- Description -->
                        <p class="card-text text-muted small mb-3" style="flex-grow: 1;">
                            {{ Str::limit($certification->description, 120) }}
                        </p>
                        
                        <!-- Exam Details -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="bi bi-question-circle me-1"></i> {{ $certification->exam_question_count }} Questions</span>
                                <span><i class="bi bi-clock me-1"></i> {{ $certification->exam_duration_minutes }} mins</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted small">
                                <span><i class="bi bi-trophy me-1"></i> Passing: {{ $certification->passing_score }}%</span>
                                <span class="text-success fw-bold">${{ number_format($certification->price_single_cert, 2) }}</span>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            @if(in_array($certification->id, $enrolledIds))
                                <a href="{{ route('learner.certifications.show', $certification) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> View Details
                                </a>
                            @else
                                <a href="{{ route('learner.certifications.show', $certification) }}" class="btn btn-primary">
                                    <i class="bi bi-info-circle me-1"></i> Learn More
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="mt-4">
        {{ $certifications->links() }}
    </div>
@else
    <!-- Empty State -->
    <div class="card">
        <div class="card-body">
            <div class="empty-state py-5">
                <i class="bi bi-award"></i>
                <h6>No certifications found</h6>
                <p>Try adjusting your search or filter criteria</p>
                <a href="{{ route('learner.certifications.index') }}" class="btn btn-outline-primary">
                    Clear Filters
                </a>
            </div>
        </div>
    </div>
@endif

<style>
.hover-shadow {
    transition: all 0.3s ease;
}

.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}
</style>
@endsection

