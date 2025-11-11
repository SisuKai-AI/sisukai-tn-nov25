@extends('layouts.learner')

@section('title', 'Benchmark Exam - ' . $certification->name)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('learner.certifications.index') }}">Certifications</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('learner.certifications.show', $certification->id) }}">{{ $certification->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Benchmark Exam</li>
                    </ol>
                </nav>
                
                <h1 class="display-5 fw-bold mb-2">Benchmark Exam</h1>
                <p class="text-muted lead">{{ $certification->name }}</p>
            </div>

            <!-- Main Content Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-5">
                    <!-- What is a Benchmark Exam? -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-speedometer2 text-primary" viewBox="0 0 16 16">
                                    <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4M3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                                    <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A8 8 0 0 1 0 10m8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3"/>
                                </svg>
                            </div>
                            <h2 class="h3 mb-0">What is a Benchmark Exam?</h2>
                        </div>
                        <p class="text-muted mb-0">A benchmark exam is a <strong>diagnostic assessment</strong> that evaluates your current knowledge across all domains of the {{ $certification->name }} certification. Think of it as a comprehensive baseline test that helps us understand where you stand today.</p>
                    </div>

                    <!-- Why Take a Benchmark? -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-lightbulb text-success" viewBox="0 0 16 16">
                                    <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13a.5.5 0 0 1 0 1 .5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1 0-1 .5.5 0 0 1 0-1 .5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m6-5a5 5 0 0 0-3.479 8.592c.263.254.514.564.676.941L5.83 12h4.342l.632-1.467c.162-.377.413-.687.676-.941A5 5 0 0 0 8 1"/>
                                </svg>
                            </div>
                            <h2 class="h3 mb-0">Why Take a Benchmark?</h2>
                        </div>
                        <p class="text-muted mb-3">The benchmark exam is the foundation of your personalized learning journey. By taking this assessment first, we can:</p>
                        <ul class="text-muted">
                            <li class="mb-2"><strong>Identify your strengths:</strong> Discover which domains you already excel in</li>
                            <li class="mb-2"><strong>Pinpoint knowledge gaps:</strong> Find areas that need focused improvement</li>
                            <li class="mb-2"><strong>Create a custom learning path:</strong> Get personalized practice recommendations based on your results</li>
                            <li class="mb-2"><strong>Track your progress:</strong> Establish a baseline to measure improvement over time</li>
                            <li class="mb-2"><strong>Optimize your study time:</strong> Focus on what matters most for your success</li>
                        </ul>
                    </div>

                    <!-- What to Expect -->
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-clipboard-check text-info" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                    <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                                    <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                                </svg>
                            </div>
                            <h2 class="h3 mb-0">What to Expect</h2>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h5 class="text-primary mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-question-circle me-2" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                            <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94"/>
                                        </svg>
                                        Questions
                                    </h5>
                                    <p class="text-muted mb-0 small">{{ $certification->exam_questions ?? 45 }} multiple-choice questions covering all certification domains</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h5 class="text-primary mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clock me-2" viewBox="0 0 16 16">
                                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                                        </svg>
                                        Time Limit
                                    </h5>
                                    <p class="text-muted mb-0 small">{{ $certification->exam_duration ?? 90 }} minutes to complete the assessment</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h5 class="text-primary mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-repeat me-2" viewBox="0 0 16 16">
                                            <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                                            <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
                                        </svg>
                                        Resume Capability
                                    </h5>
                                    <p class="text-muted mb-0 small">You can pause and resume the exam if needed</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h5 class="text-primary mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-graph-up me-2" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07"/>
                                        </svg>
                                        Detailed Results
                                    </h5>
                                    <p class="text-muted mb-0 small">Comprehensive performance breakdown by domain with personalized recommendations</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Important Notes -->
                    <div class="alert alert-warning border-warning mb-4" role="alert">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                </svg>
                            </div>
                            <div>
                                <h5 class="alert-heading mb-2">Important Notes</h5>
                                <ul class="mb-0 ps-3">
                                    <li>This is a <strong>diagnostic assessment</strong>, not a pass/fail test</li>
                                    <li>Your results will be used to create a personalized learning plan</li>
                                    <li>Answer honestly to get the most accurate recommendations</li>
                                    <li>You can flag questions for review before submitting</li>
                                    <li>Once submitted, you cannot change your answers</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    @if($existingBenchmark && $existingBenchmark->status === 'in_progress')
                        <!-- Resume Benchmark -->
                        <div class="alert alert-info border-info mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle-fill me-3" viewBox="0 0 16 16">
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                                </svg>
                                <div>
                                    <strong>You have an in-progress benchmark exam.</strong> Click the button below to resume where you left off.
                                </div>
                            </div>
                        </div>
                    @elseif($existingBenchmark && $existingBenchmark->status === 'completed')
                        <!-- Retake Benchmark -->
                        <div class="alert alert-success border-success mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill me-3" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                                <div>
                                    <strong>You've already completed a benchmark exam.</strong> Your previous score: <strong>{{ number_format($existingBenchmark->score_percentage, 1) }}%</strong>. You can retake it to update your baseline assessment.
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 justify-content-between align-items-center">
                        <a href="{{ route('learner.certifications.show', $certification->id) }}" class="btn btn-outline-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                            </svg>
                            Back to Certification
                        </a>
                        
                        @if($existingBenchmark && $existingBenchmark->status === 'in_progress')
                            <a href="{{ route('learner.benchmark.start', $certification->id) }}" class="btn btn-primary btn-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-play-fill me-2" viewBox="0 0 16 16">
                                    <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                                </svg>
                                Resume Benchmark Exam
                            </a>
                        @else
                            <form action="{{ route('learner.benchmark.create', $certification->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-play-fill me-2" viewBox="0 0 16 16">
                                        <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                                    </svg>
                                    @if($existingBenchmark && $existingBenchmark->status === 'completed')
                                        Retake Benchmark Exam
                                    @else
                                        Start Benchmark Exam
                                    @endif
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary bg-opacity-10 border-primary">
                    <h5 class="mb-0 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill me-2" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                        Tips for Success
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li class="mb-2">Find a quiet environment with minimal distractions</li>
                        <li class="mb-2">Ensure you have a stable internet connection</li>
                        <li class="mb-2">Read each question carefully before selecting your answer</li>
                        <li class="mb-2">Use the flag feature to mark questions you want to review</li>
                        <li class="mb-2">Don't spend too much time on any single question</li>
                        <li class="mb-2">Review all flagged questions before submitting</li>
                        <li>Trust your first instinct if you're unsure</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

