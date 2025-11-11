@extends('layouts.admin')

@section('title', 'Edit User - SisuKai Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">Edit User</li>
            </ol>
        </nav>
        <h4 class="mb-1">Edit Admin User</h4>
        <p class="text-muted mb-0">Update user information and roles</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password">
                            <small class="text-muted">Leave blank to keep current password. Minimum 8 characters if changing.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation">
                        </div>

                        <!-- Roles -->
                        <div class="mb-4">
                            <label class="form-label">Assign Roles <span class="text-danger">*</span></label>
                            @error('roles')
                                <div class="text-danger small mb-2">{{ $message }}</div>
                            @enderror
                            <div class="row">
                                @foreach($roles as $role)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check card p-3">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="roles[]" value="{{ $role->id }}" 
                                                   id="role{{ $role->id }}"
                                                   {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <label class="form-check-label ms-2" for="role{{ $role->id }}">
                                                <strong>{{ $role->name }}</strong>
                                                <p class="text-muted small mb-0">{{ $role->description }}</p>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update User
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-label-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-person-circle me-2"></i>User Details
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <small class="text-muted">User ID:</small>
                            <div class="fw-medium">#{{ $user->id }}</div>
                        </li>
                        <li class="mb-2">
                            <small class="text-muted">Created:</small>
                            <div class="fw-medium">{{ $user->created_at->format('M d, Y') }}</div>
                        </li>
                        <li class="mb-2">
                            <small class="text-muted">Last Updated:</small>
                            <div class="fw-medium">{{ $user->updated_at->format('M d, Y') }}</div>
                        </li>
                        <li>
                            <small class="text-muted">Status:</small>
                            <div><span class="badge bg-success">Active</span></div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>Danger Zone
                    </h6>
                    <p class="small text-muted">
                        Deleting a user is permanent and cannot be undone.
                    </p>
                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="bi bi-trash me-2"></i>Delete User
                            </button>
                        </form>
                    @else
                        <button type="button" class="btn btn-danger btn-sm w-100" disabled>
                            <i class="bi bi-trash me-2"></i>Cannot Delete Yourself
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-check.card {
    cursor: pointer;
    transition: all 0.2s;
}

.form-check.card:hover {
    background-color: #f8f9fa;
}

.form-check.card:has(.form-check-input:checked) {
    background-color: rgba(105, 108, 255, 0.08);
    border-color: #696cff;
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

