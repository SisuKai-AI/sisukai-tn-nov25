@extends('layouts.admin')

@section('title', 'Edit Topic - ' . $topic->name)

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
            <li class="breadcrumb-item active">Edit {{ $topic->name }}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit Topic</h4>
            <p class="text-muted mb-0">Update topic information</p>
        </div>
        <a href="{{ route('admin.domains.topics.show', [$domain, $topic]) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    <!-- Topic Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.domains.topics.update', [$domain, $topic]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Topic Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $topic->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Display Order <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                   id="order" name="order" value="{{ old('order', $topic->order) }}" 
                                   min="1" required>
                            <small class="form-text text-muted">Order in which this topic appears in the domain</small>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Topic
                            </button>
                            <a href="{{ route('admin.domains.topics.show', [$domain, $topic]) }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Panel -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Topic Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Questions</small>
                        <strong>{{ $topic->questions->count() }} questions</strong>
                    </div>
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

