@extends('layouts.learner')

@section('title', $certification->name)

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Back Button -->
<div class="mb-3">
    <a href="{{ route('learner.certifications.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Certifications
    </a>
</div>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Certification Header -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge bg-primary mb-2">{{ $certification->provider }}</span>
                        @if($enrollment)
                            <span class="badge bg-success mb-2 ms-1">
                                <i class="bi bi-check-circle me-1"></i>Enrolled
                            </span>
                        @endif
                    </div>
                    <h3 class="text-success fw-bold mb-0">${{ number_format($certification->price_single_cert, 2) }}</h3>
                </div>
                
                <h3 class="mb-3">{{ $certification->name }}</h3>
                <p class="text-muted">{{ $certification->description }}</p>
            </div>
        </div>
        
        <!-- Exam Requirements -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-clipboard-check me-2"></i>Exam Requirements</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="bi bi-question-circle text-primary" style="font-size: 2rem;"></i>
                            <h4 class="mt-2 mb-0">{{ $certification->exam_question_count }}</h4>
                            <small class="text-muted">Questions</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="bi bi-clock text-warning" style="font-size: 2rem;"></i>
                            <h4 class="mt-2 mb-0">{{ $certification->exam_duration_minutes }}</h4>
                            <small class="text-muted">Minutes</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="bi bi-trophy text-success" style="font-size: 2rem;"></i>
                            <h4 class="mt-2 mb-0">{{ $certification->passing_score }}%</h4>
                            <small class="text-muted">Passing Score</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Domains Breakdown -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Certification Domains</h5>
            </div>
            <div class="card-body">
                @if($certification->domains->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($certification->domains as $domain)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $domain->name }}</h6>
                                        <small class="text-muted">{{ $domain->description }}</small>
                                    </div>
                                    <div class="text-end">
                                        @if($domain->weight_percentage)
                                            <span class="badge bg-info">{{ $domain->weight_percentage }}%</span>
                                        @endif
                                        <br>
                                        <small class="text-muted">{{ $domain->topics_count }} topics</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">No domains defined yet.</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Enrollment Status -->
        @if($enrollment)
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-check-circle me-2"></i>You're Enrolled!</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Status</small>
                        <span class="badge bg-{{ $progress['status'] == 'completed' ? 'success' : ($progress['status'] == 'in_progress' ? 'warning' : 'info') }}">
                            {{ ucfirst(str_replace('_', ' ', $progress['status'])) }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Progress</small>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $progress['progress_percentage'] }}%">
                                {{ $progress['progress_percentage'] }}%
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Enrolled</small>
                        <span>{{ \Carbon\Carbon::parse($progress['enrolled_at'])->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="d-grid gap-2">
                        @if($benchmarkStatus && $benchmarkStatus['exists'])
                            @if($benchmarkStatus['status'] === 'in_progress')
                                <!-- Resume Benchmark -->
                                <a href="{{ route('learner.benchmark.start', $certification->id) }}" class="btn btn-warning">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Resume Benchmark Exam
                                </a>
                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-info-circle me-1"></i>Complete your benchmark to unlock personalized practice
                                </small>
                            @elseif($benchmarkStatus['status'] === 'completed')
                                <!-- Continue Learning -->
                                <a href="{{ route('learner.practice.recommendations', $certification->id) }}" class="btn btn-success" id="continueLearningBtn">
                                    <i class="bi bi-play-circle me-2"></i>Continue Learning
                                </a>
                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-check-circle me-1"></i>Benchmark completed: {{ number_format($benchmarkStatus['score'], 1) }}%
                                </small>
                            @endif
                        @else
                            <!-- Take Benchmark -->
                            <a href="{{ route('learner.benchmark.explain', $certification->id) }}" class="btn btn-primary">
                                <i class="bi bi-speedometer2 me-2"></i>Take Benchmark Exam
                            </a>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i>Start with a diagnostic assessment to personalize your learning
                            </small>
                        @endif
                        
                        <form action="{{ route('learner.certifications.unenroll', $certification) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Are you sure you want to unenroll from this certification?')">
                                <i class="bi bi-x-circle me-2"></i>Unenroll
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Ready to start?</h5>
                    <p class="card-text text-muted">Enroll now and begin your certification journey.</p>
                    <form action="{{ route('learner.certifications.enroll', $certification) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle me-2"></i>Enroll Now
                        </button>
                    </form>
                </div>
            </div>
        @endif
        
        <!-- Statistics -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Statistics</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted"><i class="bi bi-question-circle me-2"></i>Questions</span>
                    <strong>{{ $stats['total_questions'] }}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted"><i class="bi bi-list-ul me-2"></i>Domains</span>
                    <strong>{{ $stats['total_domains'] }}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted"><i class="bi bi-people me-2"></i>Enrolled Learners</span>
                    <strong>{{ $stats['enrolled_learners'] }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

