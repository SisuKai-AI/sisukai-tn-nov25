@extends('layouts.learner')

@section('title', 'My Exam Sessions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">My Exam Sessions</h1>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Sessions</p>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                        <div class="text-primary">
                            <i class="bi bi-clipboard-check fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">In Progress</p>
                            <h3 class="mb-0">{{ $stats['in_progress'] }}</h3>
                        </div>
                        <div class="text-warning">
                            <i class="bi bi-hourglass-split fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Completed</p>
                            <h3 class="mb-0">{{ $stats['completed'] }}</h3>
                        </div>
                        <div class="text-success">
                            <i class="bi bi-check-circle fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Average Score</p>
                            <h3 class="mb-0">{{ number_format($stats['average_score'], 1) }}%</h3>
                        </div>
                        <div class="text-info">
                            <i class="bi bi-graph-up fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('learner.exams.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="exam_type" class="form-label small">Exam Type</label>
                    <select name="exam_type" id="exam_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="benchmark" {{ request('exam_type') === 'benchmark' ? 'selected' : '' }}>Benchmark</option>
                        <option value="practice" {{ request('exam_type') === 'practice' ? 'selected' : '' }}>Practice</option>
                        <option value="final" {{ request('exam_type') === 'final' ? 'selected' : '' }}>Final</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="certification_id" class="form-label small">Certification</label>
                    <select name="certification_id" id="certification_id" class="form-select">
                        <option value="">All Certifications</option>
                        @foreach($certifications as $cert)
                            <option value="{{ $cert->id }}" {{ request('certification_id') === $cert->id ? 'selected' : '' }}>
                                {{ $cert->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label small">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="created" {{ request('status') === 'created' ? 'selected' : '' }}>Created</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('learner.exams.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Exam Sessions List --}}
    @if($examSessions->count() > 0)
        <div class="row">
            @foreach($examSessions as $session)
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title mb-1">{{ $session->certification->name }}</h5>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-calendar3"></i> {{ $session->created_at->format('M d, Y H:i') }}
                                    </p>
                                </div>
                                <div class="d-flex gap-2">
                                    @if($session->exam_type === 'benchmark')
                                        <span class="badge bg-info">Benchmark</span>
                                    @elseif($session->exam_type === 'practice')
                                        <span class="badge bg-warning text-dark">Practice</span>
                                    @else
                                        <span class="badge bg-primary">Final</span>
                                    @endif
                                    
                                    @if($session->status === 'created')
                                        <span class="badge bg-secondary">Created</span>
                                    @elseif($session->status === 'in_progress')
                                        <span class="badge bg-warning text-dark">In Progress</span>
                                    @elseif($session->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Time Limit</small>
                                    <strong>{{ $session->time_limit_minutes }} minutes</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Questions</small>
                                    <strong>{{ $session->total_questions }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Passing Score</small>
                                    <strong>{{ $session->passing_score }}%</strong>
                                </div>
                                @if($session->status === 'completed')
                                    <div class="col-6">
                                        <small class="text-muted d-block">Your Score</small>
                                        <strong class="{{ $session->passed ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($session->score_percentage, 1) }}%
                                            @if($session->passed)
                                                <i class="bi bi-check-circle"></i>
                                            @else
                                                <i class="bi bi-x-circle"></i>
                                            @endif
                                        </strong>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex gap-2">
                                @if($session->status === 'created')
                                    <a href="{{ route('learner.exams.show', $session->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> View Details
                                    </a>
                                    <form action="{{ route('learner.exams.start', $session->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-play-fill"></i> Start Exam
                                        </button>
                                    </form>
                                @elseif($session->status === 'in_progress')
                                    <a href="{{ route('learner.exams.take', $session->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-arrow-right-circle"></i> Resume Exam
                                    </a>
                                @else
                                    <a href="{{ route('learner.exams.results', $session->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-bar-chart"></i> View Results
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $examSessions->links() }}
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                <h5 class="text-muted">No Exam Sessions Found</h5>
                <p class="text-muted mb-0">
                    @if(request()->hasAny(['exam_type', 'certification_id', 'status']))
                        No exam sessions match your filter criteria.
                    @else
                        You don't have any exam sessions yet. Contact your administrator to schedule an exam.
                    @endif
                </p>
            </div>
        </div>
    @endif
</div>
@endsection

