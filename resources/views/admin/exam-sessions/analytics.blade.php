@extends('layouts.admin')

@section('title', 'Exam Session Analytics')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Exam Session Analytics</h1>
            <p class="text-muted">Comprehensive insights into exam performance and trends</p>
        </div>
        <a href="{{ route('admin.exam-sessions.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Sessions
        </a>
    </div>

    <!-- Overview Statistics -->
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
                            <i class="bi bi-graph-up text-success" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Avg Score</h6>
                            <h3 class="mb-0">{{ number_format($overallAvgScore, 1) }}%</h3>
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
                            <i class="bi bi-trophy text-warning" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Pass Rate</h6>
                            <h3 class="mb-0">{{ number_format($overallPassRate, 1) }}%</h3>
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
                            <i class="bi bi-people text-info" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Top Performers</h6>
                            <h3 class="mb-0">{{ $topPerformers->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Exam Type Breakdown -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info bg-opacity-10">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clipboard-data text-info me-2"></i>Benchmark Exams
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Total Sessions</span>
                            <strong>{{ $benchmarkStats['count'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Average Score</span>
                            <strong>{{ number_format($benchmarkStats['avg_score'], 1) }}%</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Completion Rate</span>
                            <strong>{{ number_format($benchmarkStats['completion_rate'], 1) }}%</strong>
                        </div>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-info" style="width: {{ $benchmarkStats['completion_rate'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-warning bg-opacity-10">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pencil-square text-warning me-2"></i>Practice Exams
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Total Sessions</span>
                            <strong>{{ $practiceStats['count'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Average Score</span>
                            <strong>{{ number_format($practiceStats['avg_score'], 1) }}%</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Completion Rate</span>
                            <strong>{{ number_format($practiceStats['completion_rate'], 1) }}%</strong>
                        </div>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: {{ $practiceStats['completion_rate'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary bg-opacity-10">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-award text-primary me-2"></i>Final Exams
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Total Sessions</span>
                            <strong>{{ $finalStats['count'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Average Score</span>
                            <strong>{{ number_format($finalStats['avg_score'], 1) }}%</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Pass Rate</span>
                            <strong>{{ number_format($finalStats['pass_rate'], 1) }}%</strong>
                        </div>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: {{ $finalStats['pass_rate'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Top Performers -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-trophy me-2"></i>Top Performers
                    </h5>
                </div>
                <div class="card-body">
                    @if($topPerformers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Learner</th>
                                        <th>Avg Score</th>
                                        <th>Sessions</th>
                                        <th>Pass Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topPerformers as $index => $performer)
                                        <tr>
                                            <td>
                                                @if($index == 0)
                                                    <i class="bi bi-trophy-fill text-warning"></i>
                                                @elseif($index == 1)
                                                    <i class="bi bi-trophy-fill text-secondary"></i>
                                                @elseif($index == 2)
                                                    <i class="bi bi-trophy-fill text-danger"></i>
                                                @else
                                                    {{ $index + 1 }}
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $performer->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $performer->email }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ number_format($performer->avg_score, 1) }}%</span>
                                            </td>
                                            <td>{{ $performer->total_sessions }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ number_format($performer->pass_rate, 1) }}%</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-trophy text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2 mb-0">No completed exams yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2"></i>Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentActivity->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentActivity as $activity)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $activity->learner->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $activity->certification->name }}</small>
                                            <br>
                                            <small class="text-muted">
                                                <i class="bi bi-clock me-1"></i>{{ $activity->completed_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            @if($activity->exam_type == 'benchmark')
                                                <span class="badge bg-info">Benchmark</span>
                                            @elseif($activity->exam_type == 'practice')
                                                <span class="badge bg-warning">Practice</span>
                                            @else
                                                <span class="badge bg-primary">Final</span>
                                            @endif
                                            <br>
                                            <span class="badge {{ $activity->passed ? 'bg-success' : 'bg-danger' }} mt-1">
                                                {{ number_format($activity->score_percentage, 1) }}%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-clock-history text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2 mb-0">No recent activity</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

