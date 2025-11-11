@extends('layouts.learner')

@section('title', 'Exam Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Exam Details</h1>
        <a href="{{ route('learner.exams.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            {{-- Exam Overview --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Exam Overview</h5>
                </div>
                <div class="card-body">
                    <h4 class="mb-3">{{ $examSession->certification->name }}</h4>
                    
                    <div class="d-flex gap-2 mb-4">
                        @if($examSession->exam_type === 'benchmark')
                            <span class="badge bg-info">Benchmark Exam</span>
                        @elseif($examSession->exam_type === 'practice')
                            <span class="badge bg-warning text-dark">Practice Exam</span>
                        @else
                            <span class="badge bg-primary">Final Exam</span>
                        @endif
                        
                        @if($examSession->status === 'created')
                            <span class="badge bg-secondary">Not Started</span>
                        @elseif($examSession->status === 'in_progress')
                            <span class="badge bg-warning text-dark">In Progress</span>
                        @else
                            <span class="badge bg-success">Completed</span>
                        @endif
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="border rounded p-3 text-center">
                                <i class="bi bi-clock text-primary fs-3 d-block mb-2"></i>
                                <small class="text-muted d-block">Time Limit</small>
                                <strong>{{ $examSession->time_limit_minutes }} minutes</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3 text-center">
                                <i class="bi bi-question-circle text-info fs-3 d-block mb-2"></i>
                                <small class="text-muted d-block">Total Questions</small>
                                <strong>{{ $examSession->total_questions }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3 text-center">
                                <i class="bi bi-trophy text-warning fs-3 d-block mb-2"></i>
                                <small class="text-muted d-block">Passing Score</small>
                                <strong>{{ $examSession->passing_score }}%</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Exam Instructions --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Exam Instructions</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li class="mb-2">You have <strong>{{ $examSession->time_limit_minutes }} minutes</strong> to complete this exam.</li>
                        <li class="mb-2">The exam contains <strong>{{ $examSession->total_questions }} questions</strong>.</li>
                        <li class="mb-2">You must score at least <strong>{{ $examSession->passing_score }}%</strong> to pass.</li>
                        <li class="mb-2">Once started, the timer will begin and cannot be paused.</li>
                        <li class="mb-2">You can navigate between questions and change your answers before submitting.</li>
                        <li class="mb-2">You can flag questions for review.</li>
                        <li class="mb-2">The exam will auto-submit when time expires.</li>
                        <li class="mb-0">Make sure you have a stable internet connection before starting.</li>
                    </ul>
                </div>
            </div>

            {{-- Requirements Checklist --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Before You Start</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="check1">
                        <label class="form-check-label" for="check1">
                            I have a stable internet connection
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="check2">
                        <label class="form-check-label" for="check2">
                            I am in a quiet environment with minimal distractions
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="check3">
                        <label class="form-check-label" for="check3">
                            I have {{ $examSession->time_limit_minutes }} minutes available to complete the exam
                        </label>
                    </div>

                    @if($examSession->status === 'created')
                        <form action="{{ route('learner.exams.start', $examSession->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg w-100" id="startExamBtn" disabled>
                                <i class="bi bi-play-fill"></i> Start Exam
                            </button>
                        </form>
                    @elseif($examSession->status === 'in_progress')
                        <a href="{{ route('learner.exams.take', $examSession->id) }}" class="btn btn-warning btn-lg w-100">
                            <i class="bi bi-arrow-right-circle"></i> Resume Exam
                        </a>
                    @else
                        <a href="{{ route('learner.exams.results', $examSession->id) }}" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-bar-chart"></i> View Results
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Exam Type Information --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">About This Exam Type</h5>
                </div>
                <div class="card-body">
                    @if($examSession->exam_type === 'benchmark')
                        <div class="alert alert-info mb-0">
                            <h6 class="alert-heading">Benchmark Exam</h6>
                            <p class="mb-0 small">
                                This exam assesses your baseline knowledge across all domains. 
                                Results will help identify areas where you need to focus your study efforts.
                            </p>
                        </div>
                    @elseif($examSession->exam_type === 'practice')
                        <div class="alert alert-warning mb-0">
                            <h6 class="alert-heading">Practice Exam</h6>
                            <p class="mb-0 small">
                                This exam helps you practice and improve on specific topics and domains. 
                                Use it to strengthen your weak areas identified in the benchmark exam.
                            </p>
                        </div>
                    @else
                        <div class="alert alert-primary mb-0">
                            <h6 class="alert-heading">Final Exam</h6>
                            <p class="mb-0 small">
                                This exam simulates the actual certification test conditions. 
                                Passing this exam demonstrates your readiness for the real certification.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Previous Attempts --}}
            @if($previousAttempts->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Previous Attempts</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Score</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($previousAttempts as $attempt)
                                        <tr>
                                            <td class="small">{{ $attempt->completed_at->format('M d, Y') }}</td>
                                            <td class="small">{{ number_format($attempt->score_percentage, 1) }}%</td>
                                            <td>
                                                @if($attempt->passed)
                                                    <span class="badge bg-success">Passed</span>
                                                @else
                                                    <span class="badge bg-danger">Failed</span>
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
    </div>
</div>

@push('scripts')
<script>
    // Enable start button only when all checkboxes are checked
    const checkboxes = document.querySelectorAll('.form-check-input');
    const startBtn = document.getElementById('startExamBtn');
    
    if (startBtn) {
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                startBtn.disabled = !allChecked;
            });
        });
    }
</script>
@endpush
@endsection

