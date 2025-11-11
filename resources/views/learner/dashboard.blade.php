@extends('layouts.learner')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4>Congratulations {{ auth('learner')->user()->name }}! 🎉</h4>
            <p class="mb-0">You have done great progress this week. Check your new achievements in your profile.</p>
            <button class="btn btn-light btn-sm mt-3">View Achievements</button>
        </div>
        <div class="col-md-4 d-none d-md-block text-end">
            <div class="welcome-illustration">
                📚
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card stats-card">
            <div class="card-body">
                <div class="stats-icon primary">
                    <i class="bi bi-award"></i>
                </div>
                <div class="stats-title">Certifications</div>
                <div class="stats-value">{{ $stats['enrolled_certifications'] }}</div>
                <div class="stats-change {{ $stats['enrolled_certifications'] > 0 ? 'positive' : '' }}">
                    <i class="bi bi-{{ $stats['enrolled_certifications'] > 0 ? 'arrow-up' : 'dash' }}"></i> {{ $stats['enrolled_certifications'] > 0 ? 'Enrolled' : 'Get started' }}
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card stats-card">
            <div class="card-body">
                <div class="stats-icon success">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stats-title">Practice Sessions</div>
                <div class="stats-value">{{ $stats['practice_sessions'] }}</div>
                <div class="stats-change {{ $stats['practice_sessions'] > 0 ? 'positive' : '' }}">
                    <i class="bi bi-{{ $stats['practice_sessions'] > 0 ? 'arrow-up' : 'dash' }}"></i> {{ $stats['practice_sessions'] > 0 ? 'Keep going!' : 'Start practicing' }}
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card stats-card">
            <div class="card-body">
                <div class="stats-icon warning">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div class="stats-title">Average Score</div>
                <div class="stats-value">{{ $stats['average_score'] }}%</div>
                <div class="stats-change {{ $stats['average_score'] >= 80 ? 'positive' : ($stats['average_score'] >= 60 ? '' : 'negative') }}">
                    <i class="bi bi-{{ $stats['average_score'] >= 80 ? 'arrow-up' : ($stats['average_score'] > 0 ? 'dash' : 'dash') }}"></i> 
                    @if($stats['average_score'] >= 80)
                        Excellent!
                    @elseif($stats['average_score'] >= 60)
                        Good progress
                    @elseif($stats['average_score'] > 0)
                        Keep improving
                    @else
                        No sessions yet
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card stats-card">
            <div class="card-body">
                <div class="stats-icon danger">
                    <i class="bi bi-fire"></i>
                </div>
                <div class="stats-title">Study Streak</div>
                <div class="stats-value">{{ $stats['study_streak'] }} {{ Str::plural('Day', $stats['study_streak']) }}</div>
                <div class="stats-change {{ $stats['study_streak'] > 0 ? 'positive' : '' }}">
                    <i class="bi bi-{{ $stats['study_streak'] > 0 ? 'fire' : 'dash' }}"></i> 
                    @if($stats['study_streak'] >= 7)
                        On fire! 🔥
                    @elseif($stats['study_streak'] >= 3)
                        Keep it up!
                    @elseif($stats['study_streak'] > 0)
                        Great start!
                    @else
                        Start your streak!
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="row">
    <!-- Left Column -->
    <div class="col-lg-8">
        <!-- My Certifications Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Certifications</h5>
                <a href="{{ route('learner.certifications.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Browse Certifications
                </a>
            </div>
            <div class="card-body">
                @if($enrolledCertifications->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($enrolledCertifications as $certification)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <h6 class="mb-0 me-2">{{ $certification->name }}</h6>
                                            <span class="badge bg-{{ $certification->pivot->status == 'completed' ? 'success' : ($certification->pivot->status == 'in_progress' ? 'warning' : 'info') }} badge-sm">
                                                {{ ucfirst(str_replace('_', ' ', $certification->pivot->status)) }}
                                            </span>
                                        </div>
                                        <small class="text-muted">{{ $certification->provider }}</small>
                                        <div class="progress mt-2" style="height: 6px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $certification->pivot->progress_percentage }}%"></div>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <a href="{{ route('learner.certifications.show', $certification) }}" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('learner.certifications.my') }}" class="btn btn-outline-primary btn-sm">
                            View All Certifications <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-award"></i>
                        <h6>No certifications yet</h6>
                        <p>Start your learning journey by selecting a certification</p>
                        <a href="{{ route('learner.certifications.index') }}" class="btn btn-outline-primary">
                            Browse Certifications
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Recent Practice Sessions Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Practice Sessions</h5>
                @if($recentPracticeSessions->count() > 0)
                    <a href="{{ route('learner.practice.history') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if($recentPracticeSessions->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentPracticeSessions as $session)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $session->certification->name }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $session->completed_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-{{ $session->score_percentage >= 80 ? 'success' : ($session->score_percentage >= 60 ? 'primary' : 'danger') }}">
                                            {{ number_format($session->score_percentage, 1) }}%
                                        </span>
                                        <br>
                                        <small class="text-muted">{{ $session->total_questions }} questions</small>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('learner.practice.results', $session->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye me-1"></i> View Results
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-clock-history"></i>
                        <h6>No practice sessions yet</h6>
                        <p>Complete practice sessions to see your history here</p>
                        <a href="{{ route('learner.certifications.my') }}" class="btn btn-outline-primary">
                            Start Practicing
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Right Column -->
    <div class="col-lg-4">
        <!-- Study Streak Card -->
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-fire" style="font-size: 3rem; color: {{ $stats['study_streak'] > 0 ? 'var(--danger-color)' : '#ccc' }};"></i>
                </div>
                <h3 class="mb-1">{{ $stats['study_streak'] }} {{ Str::plural('Day', $stats['study_streak']) }}</h3>
                <p class="text-muted mb-3">Study Streak</p>
                <div class="progress mb-3" style="height: 8px;">
                    @php
                        $streakProgress = min(($stats['study_streak'] / 30) * 100, 100);
                    @endphp
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $streakProgress }}%"></div>
                </div>
                <small class="text-muted">
                    @if($stats['study_streak'] >= 30)
                        Amazing! You've hit the max streak! 🔥
                    @elseif($stats['study_streak'] >= 7)
                        Incredible! Keep the fire burning! 🔥
                    @elseif($stats['study_streak'] > 0)
                        Great job! Keep it going!
                    @else
                        Start practicing to build your streak!
                    @endif
                </small>
            </div>
        </div>
        
        <!-- Today's Study Plan Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Today's Study Plan</h6>
            </div>
            <div class="card-body">
                <div class="empty-state py-4">
                    <i class="bi bi-calendar-check"></i>
                    <h6>No study plan for today</h6>
                    <p class="mb-0">Create a study plan to get started</p>
                </div>
            </div>
        </div>
        
        <!-- Upcoming Exams Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Upcoming Exams</h6>
            </div>
            <div class="card-body">
                <div class="empty-state py-4">
                    <i class="bi bi-calendar-event"></i>
                    <h6>No upcoming exams</h6>
                    <p class="mb-0">Schedule an exam to test your knowledge</p>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-success" disabled>
                        <i class="bi bi-play-circle me-2"></i> Start Practice
                    </button>
                    <button class="btn btn-outline-primary" disabled>
                        <i class="bi bi-file-text me-2"></i> Take Exam
                    </button>
                    <button class="btn btn-outline-warning" disabled>
                        <i class="bi bi-graph-up me-2"></i> View Progress
                    </button>
                </div>
                <div class="alert alert-info mt-3 mb-0" style="font-size: 0.875rem;">
                    <i class="bi bi-info-circle me-2"></i> Features coming soon!
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Performance Overview -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Performance Overview</h5>
            </div>
            <div class="card-body">
                <div class="empty-state">
                    <i class="bi bi-bar-chart"></i>
                    <h6>Start practicing to see your performance metrics</h6>
                    <p>Your progress charts and analytics will appear here once you start learning</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
