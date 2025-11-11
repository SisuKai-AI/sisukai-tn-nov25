@extends('layouts.admin')

@section('title', 'Question Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Question Details</h4>
            <p class="text-muted mb-0">
                <span class="badge bg-primary text-white">{{ $question->topic->domain->certification->name }}</span>
                @if($question->difficulty == 'easy')
                    <span class="badge bg-success">Easy</span>
                @elseif($question->difficulty == 'medium')
                    <span class="badge bg-warning">Medium</span>
                @else
                    <span class="badge bg-danger">Hard</span>
                @endif
                @if($question->status == 'approved')
                    <span class="badge bg-success">Approved</span>
                @elseif($question->status == 'pending_review')
                    <span class="badge bg-warning">Pending Review</span>
                @elseif($question->status == 'draft')
                    <span class="badge bg-secondary">Draft</span>
                @else
                    <span class="badge bg-dark">Archived</span>
                @endif
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
            <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Question Card -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Question</h5>
                </div>
                <div class="card-body">
                    <p class="lead">{{ $question->question_text }}</p>
                </div>
            </div>

            <!-- Answers Card -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Answer Options</h5>
                </div>
                <div class="card-body">
                    @foreach($question->answers as $answer)
                        <div class="card mb-2 {{ $answer->is_correct ? 'border-success' : '' }}">
                            <div class="card-body py-2">
                                <div class="d-flex align-items-center">
                                    @if($answer->is_correct)
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    @else
                                        <i class="bi bi-circle me-2 text-muted"></i>
                                    @endif
                                    <span>{{ $answer->answer_text }}</span>
                                    @if($answer->is_correct)
                                        <span class="badge bg-success ms-auto">Correct Answer</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Explanation Card -->
            @if($question->explanation)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Explanation</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $question->explanation }}</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($question->status != 'approved')
                            <form action="{{ route('admin.questions.approve', $question) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-check-circle me-2"></i>Approve
                                </button>
                            </form>
                        @endif
                        @if($question->status != 'archived')
                            <form action="{{ route('admin.questions.archive', $question) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="bi bi-archive me-2"></i>Archive
                                </button>
                            </form>
                        @endif
                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash me-2"></i>Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Certification</small>
                        <div class="small">{{ $question->topic->domain->certification->name }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Domain</small>
                        <div class="small">{{ $question->topic->domain->name }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Topic</small>
                        <div class="small">{{ $question->topic->name }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Difficulty</small>
                        <div class="small text-capitalize">{{ $question->difficulty }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Status</small>
                        <div class="small text-capitalize">{{ str_replace('_', ' ', $question->status) }}</div>
                    </div>
                    <hr>
                    <div class="mb-2">
                        <small class="text-muted">Created</small>
                        <div class="small">{{ $question->created_at->format('M d, Y H:i') }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Last Updated</small>
                        <div class="small">{{ $question->updated_at->format('M d, Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Are you sure you want to delete this question?</p>
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone. The question and all its answers will be permanently deleted.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </button>
                <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Delete Question
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

