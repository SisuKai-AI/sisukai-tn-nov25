@extends('layouts.admin')

@section('title', 'Create Domain')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.index') }}">Certifications</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.show', $certification) }}">{{ $certification->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.domains.index', $certification) }}">Domains</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Create New Domain</h4>
            <p class="text-muted mb-0">Add a knowledge domain to {{ $certification->name }}</p>
        </div>
        <a href="{{ route('admin.certifications.domains.index', $certification) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.certifications.domains.store', $certification) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Domain Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            <small class="text-muted">Brief description of this knowledge domain</small>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Display Order</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                   id="order" name="order" value="{{ old('order', 1) }}" min="0">
                            <small class="text-muted">Leave blank to auto-assign</small>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.certifications.domains.index', $certification) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Create Domain
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-info-circle me-2"></i>About Domains
                    </h6>
                    <p class="small text-muted">
                        Domains represent major knowledge areas within a certification. For example:
                    </p>
                    <ul class="small text-muted">
                        <li>Cloud Concepts</li>
                        <li>Security & Compliance</li>
                        <li>Technology</li>
                        <li>Billing & Pricing</li>
                    </ul>
                    <hr>
                    <p class="small text-muted mb-0">
                        After creating a domain, you can add topics and questions to it.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

