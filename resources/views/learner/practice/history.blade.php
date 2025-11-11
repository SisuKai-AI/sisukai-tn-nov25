@extends('layouts.learner')

@section('title', 'Practice History')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="fw-bold mb-4">Practice History</h2>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-clipboard-check text-primary" style="font-size: 2rem;"></i>
                    <h3 class="fw-bold mt-2 mb-0">{{ $stats['total_sessions'] }}</h3>
                    <small class="text-muted">Total Sessions</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-question-circle text-info" style="font-size: 2rem;"></i>
                    <h3 class="fw-bold mt-2 mb-0">{{ $stats['total_questions'] }}</h3>
                    <small class="text-muted">Questions Practiced</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up text-success" style="font-size: 2rem;"></i>
                    <h3 class="fw-bold mt-2 mb-0">{{ round($stats['average_score'], 1) }}%</h3>
                    <small class="text-muted">Average Score</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                    <h3 class="fw-bold mt-2 mb-0">{{ $stats['total_correct'] }}</h3>
                    <small class="text-muted">Correct Answers</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Practice Sessions List -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Your Practice Sessions</h5>
        </div>
        <div class="card-body">
            @if($sessions->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                <p class="text-muted mt-3">No practice sessions yet.</p>
                <a href="{{ route('learner.certifications.index') }}" class="btn btn-primary">
                    <i class="bi bi-play-circle me-2"></i>Start Practicing
                </a>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Certification</th>
                            <th>Type</th>
                            <th>Score</th>
                            <th>Questions</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $session)
                        <tr>
                            <td>
                                <strong>{{ $session->certification->name }}</strong>
                                @if($session->domain)
                                <br><small class="text-muted">{{ $session->domain->name }}</small>
                                @endif
                                @if($session->topic)
                                <br><small class="text-muted">{{ $session->topic->name }}</small>
                                @endif
                            </td>
                            <td>
                                @if($session->session_type === 'weak_domains')
                                    <span class="badge bg-warning">Weak Domains</span>
                                @elseif($session->session_type === 'domain')
                                    <span class="badge bg-info">Domain Focus</span>
                                @elseif($session->session_type === 'topic')
                                    <span class="badge bg-primary">Topic Focus</span>
                                @else
                                    <span class="badge bg-secondary">Quick Practice</span>
                                @endif
                            </td>
                            <td>
                                @if($session->completed)
                                <span class="fw-bold 
                                    @if($session->score_percentage >= 80) text-success
                                    @elseif($session->score_percentage >= 60) text-info
                                    @else text-danger
                                    @endif">
                                    {{ $session->score_percentage }}%
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $session->total_questions }}</td>
                            <td>
                                <small>{{ $session->created_at->format('M d, Y') }}</small>
                                <br><small class="text-muted">{{ $session->created_at->format('g:i A') }}</small>
                            </td>
                            <td>
                                @if($session->completed)
                                <span class="badge bg-success">Completed</span>
                                @else
                                <span class="badge bg-warning">In Progress</span>
                                @endif
                            </td>
                            <td>
                                @if($session->completed)
                                <a href="{{ route('learner.practice.results', $session->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                @else
                                <a href="{{ route('learner.practice.take', $session->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-play-circle"></i> Resume
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $sessions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
