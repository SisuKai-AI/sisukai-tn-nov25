@extends('layouts.admin')

@section('title', $domain->name)

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.index') }}">Certifications</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.show', $certification) }}">{{ $certification->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.domains.index', $certification) }}">Domains</a></li>
            <li class="breadcrumb-item active">{{ $domain->name }}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $domain->name }}</h4>
            <p class="text-muted mb-0">Domain in {{ $certification->name }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.certifications.domains.index', $certification) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
            <a href="{{ route('admin.certifications.domains.edit', [$certification, $domain]) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Domain Details -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Domain Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Name</label>
                        <div class="fw-medium">{{ $domain->name }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Description</label>
                        <div>{{ $domain->description ?? 'No description provided' }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Display Order</label>
                        <div><span class="badge bg-label-secondary">{{ $domain->order }}</span></div>
                    </div>
                </div>
            </div>

            <!-- Topics List -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Topics</h5>
                    <a href="{{ route('admin.domains.topics.index', $domain) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-list-task me-1"></i>Manage Topics
                    </a>
                </div>
                <div class="card-body">
                    @forelse($domain->topics as $topic)
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 border-bottom">
                            <div>
                                <strong>{{ $topic->name }}</strong>
                                <br>
                                <small class="text-muted">Order: {{ $topic->order }}</small>
                            </div>
                            <a href="{{ route('admin.domains.topics.show', [$domain, $topic]) }}" class="btn btn-sm btn-outline-primary">
                                View
                            </a>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3">
                            <i class="bi bi-list-task" style="font-size: 2rem;"></i>
                            <p class="mb-0">No topics added yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.domains.topics.index', $domain) }}" class="btn btn-outline-primary">
                            <i class="bi bi-list-task me-2"></i>Manage Topics
                        </a>
                        <a href="{{ route('admin.domains.topics.create', $domain) }}" class="btn btn-outline-success">
                            <i class="bi bi-plus-circle me-2"></i>Add Topic
                        </a>
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
                        <div class="small">{{ $domain->created_at->format('M d, Y H:i') }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Last Updated</small>
                        <div class="small">{{ $domain->updated_at->format('M d, Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

