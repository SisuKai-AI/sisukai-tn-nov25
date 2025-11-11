@extends('layouts.admin')

@section('title', 'Edit Role - SisuKai Admin')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item active">Edit Role</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit Role</h4>
            <p class="text-muted mb-0">Update role information</p>
        </div>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-label-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Role Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name *</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $role->name) }}"
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
                                      required>{{ old('description', $role->description) }}</textarea>
                            <div class="form-text">Maximum 500 characters</div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Role
                            </button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-label-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            @if($role->users()->count() == 0)
                <div class="card border-danger mt-4">
                    <div class="card-header bg-label-danger">
                        <h6 class="mb-0 text-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>Danger Zone
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Once you delete this role, there is no going back. Please be certain.</p>
                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this role? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>Delete Role
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="card border-warning mt-4">
                    <div class="card-header bg-label-warning">
                        <h6 class="mb-0 text-warning">
                            <i class="bi bi-info-circle me-2"></i>Cannot Delete
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">This role cannot be deleted because it is currently assigned to {{ $role->users()->count() }} {{ Str::plural('user', $role->users()->count()) }}.</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-info-circle me-2"></i>Role Details
                    </h6>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Role ID</small>
                        <strong>#{{ $role->id }}</strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Assigned Users</small>
                        <span class="badge bg-label-primary">{{ $role->users()->count() }} {{ Str::plural('user', $role->users()->count()) }}</span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Created At</small>
                        <strong>{{ $role->created_at->format('M d, Y H:i A') }}</strong>
                    </div>

                    <div class="mb-0">
                        <small class="text-muted d-block mb-1">Last Updated</small>
                        <strong>{{ $role->updated_at->format('M d, Y H:i A') }}</strong>
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

.bg-label-danger {
    background-color: rgba(255, 62, 29, 0.08) !important;
}

.bg-label-warning {
    background-color: rgba(255, 171, 0, 0.08) !important;
}
</style>
@endsection

