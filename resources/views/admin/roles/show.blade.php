@extends('layouts.admin')

@section('title', 'View Role - SisuKai Admin')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item active">View Role</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Role Details</h4>
            <p class="text-muted mb-0">View role information and assigned users</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-2"></i>Edit Role
            </a>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-label-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Role Information Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-4">
                        <div class="role-icon-large me-3">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-2">{{ ucwords(str_replace('_', ' ', $role->name)) }}</h5>
                            <p class="text-muted mb-3">{{ $role->description }}</p>
                            <div class="d-flex gap-2">
                                <span class="badge bg-label-primary">
                                    <i class="bi bi-people me-1"></i>{{ $role->users_count }} {{ Str::plural('user', $role->users_count) }}
                                </span>
                                <span class="badge bg-label-secondary">
                                    <i class="bi bi-calendar me-1"></i>Created {{ $role->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block mb-1">Role ID</small>
                            <strong>#{{ $role->id }}</strong>
                        </div>
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block mb-1">Role Name</small>
                            <strong>{{ $role->name }}</strong>
                        </div>
                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block mb-1">Status</small>
                            <span class="badge bg-success">Active</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block mb-1">Created At</small>
                            <strong>{{ $role->created_at->format('M d, Y H:i A') }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block mb-1">Last Updated</small>
                            <strong>{{ $role->updated_at->format('M d, Y H:i A') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assigned Users Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Assigned Users ({{ $role->users_count }})</h6>
                </div>
                <div class="card-body">
                    @if($role->users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($role->users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-2">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <strong>{{ $user->name }}</strong>
                                                        @if($user->id === auth()->id())
                                                            <span class="badge bg-info ms-2">You</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge bg-success">Active</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-label-primary">
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
                            <i class="bi bi-people" style="font-size: 2rem; color: #ddd;"></i>
                            <p class="text-muted mt-2 mb-0">No users assigned to this role yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-lightning-charge me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.roles.permissions.edit', $role) }}" class="btn btn-primary">
                            <i class="bi bi-key me-2"></i>Manage Permissions
                        </a>
                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-label-warning">
                            <i class="bi bi-pencil me-2"></i>Edit Role
                        </a>
                        @if($role->users_count == 0)
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this role?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-label-danger w-100">
                                    <i class="bi bi-trash me-2"></i>Delete Role
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Role Statistics Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-bar-chart me-2"></i>Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Users with this role</small>
                            <strong>{{ $role->users_count }}</strong>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: {{ min(($role->users_count / 10) * 100, 100) }}%"></div>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-2">
                        <small class="text-muted d-block mb-1">Role Age</small>
                        <strong>{{ $role->created_at->diffForHumans() }}</strong>
                    </div>

                    <div class="mb-0">
                        <small class="text-muted d-block mb-1">Last Modified</small>
                        <strong>{{ $role->updated_at->diffForHumans() }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.role-icon-large {
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

.avatar-sm {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(105, 108, 255, 0.16);
    color: #696cff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
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

.btn-label-warning {
    background-color: rgba(255, 171, 0, 0.08);
    color: #ffab00;
    border: none;
}

.btn-label-warning:hover {
    background-color: rgba(255, 171, 0, 0.16);
    color: #ffab00;
}

.btn-label-danger {
    background-color: rgba(255, 62, 29, 0.08);
    color: #ff3e1d;
    border: none;
}

.btn-label-danger:hover {
    background-color: rgba(255, 62, 29, 0.16);
    color: #ff3e1d;
}

.bg-label-secondary {
    background-color: rgba(133, 146, 163, 0.16) !important;
    color: #8592a3 !important;
}
</style>
@endsection

