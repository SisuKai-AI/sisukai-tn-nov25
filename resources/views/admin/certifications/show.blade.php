@extends('layouts.admin')

@section('title', $certification->name)

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $certification->name }}</h4>
            <p class="text-muted mb-0">
                <span class="badge bg-primary text-white">{{ $certification->provider }}</span>
                @if($certification->is_active)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-secondary">Inactive</span>
                @endif
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.certifications.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
            <a href="{{ route('admin.certifications.edit', $certification) }}" class="btn btn-primary">
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

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="stats-icon primary">
                        <i class="bi bi-folder"></i>
                    </div>
                    <div class="stats-title">Domains</div>
                    <div class="stats-value">{{ $stats['total_domains'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="stats-icon info">
                        <i class="bi bi-list-task"></i>
                    </div>
                    <div class="stats-title">Topics</div>
                    <div class="stats-value">{{ $stats['total_topics'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="stats-icon warning">
                        <i class="bi bi-question-circle"></i>
                    </div>
                    <div class="stats-title">Questions</div>
                    <div class="stats-value">{{ $stats['total_questions'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="stats-icon success">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <div class="stats-title">Attempts</div>
                    <div class="stats-value">{{ $stats['total_attempts'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="stats-icon success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stats-title">Passed</div>
                    <div class="stats-value">{{ $stats['passed_attempts'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="stats-icon primary">
                        <i class="bi bi-award"></i>
                    </div>
                    <div class="stats-title">Certificates</div>
                    <div class="stats-value">{{ $stats['total_certificates'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Details -->
        <div class="col-lg-8">
            <!-- Certification Details -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Certification Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Name</label>
                            <div class="fw-medium">{{ $certification->name }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Slug</label>
                            <div class="fw-medium">{{ $certification->slug }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Provider</label>
                            <div class="fw-medium">{{ $certification->provider }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Status</label>
                            <div>
                                @if($certification->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="text-muted small">Description</label>
                            <div>{{ $certification->description }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Exam Configuration -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Exam Configuration</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Questions</label>
                            <div class="fw-medium">{{ $certification->exam_question_count }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Duration</label>
                            <div class="fw-medium">{{ $certification->exam_duration_minutes }} min</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Passing Score</label>
                            <div class="fw-medium">{{ $certification->passing_score }}%</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Price</label>
                            <div class="fw-medium">${{ number_format($certification->price_single_cert, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Domains List -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Knowledge Domains</h5>
                    <a href="{{ route('admin.certifications.domains.index', $certification) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-folder-plus me-1"></i>Manage Domains
                    </a>
                </div>
                <div class="card-body">
                    @forelse($certification->domains as $domain)
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 border-bottom">
                            <div>
                                <strong>{{ $domain->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $domain->topics->count() }} topics</small>
                            </div>
                            <a href="{{ route('admin.certifications.domains.show', [$certification, $domain]) }}" class="btn btn-sm btn-outline-primary">
                                View
                            </a>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3">
                            <i class="bi bi-folder" style="font-size: 2rem;"></i>
                            <p class="mb-0">No domains added yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column - Actions & Info -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.certifications.domains.index', $certification) }}" class="btn btn-outline-primary">
                            <i class="bi bi-folder me-2"></i>Manage Domains
                        </a>
                        <a href="{{ route('admin.questions.create', ['certification_id' => $certification->id]) }}" class="btn btn-outline-success">
                            <i class="bi bi-plus-circle me-2"></i>Add Questions
                        </a>
                        <form action="{{ route('admin.certifications.toggleStatus', $certification) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-{{ $certification->is_active ? 'warning' : 'success' }} w-100">
                                <i class="bi bi-{{ $certification->is_active ? 'pause' : 'play' }}-circle me-2"></i>
                                {{ $certification->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Metadata</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Created</small>
                        <div class="small">{{ $certification->created_at->format('M d, Y H:i') }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Last Updated</small>
                        <div class="small">{{ $certification->updated_at->format('M d, Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

