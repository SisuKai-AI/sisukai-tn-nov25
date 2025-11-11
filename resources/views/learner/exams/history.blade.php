@extends('layouts.learner')

@section('title', 'Exam History')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Exam History</h1>
        <a href="{{ route('learner.exams.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Exams
        </a>
    </div>

    {{-- Overall Statistics --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-text text-primary fs-1 d-block mb-2"></i>
                    <h3 class="mb-0">{{ $completedExams->count() }}</h3>
                    <small class="text-muted">Total Exams</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle text-success fs-1 d-block mb-2"></i>
                    <h3 class="mb-0">{{ $passedExams }}</h3>
                    <small class="text-muted">Passed</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-bar-chart text-info fs-1 d-block mb-2"></i>
                    <h3 class="mb-0">{{ number_format($averageScore, 1) }}%</h3>
                    <small class="text-muted">Average Score</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-trophy text-warning fs-1 d-block mb-2"></i>
                    <h3 class="mb-0">{{ $bestScore > 0 ? number_format($bestScore, 1) . '%' : 'N/A' }}</h3>
                    <small class="text-muted">Best Score</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Options --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('learner.exams.history') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Certification</label>
                    <select name="certification" class="form-select">
                        <option value="">All Certifications</option>
                        @foreach($certifications as $cert)
                            <option value="{{ $cert->id }}" {{ request('certification') == $cert->id ? 'selected' : '' }}>
                                {{ $cert->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Exam Type</label>
                    <select name="exam_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="benchmark" {{ request('exam_type') == 'benchmark' ? 'selected' : '' }}>Benchmark</option>
                        <option value="practice" {{ request('exam_type') == 'practice' ? 'selected' : '' }}>Practice</option>
                        <option value="final" {{ request('exam_type') == 'final' ? 'selected' : '' }}>Final</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Result</label>
                    <select name="result" class="form-select">
                        <option value="">All Results</option>
                        <option value="passed" {{ request('result') == 'passed' ? 'selected' : '' }}>Passed</option>
                        <option value="failed" {{ request('result') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Exam History Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">Completed Exams</h5>
        </div>
        <div class="card-body">
            @if($completedExams->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Certification</th>
                                <th>Type</th>
                                <th>Score</th>
                                <th>Result</th>
                                <th>Duration</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($completedExams as $exam)
                                <tr>
                                    <td>
                                        <small>{{ $exam->completed_at->format('M d, Y') }}</small><br>
                                        <small class="text-muted">{{ $exam->completed_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $exam->certification->name }}</strong><br>
                                        <small class="text-muted">{{ $exam->certification->code }}</small>
                                    </td>
                                    <td>
                                        @if($exam->exam_type === 'benchmark')
                                            <span class="badge bg-info">Benchmark</span>
                                        @elseif($exam->exam_type === 'practice')
                                            <span class="badge bg-warning text-dark">Practice</span>
                                        @else
                                            <span class="badge bg-primary">Final</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong class="{{ $exam->passed ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($exam->score_percentage, 1) }}%
                                        </strong><br>
                                        <small class="text-muted">{{ $exam->correct_answers }}/{{ $exam->total_questions }}</small>
                                    </td>
                                    <td>
                                        @if($exam->passed)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Passed
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle"></i> Failed
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $exam->duration_minutes }} min</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('learner.exams.results', $exam->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $completedExams->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">No completed exams found.</p>
                    <a href="{{ route('learner.exams.index') }}" class="btn btn-primary">
                        <i class="bi bi-play-circle"></i> Start Your First Exam
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Performance Trends (if we have data) --}}
    @if($completedExams->count() >= 3)
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">Performance Trends</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    Performance trend charts will be available in a future update.
                </div>
                
                {{-- Recent Performance --}}
                <h6 class="mb-3">Recent Performance (Last 5 Exams)</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Exam</th>
                                <th>Score</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($completedExams->take(5) as $index => $exam)
                                <tr>
                                    <td>{{ $exam->certification->name }} ({{ ucfirst($exam->exam_type) }})</td>
                                    <td>
                                        <strong class="{{ $exam->passed ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($exam->score_percentage, 1) }}%
                                        </strong>
                                    </td>
                                    <td>
                                        @if($index < $completedExams->count() - 1)
                                            @php
                                                $prevExam = $completedExams[$index + 1];
                                                $diff = $exam->score_percentage - $prevExam->score_percentage;
                                            @endphp
                                            @if($diff > 0)
                                                <span class="text-success">
                                                    <i class="bi bi-arrow-up"></i> +{{ number_format($diff, 1) }}%
                                                </span>
                                            @elseif($diff < 0)
                                                <span class="text-danger">
                                                    <i class="bi bi-arrow-down"></i> {{ number_format($diff, 1) }}%
                                                </span>
                                            @else
                                                <span class="text-muted">
                                                    <i class="bi bi-dash"></i> No change
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

