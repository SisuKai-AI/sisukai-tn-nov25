@extends('layouts.learner')

@section('title', 'My Certifications')

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">My Certifications</h4>
        <p class="text-muted mb-0">Track your enrolled certifications and progress</p>
    </div>
    <a href="{{ route('learner.certifications.index') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Browse Certifications
    </a>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($certifications->count() > 0)
    <div class="row g-4">
        @foreach($certifications as $certification)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge bg-primary">{{ $certification->provider }}</span>
                            <span class="badge bg-{{ $certification->pivot->status == 'completed' ? 'success' : ($certification->pivot->status == 'in_progress' ? 'warning' : 'info') }}">
                                {{ ucfirst(str_replace('_', ' ', $certification->pivot->status)) }}
                            </span>
                        </div>
                        
                        <!-- Certification Name -->
                        <h5 class="card-title mb-3">{{ $certification->name }}</h5>
                        
                        <!-- Progress Bar -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Progress</small>
                                <small class="fw-bold">{{ $certification->pivot->progress_percentage }}%</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-{{ $certification->pivot->progress_percentage == 100 ? 'success' : 'primary' }}" 
                                     role="progressbar" 
                                     style="width: {{ $certification->pivot->progress_percentage }}%">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Stats -->
                        <div class="mb-3" style="flex-grow: 1;">
                            <div class="row g-2 text-center">
                                <div class="col-6">
                                    <div class="p-2 bg-light rounded">
                                        <div class="fw-bold text-primary">{{ $certification->practice_sessions_count }}</div>
                                        <small class="text-muted">Practice Sessions</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 bg-light rounded">
                                        <div class="fw-bold text-success">{{ $certification->exam_attempts_count }}</div>
                                        <small class="text-muted">Exam Attempts</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Enrollment Date -->
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                Enrolled {{ \Carbon\Carbon::parse($certification->pivot->enrolled_at)->diffForHumans() }}
                            </small>
                        </div>
                        
                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('learner.certifications.show', $certification) }}" class="btn btn-primary">
                                <i class="bi bi-eye me-1"></i> View Details
                            </a>
                            @if($certification->pivot->status != 'completed')
                                <a href="{{ route('learner.practice.recommendations', $certification) }}" class="btn btn-outline-success">
                                    <i class="bi bi-play-circle me-1"></i> Continue Learning
                                </a>
                            @else
                                <button class="btn btn-outline-success" disabled>
                                    <i class="bi bi-trophy me-1"></i> View Certificate
                                </button>
                            @endif
                        </div>
                        <small class="text-muted text-center mt-2">
                            <i class="bi bi-info-circle me-1"></i>Learning features coming soon!
                        </small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <!-- Empty State -->
    <div class="card">
        <div class="card-body">
            <div class="empty-state py-5">
                <i class="bi bi-award"></i>
                <h6>No certifications yet</h6>
                <p>Start your learning journey by enrolling in a certification</p>
                <a href="{{ route('learner.certifications.index') }}" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i> Browse Certifications
                </a>
            </div>
        </div>
    </div>
@endif
@endsection

