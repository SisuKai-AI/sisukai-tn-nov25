@extends('layouts.admin')

@section('title', 'Manage Permissions - ' . $role->display_name . ' - SisuKai Admin')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.roles.show', $role) }}">{{ $role->display_name }}</a></li>
            <li class="breadcrumb-item active">Manage Permissions</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Manage Permissions for {{ $role->display_name }}</h4>
            <p class="text-muted mb-0">Select permissions to assign to this role</p>
        </div>
        <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-label-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back to Role
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.roles.permissions.update', $role) }}">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Permissions Selection -->
            <div class="col-lg-8">
                @foreach($permissions as $category => $categoryPermissions)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-folder me-2"></i>{{ $category }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($categoryPermissions as $permission)
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="permissions[]" 
                                                   value="{{ $permission->id }}" 
                                                   id="permission_{{ $permission->id }}"
                                                   {{ in_array($permission->id, $assignedPermissionIds) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                <strong>{{ $permission->display_name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $permission->description }}</small>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Update Permissions
                        </button>
                        <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-label-secondary">
                            <i class="bi bi-x-circle me-1"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="col-lg-4">
                <!-- Role Info -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title">Role Information</h6>
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <div class="avatar avatar-md">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class="bi bi-shield-check" style="font-size: 1.5rem;"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">{{ $role->display_name }}</h6>
                                    <small class="text-muted">{{ $role->name }}</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="text-muted small mb-0">{{ $role->description }}</p>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title">Permission Statistics</h6>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Currently Assigned</span>
                            <span class="badge bg-label-primary">{{ count($assignedPermissionIds) }} permissions</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Total Available</span>
                            <span class="badge bg-label-secondary">{{ $permissions->flatten()->count() }} permissions</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" 
                                 role="progressbar" 
                                 style="width: {{ $permissions->flatten()->count() > 0 ? (count($assignedPermissionIds) / $permissions->flatten()->count()) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="bi bi-info-circle me-1"></i>About Permissions
                        </h6>
                        <p class="text-muted small mb-2">
                            Permissions define what actions users with this role can perform in the system.
                        </p>
                        <p class="text-muted small mb-0">
                            Select the checkboxes to grant permissions to this role. Changes will affect all users assigned to this role.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.form-check-primary .form-check-input:checked {
    background-color: #696cff;
    border-color: #696cff;
}

.form-check-label {
    cursor: pointer;
}

.form-check {
    padding: 0.75rem;
    border-radius: 0.375rem;
    transition: background-color 0.2s;
}

.form-check:hover {
    background-color: #f8f9fa;
}
</style>
@endsection

