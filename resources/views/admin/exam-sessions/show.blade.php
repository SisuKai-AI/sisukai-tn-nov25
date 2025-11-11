@extends('layouts.admin')

@section('title', 'Exam Session Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Exam Session Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.exam-sessions.index') }}">Exam Sessions</a></li>
                    <li class="breadcrumb-item active">{{ $examSession->id }}</li>
                </ol>
            </nav>
        </div>
        <div>
            @if($examSession->status == 'created')
                <a href="{{ route('admin.exam-sessions.edit', $examSession) }}" class="btn btn-secondary">
                    <i class="bi bi-pencil me-2"></i>Edit
                </a>
            @endif
            <a href="{{ route('admin.exam-sessions.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Session Overview -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Session Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Learner</label>
                            <div>
                                <strong>{{ $examSession->learner->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $examSession->learner->email }}</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Certification</label>
                            <div><strong>{{ $examSession->certification->name }}</strong></div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Exam Type</label>
                            <div>
                                @if($examSession->exam_type == 'benchmark')
                                    <span class="badge bg-info">Benchmark</span>
                                @elseif($examSession->exam_type == 'practice')
                                    <span class="badge bg-warning">Practice</span>
                                @else
                                    <span class="badge bg-primary">Final</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Status</label>
                            <div>
                                @if($examSession->status == 'created')
                                    <span class="badge bg-secondary">Created</span>
                                @elseif($examSession->status == 'in_progress')
                                    <span class="badge bg-warning">In Progress</span>
                                @elseif($examSession->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($examSession->status == 'abandoned')
                                    <span class="badge bg-danger">Abandoned</span>
                                @else
                                    <span class="badge bg-dark">{{ ucfirst($examSession->status) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Attempt Number</label>
                            <div><strong>#{{ $examSession->attempt_number }}</strong></div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Score</label>
                            <div>
                                @if($examSession->score_percentage !== null)
                                    <span class="badge {{ $examSession->passed ? 'bg-success' : 'bg-danger' }}">
                                        {{ number_format($examSession->score_percentage, 1) }}%
                                    </span>
                                @else
                                    <span class="text-muted">Not completed</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Started At</label>
                            <div>
                                @if($examSession->started_at)
                                    {{ $examSession->started_at->format('M d, Y H:i:s') }}
                                @else
                                    <span class="text-muted">Not started</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Completed At</label>
                            <div>
                                @if($examSession->completed_at)
                                    {{ $examSession->completed_at->format('M d, Y H:i:s') }}
                                @else
                                    <span class="text-muted">Not completed</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Duration</label>
                            <div>
                                @if($examSession->duration_minutes)
                                    <strong>{{ $examSession->duration_minutes }}</strong> minutes
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Result</label>
                            <div>
                                @if($examSession->passed !== null)
                                    @if($examSession->passed)
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Passed</span>
                                    @else
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Failed</span>
                                    @endif
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuration -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Configuration</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Time Limit</label>
                            <div>
                                @if($examSession->time_limit_minutes)
                                    <strong>{{ $examSession->time_limit_minutes }}</strong> minutes
                                @else
                                    <span class="text-muted">No limit</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Total Questions</label>
                            <div><strong>{{ $examSession->total_questions }}</strong></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Passing Score</label>
                            <div><strong>{{ $examSession->passing_score }}%</strong></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Adaptive Mode</label>
                            <div>
                                @if($examSession->adaptive_mode)
                                    <span class="badge bg-success">Enabled</span>
                                @else
                                    <span class="badge bg-secondary">Disabled</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Difficulty Level</label>
                            <div>
                                @if($examSession->difficulty_level)
                                    <span class="badge bg-info">{{ ucfirst($examSession->difficulty_level) }}</span>
                                @else
                                    <span class="text-muted">Standard</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Domain Performance (only if completed) -->
            @if($examSession->isCompleted() && count($domainScores) > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Domain Performance</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Domain</th>
                                        <th>Questions</th>
                                        <th>Correct</th>
                                        <th>Score</th>
                                        <th>Performance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($domainScores as $domainName => $scores)
                                        <tr>
                                            <td><strong>{{ $domainName }}</strong></td>
                                            <td>{{ $scores['total'] }}</td>
                                            <td>{{ $scores['correct'] }}</td>
                                            <td>
                                                <span class="badge {{ $scores['percentage'] >= 70 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ number_format($scores['percentage'], 1) }}%
                                                </span>
                                            </td>
                                            <td>
                                                @if($scores['percentage'] >= 80)
                                                    <span class="badge bg-success">Strong</span>
                                                @elseif($scores['percentage'] >= 70)
                                                    <span class="badge bg-info">Average</span>
                                                @else
                                                    <span class="badge bg-warning">Weak</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Weak Areas (for benchmark exams) -->
                @if($examSession->isBenchmark() && count($weakDomains) > 0)
                    <div class="card mb-4">
                        <div class="card-header bg-warning bg-opacity-10">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-exclamation-triangle text-warning me-2"></i>Weak Areas Identified
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">The following domains scored below 70% and require additional practice:</p>
                            <ul class="list-group">
                                @foreach($weakDomains as $domainName => $scores)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $domainName }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $scores['correct'] }}/{{ $scores['total'] }} correct</small>
                                            </div>
                                            <span class="badge bg-warning">{{ number_format($scores['percentage'], 1) }}%</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="alert alert-info mt-3 mb-0">
                                <i class="bi bi-lightbulb me-2"></i>
                                <strong>Recommendation:</strong> Create practice sessions focusing on these domains to improve performance.
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Correct Answers</span>
                            <strong>{{ $examSession->correct_answers ?? 0 }}/{{ $examSession->total_questions }}</strong>
                        </div>
                        @if($examSession->score_percentage !== null)
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar {{ $examSession->passed ? 'bg-success' : 'bg-danger' }}" 
                                     style="width: {{ $examSession->score_percentage }}%"></div>
                            </div>
                        @endif
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Created</span>
                        <span>{{ $examSession->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Last Updated</span>
                        <span>{{ $examSession->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($examSession->status == 'created')
                            <a href="{{ route('admin.exam-sessions.edit', $examSession) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>Edit Session
                            </a>
                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bi bi-trash me-2"></i>Delete Session
                            </button>
                        @endif
                        <a href="{{ route('admin.exam-sessions.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Are you sure you want to delete this exam session?</p>
                <div class="card bg-light">
                    <div class="card-body">
                        <p class="mb-2"><strong>Learner:</strong> {{ $examSession->learner->name }}</p>
                        <p class="mb-2"><strong>Certification:</strong> {{ $examSession->certification->name }}</p>
                        <p class="mb-2"><strong>Exam Type:</strong> 
                            <span class="badge 
                                @if($examSession->exam_type == 'benchmark') bg-info
                                @elseif($examSession->exam_type == 'practice') bg-warning
                                @else bg-primary
                                @endif">
                                {{ ucfirst($examSession->exam_type) }}
                            </span>
                        </p>
                        <p class="mb-2"><strong>Status:</strong> 
                            <span class="badge 
                                @if($examSession->status == 'created') bg-secondary
                                @elseif($examSession->status == 'in_progress') bg-warning
                                @elseif($examSession->status == 'completed') bg-success
                                @else bg-danger
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $examSession->status)) }}
                            </span>
                        </p>
                        <p class="mb-0"><strong>Created:</strong> {{ $examSession->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
                <div class="alert alert-warning mt-3 mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone. All session data will be permanently deleted.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </button>
                <form action="{{ route('admin.exam-sessions.destroy', $examSession) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Delete Session
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

