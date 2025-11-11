@extends('layouts.learner')

@section('title', 'Practice Results - ' . $session->certification->name)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Results Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center py-5">
                    @if($session->score_percentage >= 80)
                        <div class="mb-3">
                            <i class="bi bi-trophy-fill text-warning" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="fw-bold text-success mb-2">Excellent Work!</h2>
                        <p class="text-muted">You're mastering this material!</p>
                    @elseif($session->score_percentage >= 60)
                        <div class="mb-3">
                            <i class="bi bi-emoji-smile-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="fw-bold text-primary mb-2">Good Progress!</h2>
                        <p class="text-muted">Keep practicing to improve further!</p>
                    @else
                        <div class="mb-3">
                            <i class="bi bi-book-fill text-info" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="fw-bold text-info mb-2">Keep Learning!</h2>
                        <p class="text-muted">Practice makes perfect!</p>
                    @endif

                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded">
                                <h3 class="fw-bold text-primary mb-0">{{ $session->score_percentage }}%</h3>
                                <small class="text-muted">Your Score</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded">
                                <h3 class="fw-bold text-success mb-0">{{ $correctCount }}</h3>
                                <small class="text-muted">Correct</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded">
                                <h3 class="fw-bold text-danger mb-0">{{ $incorrectCount }}</h3>
                                <small class="text-muted">Incorrect</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded">
                                <h3 class="fw-bold text-info mb-0">{{ $session->total_questions }}</h3>
                                <small class="text-muted">Total Questions</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance by Domain -->
            @if($domainPerformance->isNotEmpty())
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Performance by Domain</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <canvas id="domainPerformanceChart" height="300"></canvas>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-bold mb-3">Domain Breakdown</h6>
                            @foreach($domainPerformance as $domain)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="small">{{ $domain->name }}</span>
                                    <span class="small fw-bold">{{ round($domain->percentage, 1) }}%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar 
                                        @if($domain->percentage >= 80) bg-success
                                        @elseif($domain->percentage >= 60) bg-info
                                        @else bg-danger
                                        @endif" 
                                        role="progressbar" 
                                        style="width: {{ $domain->percentage }}%">
                                    </div>
                                </div>
                                <small class="text-muted">{{ $domain->correct }} / {{ $domain->total }} correct</small>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Areas to Improve -->
            @if($weakDomains->isNotEmpty())
            <div class="alert alert-warning mb-4">
                <h6 class="alert-heading fw-bold">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Areas to Improve
                </h6>
                <p class="mb-2">Focus on these domains in your next practice session:</p>
                <ul class="mb-0">
                    @foreach($weakDomains as $domain)
                    <li><strong>{{ $domain->name }}</strong> ({{ round($domain->percentage, 1) }}%)</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Question Review -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Question Review</h5>
                </div>
                <div class="card-body">
                    @foreach($session->questions as $index => $question)
                    @php
                        $practiceAnswer = $session->practiceAnswers->where('question_id', $question->id)->first();
                        $isCorrect = $practiceAnswer ? $practiceAnswer->is_correct : false;
                        $selectedAnswer = $practiceAnswer ? $question->answers->where('id', $practiceAnswer->selected_answer_id)->first() : null;
                        $correctAnswer = $question->answers->where('is_correct', true)->first();
                    @endphp
                    
                    <div class="mb-4 pb-4 border-bottom">
                        <div class="d-flex align-items-start mb-3">
                            <span class="badge {{ $isCorrect ? 'bg-success' : 'bg-danger' }} me-3" style="font-size: 1rem;">
                                {{ $index + 1 }}
                            </span>
                            <div class="flex-grow-1">
                                <h6 class="mb-2">{{ $question->question_text }}</h6>
                                <span class="badge bg-secondary">{{ $question->topic->domain->name }}</span>
                                <span class="badge bg-info">{{ $question->topic->name }}</span>
                            </div>
                        </div>

                        <div class="ms-5">
                            @foreach($question->answers as $answer)
                            <div class="p-2 mb-2 rounded border
                                @if($answer->is_correct) border-success bg-success bg-opacity-10
                                @elseif($selectedAnswer && $answer->id === $selectedAnswer->id && !$answer->is_correct) border-danger bg-danger bg-opacity-10
                                @endif">
                                <div class="d-flex align-items-center">
                                    @if($answer->is_correct)
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    @elseif($selectedAnswer && $answer->id === $selectedAnswer->id)
                                        <i class="bi bi-x-circle-fill text-danger me-2"></i>
                                    @else
                                        <i class="bi bi-circle text-muted me-2"></i>
                                    @endif
                                    <span>{{ $answer->answer_text }}</span>
                                </div>
                            </div>
                            @endforeach

                            @if($question->explanation)
                            <div class="alert alert-info mt-3 mb-0">
                                <strong>Explanation:</strong> {{ $question->explanation }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mb-4">
                <a href="{{ route('learner.practice.recommendations', $session->certification_id) }}" class="btn btn-primary btn-lg me-2">
                    <i class="bi bi-arrow-repeat me-2"></i>Practice Again
                </a>
                <a href="{{ route('learner.practice.history') }}" class="btn btn-outline-secondary btn-lg me-2">
                    <i class="bi bi-clock-history me-2"></i>View History
                </a>
                <a href="{{ route('learner.certifications.show', $session->certification_id) }}" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>Back to Certification
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('node_modules/chart.js/dist/chart.umd.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($domainPerformance->isNotEmpty())
    // Domain Performance Chart
    const ctx = document.getElementById('domainPerformanceChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($domainPerformance->pluck('name')) !!},
                datasets: [{
                    label: 'Score (%)',
                    data: {!! json_encode($domainPerformance->pluck('percentage')) !!},
                    backgroundColor: function(context) {
                        const value = context.parsed.y;
                        if (value >= 80) return 'rgba(25, 135, 84, 0.8)';
                        if (value >= 60) return 'rgba(13, 202, 240, 0.8)';
                        return 'rgba(220, 53, 69, 0.8)';
                    },
                    borderColor: function(context) {
                        const value = context.parsed.y;
                        if (value >= 80) return 'rgb(25, 135, 84)';
                        if (value >= 60) return 'rgb(13, 202, 240)';
                        return 'rgb(220, 53, 69)';
                    },
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Score: ' + context.parsed.y.toFixed(1) + '%';
                            }
                        }
                    }
                }
            }
        });
    }
    @endif
});
</script>
@endpush
@endsection
