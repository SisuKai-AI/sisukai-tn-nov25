@extends('layouts.learner')

@section('title', 'Exam Results')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Exam Results</h1>
        <a href="{{ route('learner.exams.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Exams
        </a>
    </div>

    {{-- Score Overview --}}
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-5">
                    @if($examSession->passed)
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        <h2 class="text-success mt-3 mb-2">Congratulations! You Passed!</h2>
                    @else
                        <i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i>
                        <h2 class="text-danger mt-3 mb-2">Not Quite There Yet</h2>
                    @endif
                    
                    <p class="text-muted mb-4">{{ $examSession->certification->name }}</p>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Your Score</small>
                                <h3 class="mb-0 {{ $examSession->passed ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($examSession->score_percentage, 1) }}%
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Passing Score</small>
                                <h3 class="mb-0">{{ $examSession->passing_score }}%</h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Correct Answers</small>
                                <h3 class="mb-0">{{ $examSession->correct_answers }}/{{ $examSession->total_questions }}</h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Time Taken</small>
                                <h3 class="mb-0">{{ $examSession->duration_minutes }} min</h3>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-center mb-3">
                        @if($examSession->exam_type === 'benchmark')
                            <span class="badge bg-info">Benchmark Exam</span>
                        @elseif($examSession->exam_type === 'practice')
                            <span class="badge bg-warning text-dark">Practice Exam</span>
                        @else
                            <span class="badge bg-primary">Final Exam</span>
                        @endif
                        <span class="badge bg-secondary">
                            <i class="bi bi-calendar3"></i> {{ $examSession->completed_at->format('M d, Y H:i') }}
                        </span>
                    </div>

                    @if($examSession->exam_type === 'benchmark')
                        <div class="mt-3">
                            <a href="{{ route('learner.benchmark.explain', $examSession->certification_id) }}" 
                               class="btn btn-primary">
                                <i class="bi bi-arrow-repeat"></i> Retake Benchmark Exam
                            </a>
                            <p class="text-muted small mt-2 mb-0">
                                Track your progress by retaking the benchmark assessment
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Performance Visualizations --}}
    <div class="row mb-4">
        {{-- Domain Performance Radar Chart --}}
        <div class="col-lg-8 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-radar"></i> Domain Performance</h5>
                </div>
                <div class="card-body">
                    @if(count($domainPerformance) > 0)
                        <canvas id="domainRadarChart" style="max-height: 400px;"></canvas>
                        
                        {{-- Progress bars below chart --}}
                        <div class="row g-2 mt-3">
                            @foreach($domainPerformance as $domain)
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="fw-bold">{{ $domain['domain']->name }}</small>
                                        <span class="badge {{ $domain['percentage'] >= 80 ? 'bg-success' : ($domain['percentage'] >= 60 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                            {{ number_format($domain['percentage'], 1) }}%
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar {{ $domain['percentage'] >= 80 ? 'bg-success' : ($domain['percentage'] >= 60 ? 'bg-warning' : 'bg-danger') }}" 
                                             style="width: {{ $domain['percentage'] }}%">
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $domain['correct'] }}/{{ $domain['total'] }} correct</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No domain performance data available.</p>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Score Distribution Doughnut Chart --}}
        <div class="col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Score Breakdown</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <canvas id="scoreDistributionChart" style="max-height: 300px;"></canvas>
                    
                    {{-- Legend --}}
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span class="badge bg-success me-2">●</span>
                                <small>Correct</small>
                            </div>
                            <strong>{{ $examSession->correct_answers }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span class="badge bg-danger me-2">●</span>
                                <small>Incorrect</small>
                            </div>
                            <strong>{{ $examSession->total_questions - $examSession->correct_answers - ($examSession->total_questions - $examSession->examAnswers->count()) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-secondary me-2">●</span>
                                <small>Unanswered</small>
                            </div>
                            <strong>{{ $examSession->total_questions - $examSession->examAnswers->count() }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Progress Trend Chart (only if multiple attempts exist) --}}
    @if($progressTrendData && $progressTrendData['attempt_count'] >= 2)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-graph-up-arrow"></i> Progress Over Time</h5>
                        <span class="badge bg-primary">{{ $progressTrendData['attempt_count'] }} Attempts</span>
                    </div>
                    <small class="text-muted">Track your improvement across multiple benchmark exams</small>
                </div>
                <div class="card-body">
                    <canvas id="progressTrendChart" style="max-height: 400px;"></canvas>
                    
                    {{-- Legend and insights --}}
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="alert alert-info mb-0">
                                <i class="bi bi-info-circle"></i>
                                <strong>Latest Score:</strong> {{ end($progressTrendData['overall_scores']) }}%
                                @if(count($progressTrendData['overall_scores']) >= 2)
                                    @php
                                        $improvement = end($progressTrendData['overall_scores']) - $progressTrendData['overall_scores'][0];
                                    @endphp
                                    <span class="{{ $improvement >= 0 ? 'text-success' : 'text-danger' }}">
                                        ({{ $improvement >= 0 ? '+' : '' }}{{ number_format($improvement, 1) }}% from first attempt)
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-{{ end($progressTrendData['overall_scores']) >= $progressTrendData['passing_score'] ? 'success' : 'warning' }} mb-0">
                                <i class="bi bi-{{ end($progressTrendData['overall_scores']) >= $progressTrendData['passing_score'] ? 'check-circle' : 'exclamation-triangle' }}"></i>
                                @if(end($progressTrendData['overall_scores']) >= $progressTrendData['passing_score'])
                                    <strong>You're ready!</strong> Your latest score exceeds the passing threshold.
                                @else
                                    <strong>Keep going!</strong> You need {{ number_format($progressTrendData['passing_score'] - end($progressTrendData['overall_scores']), 1) }}% more to pass.
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Weak and Strong Areas --}}
    <div class="row mb-4">
        @if($weakDomains->count() > 0)
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-danger text-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-exclamation-triangle"></i> Areas to Improve
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            @foreach($weakDomains as $domain)
                                <li class="mb-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $domain['domain']->name }}</strong>
                                            <p class="text-muted small mb-0">{{ $domain['correct'] }}/{{ $domain['total'] }} correct</p>
                                        </div>
                                        <span class="badge bg-danger">{{ number_format($domain['percentage'], 1) }}%</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="alert alert-warning mb-0 mt-3">
                            <small>
                                <i class="bi bi-lightbulb"></i> 
                                Focus your study efforts on these domains to improve your overall score.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($strongDomains->count() > 0)
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-trophy"></i> Strong Areas
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            @foreach($strongDomains as $domain)
                                <li class="mb-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $domain['domain']->name }}</strong>
                                            <p class="text-muted small mb-0">{{ $domain['correct'] }}/{{ $domain['total'] }} correct</p>
                                        </div>
                                        <span class="badge bg-success">{{ number_format($domain['percentage'], 1) }}%</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="alert alert-success mb-0 mt-3">
                            <small>
                                <i class="bi bi-check-circle"></i> 
                                Great job! You have a strong understanding of these domains.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Question Review --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">Question Review</h5>
        </div>
        <div class="card-body">
            @foreach($questions as $index => $item)
                @php
                    $question = $item['question'];
                    $examAnswer = $item['exam_answer'];
                    $isCorrect = $item['is_correct'];
                @endphp
                
                <div class="card mb-3 {{ $isCorrect ? 'border-success' : 'border-danger' }}">
                    <div class="card-header {{ $isCorrect ? 'bg-success bg-opacity-10' : 'bg-danger bg-opacity-10' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>Question {{ $index + 1 }}</strong>
                                @if($isCorrect)
                                    <span class="badge bg-success ms-2">
                                        <i class="bi bi-check-circle"></i> Correct
                                    </span>
                                @else
                                    <span class="badge bg-danger ms-2">
                                        <i class="bi bi-x-circle"></i> Incorrect
                                    </span>
                                @endif
                            </div>
                            <span class="badge bg-secondary">{{ $question->topic->domain->name }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="mb-3"><strong>{{ $question->question_text }}</strong></p>
                        
                        <div class="list-group mb-3">
                            @foreach($question->answers as $answer)
                                @php
                                    $isSelected = $examAnswer && $examAnswer->selected_answer_id === $answer->id;
                                    $isCorrectAnswer = $answer->is_correct;
                                @endphp
                                
                                <div class="list-group-item {{ $isCorrectAnswer ? 'list-group-item-success' : ($isSelected && !$isCorrectAnswer ? 'list-group-item-danger' : '') }}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            @if($isSelected)
                                                <i class="bi bi-arrow-right-circle-fill me-2"></i>
                                            @endif
                                            {{ $answer->answer_text }}
                                        </div>
                                        @if($isCorrectAnswer)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Correct Answer
                                            </span>
                                        @elseif($isSelected)
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle"></i> Your Answer
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($question->explanation)
                            <div class="alert alert-info mb-0">
                                <strong><i class="bi bi-info-circle"></i> Explanation:</strong>
                                <p class="mb-0 mt-2">{{ $question->explanation }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

{{-- Chart.js Initialization Scripts --}}
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded');
        return;
    }

    // Chart data from backend
    const chartData = @json($chartData);
    
    // ========================================
    // Domain Performance Radar Chart
    // ========================================
    const radarCtx = document.getElementById('domainRadarChart');
    if (radarCtx && chartData.domain_radar.labels.length > 0) {
        new Chart(radarCtx, {
            type: 'radar',
            data: {
                labels: chartData.domain_radar.labels,
                datasets: [
                    {
                        label: 'Your Performance',
                        data: chartData.domain_radar.scores,
                        backgroundColor: 'rgba(111, 66, 193, 0.2)',
                        borderColor: 'rgba(111, 66, 193, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(111, 66, 193, 1)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(111, 66, 193, 1)',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Passing Threshold',
                        data: Array(chartData.domain_radar.labels.length).fill(chartData.domain_radar.passing),
                        backgroundColor: 'rgba(220, 53, 69, 0.05)',
                        borderColor: 'rgba(220, 53, 69, 0.8)',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        pointRadius: 0,
                        pointHoverRadius: 0,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20,
                            callback: function(value) {
                                return value + '%';
                            },
                            font: {
                                size: 11
                            }
                        },
                        pointLabels: {
                            font: {
                                size: 12,
                                weight: '500'
                            },
                            callback: function(label) {
                                // Wrap long labels
                                if (label.length > 20) {
                                    return label.substring(0, 20) + '...';
                                }
                                return label;
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        angleLines: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.r.toFixed(1) + '%';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }
    
    // ========================================
    // Score Distribution Doughnut Chart
    // ========================================
    const doughnutCtx = document.getElementById('scoreDistributionChart');
    if (doughnutCtx && chartData.score_distribution.data.length > 0) {
        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: chartData.score_distribution.labels,
                datasets: [{
                    data: chartData.score_distribution.data,
                    backgroundColor: chartData.score_distribution.colors,
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        display: false // We're using custom legend below chart
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            },
            plugins: [{
                id: 'centerText',
                beforeDraw: function(chart) {
                    const width = chart.width;
                    const height = chart.height;
                    const ctx = chart.ctx;
                    ctx.restore();
                    
                    // Calculate percentage
                    const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    const correct = chart.data.datasets[0].data[0];
                    const percentage = ((correct / total) * 100).toFixed(1);
                    
                    // Draw percentage in center
                    const fontSize = (height / 100).toFixed(2);
                    ctx.font = 'bold ' + (fontSize * 20) + 'px sans-serif';
                    ctx.textBaseline = 'middle';
                    ctx.fillStyle = '#333';
                    
                    const text = percentage + '%';
                    const textX = Math.round((width - ctx.measureText(text).width) / 2);
                    const textY = height / 2 - 10;
                    
                    ctx.fillText(text, textX, textY);
                    
                    // Draw label below percentage
                    ctx.font = (fontSize * 8) + 'px sans-serif';
                    ctx.fillStyle = '#666';
                    const labelText = 'Accuracy';
                    const labelX = Math.round((width - ctx.measureText(labelText).width) / 2);
                    const labelY = height / 2 + 15;
                    ctx.fillText(labelText, labelX, labelY);
                    
                    ctx.save();
                }
            }]
        });
    }
    
    // ========================================
    // Progress Trend Line Chart
    // ========================================
    @if($progressTrendData && $progressTrendData['attempt_count'] >= 2)
    const progressTrendData = @json($progressTrendData);
    const trendCtx = document.getElementById('progressTrendChart');
    
    if (trendCtx && progressTrendData) {
        // Prepare datasets
        const datasets = [
            {
                label: 'Overall Score',
                data: progressTrendData.overall_scores,
                borderColor: 'rgba(111, 66, 193, 1)',
                backgroundColor: 'rgba(111, 66, 193, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: 'rgba(111, 66, 193, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(111, 66, 193, 1)',
            }
        ];
        
        // Add domain lines
        const domainColors = {
            'Mobile Devices': 'rgba(13, 110, 253, 1)',
            'Hardware': 'rgba(255, 159, 64, 1)',
            'Networking': 'rgba(23, 162, 184, 1)',
            'Hardware and Network Troubleshooting': 'rgba(40, 167, 69, 1)',
            'Virtualization and Cloud Computing': 'rgba(220, 53, 69, 1)'
        };
        
        Object.keys(progressTrendData.domain_scores).forEach(domainName => {
            datasets.push({
                label: domainName,
                data: progressTrendData.domain_scores[domainName],
                borderColor: domainColors[domainName] || 'rgba(108, 117, 125, 1)',
                backgroundColor: 'transparent',
                borderWidth: 2,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: domainColors[domainName] || 'rgba(108, 117, 125, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 1,
            });
        });
        
        // Add passing threshold line
        datasets.push({
            label: 'Passing Threshold (' + progressTrendData.passing_score + '%)',
            data: Array(progressTrendData.labels.length).fill(progressTrendData.passing_score),
            borderColor: 'rgba(220, 53, 69, 0.8)',
            backgroundColor: 'transparent',
            borderWidth: 2,
            borderDash: [10, 5],
            pointRadius: 0,
            tension: 0,
        });
        
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: progressTrendData.labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + '%';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            },
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        title: {
                            display: true,
                            text: 'Score Percentage',
                            font: {
                                size: 13,
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Benchmark Attempts',
                            font: {
                                size: 13,
                                weight: 'bold'
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
@endsection

