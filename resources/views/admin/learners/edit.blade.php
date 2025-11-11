@extends('layouts.admin')

@section('title', 'Edit Learner')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.learners.index') }}">Learners</a></li>
            <li class="breadcrumb-item active">Edit Learner</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Learner</h4>
            <p class="text-muted mb-0">Update learner information</p>
        </div>
        <a href="{{ route('admin.learners.show', $learner) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Learner
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Edit Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.learners.update', $learner) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $learner->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $learner->email) }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            <small class="form-text text-muted">Leave blank to keep current password. Minimum 8 characters if changing.</small>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Learner
                            </button>
                            <a href="{{ route('admin.learners.show', $learner) }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>Danger Zone
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Once you delete this learner, there is no going back. Please be certain.</p>
                    <form action="{{ route('admin.learners.destroy', $learner) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this learner? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Delete Learner
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Learner Details -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-person-circle me-2"></i>Learner Details
                    </h5>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Learner ID</label>
                        <p class="fw-semibold">#{{ $learner->id }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Created At</label>
                        <p class="fw-semibold">{{ $learner->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div>
                        <label class="form-label text-muted small">Last Updated</label>
                        <p class="fw-semibold">{{ $learner->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

