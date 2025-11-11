@extends('layouts.admin')

@section('title', 'Create Role - SisuKai Admin')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item active">Create Role</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="mb-1">Create New Role</h4>
        <p class="text-muted mb-0">Add a new role to the system</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf

                        <!-- Role Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name *</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="e.g., content_manager"
                                   required>
                            <div class="form-text">Use lowercase with underscores (e.g., content_manager)</div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Describe the role's responsibilities and permissions..."
                                      required>{{ old('description') }}</textarea>
                            <div class="form-text">Maximum 500 characters</div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Create Role
                            </button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-label-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-info-circle me-2"></i>Role Information
                    </h6>
                    <p class="small text-muted mb-3">
                        Roles define what actions admin users can perform in the system. Each role should have a clear, descriptive name and detailed description.
                    </p>
                    
                    <h6 class="small fw-semibold mb-2">Naming Guidelines:</h6>
                    <ul class="small text-muted mb-3">
                        <li>Use lowercase letters</li>
                        <li>Separate words with underscores</li>
                        <li>Be descriptive and concise</li>
                        <li>Examples: super_admin, content_manager, support_staff</li>
                    </ul>

                    <div class="alert alert-info mb-0">
                        <i class="bi bi-lightbulb me-2"></i>
                        <strong>Tip:</strong> After creating a role, you can assign it to users in the User Management section.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-label-secondary {
    background-color: rgba(133, 146, 163, 0.08);
    color: #8592a3;
    border: none;
}

.btn-label-secondary:hover {
    background-color: rgba(133, 146, 163, 0.16);
    color: #8592a3;
}
</style>
@endsection

