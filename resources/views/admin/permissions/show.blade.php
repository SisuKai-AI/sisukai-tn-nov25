@extends('layouts.admin')

@section('title', 'View Permission - SisuKai Admin')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Permissions</a></li>
            <li class="breadcrumb-item active">View Permission</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Permission Details</h4>
            <p class="text-muted mb-0">View permission information and assigned roles</p>
        </div>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-label-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Permission Information Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-4">
                        <div class="permission-icon-large me-3">
                            <i class="bi bi-key"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-2">{{ $permission->display_name }}</h5>
                            <p class="text-muted mb-3">{{ $permission->description }}</p>
                            <div class="d-flex gap-2">
                                <span class="badge bg-label-primary">
                                    <i class="bi bi-shield me-1"></i>{{ $permission->roles_count }} {{ Str::plural('role', $permission->roles_count) }}
                                </span>
                                <span class="badge bg-label-secondary">
                                    <i class="bi bi-tag me-1"></i>{{ $permission->category }}
                                </span>
                                <span class="badge bg-label-info">
                                    <i class="bi bi-calendar me-1"></i>Created {{ $permission->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block mb-1">Permission ID</small>
                            <strong>#{{ $permission->id }}</strong>
                        </div>
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block mb-1">Permission Name</small>
                            <strong>{{ $permission->name }}</strong>
                        </div>
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block mb-1">Category</small>
                            <strong>{{ $permission->category }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block mb-1">Created At</small>
                            <strong>{{ $permission->created_at->format('M d, Y H:i A') }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block mb-1">Last Updated</small>
                            <strong>{{ $permission->updated_at->format('M d, Y H:i A') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assigned Roles Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Roles with this Permission ({{ $permission->roles_count }})</h6>
                </div>
                <div class="card-body">
                    @if($permission->roles->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Role</th>
                                        <th>Users</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permission->roles as $role)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="role-icon-sm me-2">
                                                        <i class="bi bi-shield-check"></i>
                                                    </div>
                                                    <div>
                                                        <strong>{{ ucwords(str_replace('_', ' ', $role->name)) }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ Str::limit($role->description, 50) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-label-primary">
                                                    {{ $role->users->count() }} {{ Str::plural('user', $role->users->count()) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $role->created_at->format('M d, Y') }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.roles.show', $role) }}" 
                                                   class="btn btn-sm btn-label-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-shield-check" style="font-size: 2rem; color: #ddd;"></i>
                            <p class="text-muted mt-2 mb-0">No roles have this permission yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Statistics Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-bar-chart me-2"></i>Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Roles with permission</small>
                            <strong>{{ $permission->roles_count }}</strong>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: {{ min(($permission->roles_count / 5) * 100, 100) }}%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Total users affected</small>
                            <strong>{{ $permission->roles->sum(fn($role) => $role->users->count()) }}</strong>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: {{ min(($permission->roles->sum(fn($role) => $role->users->count()) / 10) * 100, 100) }}%"></div>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-2">
                        <small class="text-muted d-block mb-1">Permission Age</small>
                        <strong>{{ $permission->created_at->diffForHumans() }}</strong>
                    </div>

                    <div class="mb-0">
                        <small class="text-muted d-block mb-1">Last Modified</small>
                        <strong>{{ $permission->updated_at->diffForHumans() }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.permission-icon-large {
    width: 64px;
    height: 64px;
    border-radius: 0.5rem;
    background: rgba(105, 108, 255, 0.16);
    color: #696cff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.role-icon-sm {
    width: 32px;
    height: 32px;
    border-radius: 0.375rem;
    background: rgba(105, 108, 255, 0.08);
    color: #696cff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

.btn-label-secondary {
    background-color: rgba(133, 146, 163, 0.08);
    color: #8592a3;
    border: none;
}

.btn-label-secondary:hover {
    background-color: rgba(133, 146, 163, 0.16);
    color: #8592a3;
}

.btn-label-primary {
    background-color: rgba(105, 108, 255, 0.08);
    color: #696cff;
    border: none;
}

.btn-label-primary:hover {
    background-color: rgba(105, 108, 255, 0.16);
    color: #696cff;
}

.bg-label-primary {
    background-color: rgba(105, 108, 255, 0.16) !important;
    color: #696cff !important;
}

.bg-label-secondary {
    background-color: rgba(133, 146, 163, 0.16) !important;
    color: #8592a3 !important;
}

.bg-label-info {
    background-color: rgba(3, 195, 236, 0.16) !important;
    color: #03c3ec !important;
}
</style>
@endsection

