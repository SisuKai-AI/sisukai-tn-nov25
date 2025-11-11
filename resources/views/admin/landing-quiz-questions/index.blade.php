@extends('layouts.admin')

@section('title', 'Landing Page Quiz Questions')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Landing Page Quiz Questions</h1>
        <a href="{{ route('admin.landing-quiz-questions.analytics') }}" class="btn btn-info">
            <i class="fas fa-chart-line me-2"></i>View Analytics
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Manage Quiz Questions by Certification</h5>
            <p class="text-muted small mb-0">Select 5 questions from each certification's question bank to display on landing pages</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Certification</th>
                            <th>Provider</th>
                            <th class="text-center">Quiz Questions</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($certifications as $certification)
                            <tr>
                                <td>
                                    <strong>{{ $certification->name }}</strong>
                                </td>
                                <td>{{ $certification->provider }}</td>
                                <td class="text-center">
                                    @if($certification->landing_quiz_questions_count == 5)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>5/5 Selected
                                        </span>
                                    @elseif($certification->landing_quiz_questions_count > 0)
                                        <span class="badge bg-warning">
                                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $certification->landing_quiz_questions_count }}/5 Selected
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-times me-1"></i>Not Set
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($certification->landing_quiz_questions_count == 5)
                                        <span class="badge bg-success">Ready</span>
                                    @else
                                        <span class="badge bg-danger">Incomplete</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.landing-quiz-questions.edit', $certification) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit me-1"></i>
                                        {{ $certification->landing_quiz_questions_count > 0 ? 'Edit Questions' : 'Select Questions' }}
                                    </a>
                                    @if($certification->landing_quiz_questions_count > 0)
                                        <form action="{{ route('admin.landing-quiz-questions.destroy', $certification) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to remove all quiz questions for this certification?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No certifications found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($certifications->hasPages())
            <div class="card-footer">
                {{ $certifications->links() }}
            </div>
        @endif
    </div>

    <div class="alert alert-info mt-4">
        <h6><i class="fas fa-info-circle me-2"></i>How It Works</h6>
        <ul class="mb-0 small">
            <li>Each certification needs exactly <strong>5 quiz questions</strong> for the landing page</li>
            <li>Questions are selected from the certification's approved question bank</li>
            <li>Quiz questions help engage visitors and encourage registration</li>
            <li>Questions are displayed in the order you select them</li>
        </ul>
    </div>
</div>
@endsection
