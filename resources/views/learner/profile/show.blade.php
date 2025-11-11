@extends('layouts.learner')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">My Profile</h2>
                    <p class="text-muted mb-0">View and manage your account information</p>
                </div>
                <a href="{{ route('learner.profile.edit') }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>Edit Profile
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Information Card -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person me-2"></i>Profile Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Full Name</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $learner->name }}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Email Address</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $learner->email }}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Account Status</strong>
                        </div>
                        <div class="col-sm-8">
                            @if($learner->status === 'active')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Active
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle me-1"></i>Disabled
                                </span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Member Since</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $learner->created_at->format('F j, Y') }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Last Updated</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $learner->updated_at->format('F j, Y g:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Avatar and Quick Stats -->
        <div class="col-lg-4">
            <!-- Avatar Card -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div style="width: 120px; height: 120px; border-radius: 50%; background-color: #696cff; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 3rem; font-weight: 600;">
                        {{ strtoupper(substr($learner->name, 0, 2)) }}
                    </div>
                    <h5 class="mb-1">{{ $learner->name }}</h5>
                    <p class="text-muted mb-3">{{ $learner->email }}</p>
                    <span class="badge bg-success">Learner</span>
                </div>
            </div>

            <!-- Quick Stats Card -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>Quick Stats</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Account Age</span>
                        <span class="badge bg-info">{{ $learner->created_at->diffForHumans(null, true) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Certifications</span>
                        <span class="badge bg-primary">0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Practice Sessions</span>
                        <span class="badge bg-success">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

