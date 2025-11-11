@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">My Profile</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">My Profile</h4>
            <p class="text-muted mb-0">View and manage your account information</p>
        </div>
        <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">
            <i class="bi bi-pencil-square me-2"></i>Edit Profile
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Profile Information Card -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center">
                    <i class="bi bi-person-circle me-2"></i>
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="form-label fw-bold">Full Name</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-0">{{ $user->name }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="form-label fw-bold">Email Address</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-0">{{ $user->email }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="form-label fw-bold">User Type</label>
                        </div>
                        <div class="col-sm-9">
                            <span class="badge bg-primary">{{ ucfirst($user->user_type) }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="form-label fw-bold">Roles</label>
                        </div>
                        <div class="col-sm-9">
                            @foreach($user->roles as $role)
                                <span class="badge bg-info me-1">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="form-label fw-bold">Account Status</label>
                        </div>
                        <div class="col-sm-9">
                            @if($user->status === 'active')
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Active</span>
                            @else
                                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Disabled</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="form-label fw-bold">Member Since</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-0">{{ $user->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="form-label fw-bold">Last Updated</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-0">{{ $user->updated_at->format('F d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Avatar Card -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center" 
                             style="width: 120px; height: 120px; border-radius: 50%; background-color: #696cff; color: white; font-size: 3rem; font-weight: 600;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    </div>
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary">{{ $role->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Quick Stats Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total Permissions</span>
                        <span class="badge bg-primary">{{ $user->roles->sum(function($role) { return $role->permissions->count(); }) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Account Age</span>
                        <span class="badge bg-info">{{ $user->created_at->diffForHumans(null, true) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Last Login</span>
                        <span class="badge bg-secondary">Today</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

