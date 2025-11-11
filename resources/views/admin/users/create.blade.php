@extends('layouts.admin')

@section('title', 'Create User - SisuKai Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">Create User</li>
            </ol>
        </nav>
        <h4 class="mb-1">Create New Admin User</h4>
        <p class="text-muted mb-0">Add a new administrator to the system</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            <small class="text-muted">Minimum 8 characters</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
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
                                                   {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
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
                                <i class="bi bi-check-circle me-2"></i>Create User
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
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-info-circle me-2"></i>User Information
                    </h6>
                    <p class="small text-muted">
                        Admin users can access the admin portal and perform various management tasks based on their assigned roles.
                    </p>
                    <hr>
                    <h6 class="small fw-bold">Available Roles:</h6>
                    <ul class="small text-muted ps-3">
                        <li><strong>Super Admin:</strong> Full system access</li>
                        <li><strong>Content Manager:</strong> Manage content and certifications</li>
                        <li><strong>Support Staff:</strong> Handle user support</li>
                    </ul>
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

