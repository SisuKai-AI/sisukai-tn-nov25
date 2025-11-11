@extends('layouts.learner')

@section('title', 'Welcome to ' . $certification->name)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Welcome Header -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-rocket-takeoff" style="font-size: 4rem;"></i>
                    </div>
                    <h1 class="text-white mb-3">Welcome to {{ $certification->name }}!</h1>
                    <p class="lead text-white mb-0">You're now enrolled and ready to start your certification journey</p>
                </div>
            </div>
        </div>
    </div>
    
    @if($quizAttempt)
    <!-- Quiz Results Summary -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-trophy me-2"></i>Your Quiz Results</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="border rounded p-3 mb-3 mb-md-0">
                                <h2 class="mb-0 
                                    @if(($quizAttempt->score / $quizAttempt->total_questions) * 100 >= 80) text-success
                                    @elseif(($quizAttempt->score / $quizAttempt->total_questions) * 100 >= 60) text-primary
                                    @elseif(($quizAttempt->score / $quizAttempt->total_questions) * 100 >= 40) text-warning
                                    @else text-danger
                                    @endif">
                                    {{ $quizAttempt->score }}/{{ $quizAttempt->total_questions }}
                                </h2>
                                <small class="text-muted">Quiz Score</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3 mb-3 mb-md-0">
                                <h2 class="mb-0">{{ round(($quizAttempt->score / $quizAttempt->total_questions) * 100) }}%</h2>
                                <small class="text-muted">Percentage</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <p class="mb-0">
                                    @if(($quizAttempt->score / $quizAttempt->total_questions) * 100 >= 80)
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        Excellent! You're well-prepared. Let's take a benchmark exam to get your detailed readiness report.
                                    @elseif(($quizAttempt->score / $quizAttempt->total_questions) * 100 >= 60)
                                        <i class="bi bi-check-circle text-primary me-2"></i>
                                        Good start! The benchmark exam will help identify your strengths and areas for improvement.
                                    @elseif(($quizAttempt->score / $quizAttempt->total_questions) * 100 >= 40)
                                        <i class="bi bi-info-circle text-warning me-2"></i>
                                        You're on the right track. The benchmark exam will create a personalized study plan for you.
                                    @else
                                        <i class="bi bi-exclamation-circle text-danger me-2"></i>
                                        Don't worry! The benchmark exam will help us understand where to focus your study efforts.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Next Steps -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Your Next Steps</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <strong>1</strong>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Take Benchmark Exam</h6>
                                    <p class="text-muted small mb-0">Get a comprehensive assessment of your current knowledge level</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <strong>2</strong>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Review Your Report</h6>
                                    <p class="text-muted small mb-0">Understand your strengths and areas needing improvement</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <strong>3</strong>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Start Practicing</h6>
                                    <p class="text-muted small mb-0">Use adaptive practice sessions to improve your weak areas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Certification Details -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>About This Certification</h5>
                </div>
                <div class="card-body">
                    <h6 class="mb-3">{{ $certification->name }}</h6>
                    <p class="text-muted mb-3">{{ $certification->description }}</p>
                    
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-building text-primary me-2"></i>
                                <div>
                                    <small class="text-muted d-block">Provider</small>
                                    <strong>{{ $certification->provider }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-question-circle text-primary me-2"></i>
                                <div>
                                    <small class="text-muted d-block">Questions</small>
                                    <strong>{{ $certification->exam_question_count ?? 0 }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-clock text-primary me-2"></i>
                                <div>
                                    <small class="text-muted d-block">Duration</small>
                                    <strong>{{ $certification->exam_duration_minutes ?? 'N/A' }} minutes</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-trophy text-primary me-2"></i>
                                <div>
                                    <small class="text-muted d-block">Passing Score</small>
                                    <strong>{{ $certification->passing_score ?? 70 }}%</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card bg-light h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <i class="bi bi-speedometer2 text-primary mb-3" style="font-size: 3rem;"></i>
                    <h5 class="mb-3">Ready to Get Started?</h5>
                    <p class="text-muted mb-4">Take your benchmark exam to get a personalized study plan and start your path to certification success.</p>
                    <a href="{{ route('learner.benchmark.start', $certification->id) }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-play-circle me-2"></i>Start Benchmark Exam
                    </a>
                    <a href="{{ route('learner.dashboard') }}" class="btn btn-link mt-2">
                        Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- What to Expect -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-lightbulb me-2"></i>What to Expect from Your Benchmark Exam</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="text-center">
                                <i class="bi bi-clock-history text-primary mb-2" style="font-size: 2rem;"></i>
                                <h6>Timed Assessment</h6>
                                <p class="text-muted small mb-0">Complete the exam within the allocated time to simulate real exam conditions</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="text-center">
                                <i class="bi bi-bar-chart text-primary mb-2" style="font-size: 2rem;"></i>
                                <h6>Detailed Analytics</h6>
                                <p class="text-muted small mb-0">Get insights into your performance across all exam domains and topics</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="text-center">
                                <i class="bi bi-graph-up text-primary mb-2" style="font-size: 2rem;"></i>
                                <h6>Readiness Score</h6>
                                <p class="text-muted small mb-0">See your overall readiness percentage and predicted exam performance</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <i class="bi bi-map text-primary mb-2" style="font-size: 2rem;"></i>
                                <h6>Study Plan</h6>
                                <p class="text-muted small mb-0">Receive a personalized study plan based on your weak areas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
