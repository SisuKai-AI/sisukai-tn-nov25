@extends('layouts.admin')

@section('title', 'View User - SisuKai Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">View User</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">User Details</h4>
                <p class="text-muted mb-0">View admin user information</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-label-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- User Information Card -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar avatar-lg me-3">
                            <span class="avatar-initial rounded-circle bg-label-primary">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <h5 class="mb-1">
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="badge bg-info">You</span>
                                @endif
                            </h5>
                            <p class="text-muted mb-0">{{ $user->email }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">User ID</small>
                            <div class="fw-medium">#{{ $user->id }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">User Type</small>
                            <div><span class="badge bg-label-primary">{{ ucfirst($user->user_type) }}</span></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Email Address</small>
                            <div class="fw-medium">{{ $user->email }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Status</small>
                            <div><span class="badge bg-success">Active</span></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Created At</small>
                            <div class="fw-medium">{{ $user->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Last Updated</small>
                            <div class="fw-medium">{{ $user->updated_at->format('M d, Y h:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assigned Roles Card -->
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-shield-check me-2"></i>Assigned Roles
                    </h6>
                    <div class="row">
                        @forelse($user->roles as $role)
                            <div class="col-md-6 mb-3">
                                <div class="card bg-label-primary">
                                    <div class="card-body">
                                        <h6 class="mb-1">{{ $role->name }}</h6>
                                        <p class="text-muted small mb-0">{{ $role->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted mb-0">No roles assigned to this user.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-gear me-2"></i>Quick Actions
                    </h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-label-primary">
                            <i class="bi bi-pencil me-2"></i>Edit User
                        </a>
                        @if($user->id !== auth()->id())
                            <button type="button" class="btn btn-label-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bi bi-trash me-2"></i>Delete User
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-info-circle me-2"></i>Account Information
                    </h6>
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2">
                            <i class="bi bi-calendar-check me-2 text-muted"></i>
                            Member for {{ $user->created_at->diffForHumans(null, true) }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-shield-check me-2 text-muted"></i>
                            {{ $user->roles->count() }} {{ Str::plural('role', $user->roles->count()) }} assigned
                        </li>
                        <li>
                            <i class="bi bi-check-circle me-2 text-muted"></i>
                            Account is active
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
@if($user->id !== auth()->id())
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $user->name }}</strong>?</p>
                <p class="text-danger mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<style>
.avatar-lg {
    width: 80px;
    height: 80px;
}

.avatar-initial {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    font-weight: 600;
    font-size: 1.5rem;
}

.bg-label-primary {
    background-color: rgba(105, 108, 255, 0.16) !important;
    color: #696cff !important;
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

.btn-label-danger {
    background-color: rgba(255, 62, 29, 0.08);
    color: #ff3e1d;
    border: none;
}

.btn-label-danger:hover {
    background-color: rgba(255, 62, 29, 0.16);
    color: #ff3e1d;
}

.btn-label-secondary {
    background-color: rgba(108, 117, 125, 0.08);
    color: #6c757d;
    border: none;
}

.btn-label-secondary:hover {
    background-color: rgba(108, 117, 125, 0.16);
    color: #6c757d;
}
</style>
@endsection

