@extends('layouts.admin')

@section('title', 'Add Topic - ' . $domain->name)

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
            <li class="breadcrumb-item active">Add Topic</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Add New Topic</h4>
            <p class="text-muted mb-0">Create a new topic for {{ $domain->name }}</p>
        </div>
        <a href="{{ route('admin.domains.topics.index', $domain) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    <!-- Topic Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.domains.topics.store', $domain) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Topic Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Display Order <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                   id="order" name="order" value="{{ old('order', $domain->topics()->count() + 1) }}" 
                                   min="1" required>
                            <small class="form-text text-muted">Order in which this topic appears in the domain</small>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Create Topic
                            </button>
                            <a href="{{ route('admin.domains.topics.index', $domain) }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Quick Guide -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Guide</h5>
                </div>
                <div class="card-body">
                    <h6>Creating a Topic</h6>
                    <ul class="small">
                        <li>Topics are specific subject areas within a domain</li>
                        <li>Use clear, descriptive names</li>
                        <li>Order determines the learning sequence</li>
                        <li>Questions will be added after topic creation</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

