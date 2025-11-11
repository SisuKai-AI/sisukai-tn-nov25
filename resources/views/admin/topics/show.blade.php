@extends('layouts.admin')

@section('title', $topic->name . ' - ' . $domain->name)

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.index') }}">Certifications</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.show', $domain->certification) }}">{{ $domain->certification->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.domains.index', $domain->certification) }}">Domains</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.domains.show', [$domain->certification, $domain]) }}">{{ $domain->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.domains.topics.index', $domain) }}">Topics</a></li>
            <li class="breadcrumb-item active">{{ $topic->name }}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $topic->name }}</h4>
            <p class="text-muted mb-0">Topic in {{ $domain->name }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.domains.topics.index', $domain) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
            <a href="{{ route('admin.domains.topics.edit', [$domain, $topic]) }}" class="btn btn-primary">
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
        <!-- Topic Details -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Topic Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <p>{{ $topic->name }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Display Order</label>
                        <p><span class="badge bg-secondary text-white">{{ $topic->order }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Questions List -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Questions ({{ $topic->questions->count() }})</h5>
                    <a href="{{ route('admin.questions.index', ['topic_id' => $topic->id]) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-list-ul me-2"></i>Manage Questions
                    </a>
                </div>
                <div class="card-body">
                    @forelse($topic->questions->take(5) as $question)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <p class="mb-2"><strong>{{ $loop->iteration }}. {{ $question->question_text }}</strong></p>
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-{{ $question->difficulty === 'easy' ? 'success' : ($question->difficulty === 'medium' ? 'warning' : 'danger') }} text-white">
                                            {{ ucfirst($question->difficulty) }}
                                        </span>
                                        <span class="badge bg-info text-white">{{ $question->answers->count() }} answers</span>
                                    </div>
                                </div>
                                <a href="{{ route('admin.questions.show', $question) }}" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-question-circle" style="font-size: 3rem; color: #ccc;"></i>
                            <h6 class="mt-3">No questions yet</h6>
                            <p class="text-muted">Start by adding questions for this topic</p>
                            <a href="{{ route('admin.questions.create', ['topic_id' => $topic->id]) }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle me-2"></i>Add First Question
                            </a>
                        </div>
                    @endforelse

                    @if($topic->questions->count() > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.questions.index', ['topic_id' => $topic->id]) }}" class="btn btn-outline-primary">
                                View All {{ $topic->questions->count() }} Questions
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('admin.questions.index', ['topic_id' => $topic->id]) }}" class="btn btn-outline-primary">
                        <i class="bi bi-question-circle me-2"></i>Manage Questions
                    </a>
                    <a href="{{ route('admin.questions.create', ['topic_id' => $topic->id]) }}" class="btn btn-outline-success">
                        <i class="bi bi-plus-circle me-2"></i>Add Question
                    </a>
                </div>
            </div>

            <!-- Metadata -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Metadata</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Created</small>
                        <strong>{{ $topic->created_at->format('M d, Y H:i') }}</strong>
                    </div>
                    <div>
                        <small class="text-muted d-block">Last Updated</small>
                        <strong>{{ $topic->updated_at->format('M d, Y H:i') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

