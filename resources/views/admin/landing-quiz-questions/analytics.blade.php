@extends('layouts.admin')

@section('title', 'Landing Quiz Analytics')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-4">
        <a href="{{ route('admin.landing-quiz-questions.index') }}" class="btn btn-sm btn-secondary mb-3">
            <i class="fas fa-arrow-left me-2"></i>Back to Quiz Questions
        </a>
        <h1 class="h3">Landing Page Quiz Analytics</h1>
        <p class="text-muted">Performance metrics for landing page quizzes</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Total Quiz Attempts</h6>
                    <h2 class="mb-0">{{ $certifications->sum('landing_quiz_attempts_count') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Total Conversions</h6>
                    <h2 class="mb-0 text-success">{{ $certifications->sum('converted_attempts_count') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Average Conversion Rate</h6>
                    <h2 class="mb-0 text-primary">
                        {{ $certifications->avg('conversion_rate') ? number_format($certifications->avg('conversion_rate'), 1) : 0 }}%
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Certifications with Quizzes</h6>
                    <h2 class="mb-0">{{ $certifications->where('landing_quiz_questions_count', 5)->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Performance by Certification</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Certification</th>
                            <th class="text-center">Quiz Questions</th>
                            <th class="text-center">Total Attempts</th>
                            <th class="text-center">Conversions</th>
                            <th class="text-center">Conversion Rate</th>
                            <th class="text-center">Performance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($certifications as $certification)
                            <tr>
                                <td>
                                    <strong>{{ $certification->name }}</strong><br>
                                    <small class="text-muted">{{ $certification->provider }}</small>
                                </td>
                                <td class="text-center">
                                    @if($certification->landing_quiz_questions_count == 5)
                                        <span class="badge bg-success">5/5</span>
                                    @else
                                        <span class="badge bg-warning">{{ $certification->landing_quiz_questions_count }}/5</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <strong>{{ $certification->landing_quiz_attempts_count }}</strong>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">{{ $certification->converted_attempts_count }}</span>
                                </td>
                                <td class="text-center">
                                    <strong class="{{ $certification->conversion_rate >= 15 ? 'text-success' : ($certification->conversion_rate >= 10 ? 'text-warning' : 'text-danger') }}">
                                        {{ number_format($certification->conversion_rate, 1) }}%
                                    </strong>
                                </td>
                                <td class="text-center">
                                    @if($certification->conversion_rate >= 15)
                                        <span class="badge bg-success">Excellent</span>
                                    @elseif($certification->conversion_rate >= 10)
                                        <span class="badge bg-warning">Good</span>
                                    @elseif($certification->conversion_rate >= 5)
                                        <span class="badge bg-info">Average</span>
                                    @else
                                        <span class="badge bg-danger">Needs Improvement</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fas fa-chart-line fa-2x mb-2"></i><br>
                                    No quiz attempts yet. Set up quiz questions and wait for visitor engagement.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="alert alert-info mt-4">
        <h6><i class="fas fa-lightbulb me-2"></i>Performance Benchmarks</h6>
        <ul class="mb-0 small">
            <li><strong>Excellent (15%+):</strong> Quiz questions are highly engaging and driving strong conversions</li>
            <li><strong>Good (10-15%):</strong> Solid performance, minor optimizations may help</li>
            <li><strong>Average (5-10%):</strong> Consider reviewing question quality and relevance</li>
            <li><strong>Needs Improvement (<5%):</strong> Review and replace quiz questions with more engaging content</li>
        </ul>
    </div>
</div>
@endsection
