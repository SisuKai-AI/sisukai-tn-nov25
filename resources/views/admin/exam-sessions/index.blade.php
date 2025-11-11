@extends('layouts.admin')

@section('title', 'Exam Session Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Exam Session Management</h1>
            <p class="text-muted">Monitor and manage all exam sessions across the platform</p>
        </div>
        <a href="{{ route('admin.exam-sessions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Create Exam Session
        </a>
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

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-clipboard-check text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Sessions</h6>
                            <h3 class="mb-0">{{ $totalSessions }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-hourglass-split text-warning" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Active Sessions</h6>
                            <h3 class="mb-0">{{ $activeSessions }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Completed</h6>
                            <h3 class="mb-0">{{ $completedSessions }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-graph-up text-info" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Average Score</h6>
                            <h3 class="mb-0">{{ number_format($averageScore, 1) }}%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.exam-sessions.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Exam Type</label>
                        <select name="exam_type" class="form-select">
                            <option value="all" {{ request('exam_type') == 'all' ? 'selected' : '' }}>All Types</option>
                            <option value="benchmark" {{ request('exam_type') == 'benchmark' ? 'selected' : '' }}>Benchmark</option>
                            <option value="practice" {{ request('exam_type') == 'practice' ? 'selected' : '' }}>Practice</option>
                            <option value="final" {{ request('exam_type') == 'final' ? 'selected' : '' }}>Final</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Certification</label>
                        <select name="certification_id" class="form-select">
                            <option value="">All Certifications</option>
                            @foreach($certifications as $cert)
                                <option value="{{ $cert->id }}" {{ request('certification_id') == $cert->id ? 'selected' : '' }}>
                                    {{ $cert->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                            <option value="created" {{ request('status') == 'created' ? 'selected' : '' }}>Created</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="abandoned" {{ request('status') == 'abandoned' ? 'selected' : '' }}>Abandoned</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Search Learner</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Name or email..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                            @if(request()->hasAny(['exam_type', 'certification_id', 'status', 'search']))
                                <a href="{{ route('admin.exam-sessions.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Exam Sessions Table -->
    <div class="card">
        <div class="card-body">
            @if($examSessions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Learner</th>
                                <th>Certification</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Score</th>
                                <th>Started</th>
                                <th>Duration</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($examSessions as $session)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $session->learner->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $session->learner->email }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $session->certification->name }}</td>
                                    <td>
                                        @if($session->exam_type == 'benchmark')
                                            <span class="badge bg-info">Benchmark</span>
                                        @elseif($session->exam_type == 'practice')
                                            <span class="badge bg-warning">Practice</span>
                                        @else
                                            <span class="badge bg-primary">Final</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($session->status == 'created')
                                            <span class="badge bg-secondary">Created</span>
                                        @elseif($session->status == 'in_progress')
                                            <span class="badge bg-warning">In Progress</span>
                                        @elseif($session->status == 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($session->status == 'abandoned')
                                            <span class="badge bg-danger">Abandoned</span>
                                        @else
                                            <span class="badge bg-dark">{{ ucfirst($session->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($session->score_percentage !== null)
                                            <span class="badge {{ $session->passed ? 'bg-success' : 'bg-danger' }}">
                                                {{ number_format($session->score_percentage, 1) }}%
                                            </span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($session->started_at)
                                            {{ $session->started_at->format('M d, Y H:i') }}
                                        @else
                                            <span class="text-muted">Not started</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($session->duration_minutes)
                                            {{ $session->duration_minutes }} min
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm gap-1">
                                            <a href="{{ route('admin.exam-sessions.show', $session) }}" class="btn btn-outline-primary" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($session->status == 'created')
                                                <a href="{{ route('admin.exam-sessions.edit', $session) }}" class="btn btn-outline-secondary" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $session->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $examSessions->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-clipboard-x text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">No exam sessions found.</p>
                    <a href="{{ route('admin.exam-sessions.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Create First Exam Session
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modals -->
@foreach($examSessions as $session)
    @if($session->status == 'created')
        <div class="modal fade" id="deleteModal{{ $session->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $session->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel{{ $session->id }}">
                            <i class="bi bi-exclamation-triangle me-2"></i>Confirm Deletion
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">Are you sure you want to delete this exam session?</p>
                        <div class="card bg-light">
                            <div class="card-body">
                                <p class="mb-2"><strong>Learner:</strong> {{ $session->learner->name }}</p>
                                <p class="mb-2"><strong>Certification:</strong> {{ $session->certification->name }}</p>
                                <p class="mb-2"><strong>Exam Type:</strong> 
                                    <span class="badge 
                                        @if($session->exam_type == 'benchmark') bg-info
                                        @elseif($session->exam_type == 'practice') bg-warning
                                        @else bg-primary
                                        @endif">
                                        {{ ucfirst($session->exam_type) }}
                                    </span>
                                </p>
                                <p class="mb-0"><strong>Created:</strong> {{ $session->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="alert alert-warning mt-3 mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Warning:</strong> This action cannot be undone.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <form action="{{ route('admin.exam-sessions.destroy', $session) }}" method="POST" class="d-inline">
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
    @endif
@endforeach
@endsection

