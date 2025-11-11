@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4>Welcome back, {{ auth()->user()->name }}! 🎉</h4>
            <p class="mb-0">Here's an overview of your platform's performance.</p>
        </div>
        <div class="col-md-4 d-none d-md-block text-end">
            <div class="welcome-illustration">
                👨‍💼
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card stats-card">
            <div class="card-body">
                <div class="stats-icon primary">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stats-title">Total Learners</div>
                <div class="stats-value">{{ $stats['total_learners'] }}</div>
                <div class="stats-change">
                    <i class="bi bi-dash"></i> No change
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card stats-card">
            <div class="card-body">
                <div class="stats-icon success">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="stats-title">Active Users</div>
                <div class="stats-value">{{ $stats['active_learners'] }}</div>
                <div class="stats-change">
                    <i class="bi bi-dash"></i> No change
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card stats-card">
            <div class="card-body">
                <div class="stats-icon warning">
                    <i class="bi bi-award"></i>
                </div>
                <div class="stats-title">Certifications</div>
                <div class="stats-value">{{ $stats['certifications'] }}</div>
                <div class="stats-change">
                    <i class="bi bi-dash"></i> No change
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card stats-card">
            <div class="card-body">
                <div class="stats-icon info">
                    <i class="bi bi-question-circle"></i>
                </div>
                <div class="stats-title">Questions</div>
                <div class="stats-value">{{ $stats['questions'] }}</div>
                <div class="stats-change">
                    <i class="bi bi-dash"></i> No change
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="row">
    <!-- Left Column -->
    <div class="col-lg-8">
        <!-- Recent Activity Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Activity</h5>
            </div>
            <div class="card-body">
                <div class="empty-state">
                    <i class="bi bi-clock-history"></i>
                    <h6>No recent activity to display</h6>
                    <p>System activities and user actions will appear here</p>
                </div>
            </div>
        </div>
        
        <!-- User Management Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">User Management</h5>
                <button class="btn btn-primary btn-sm" disabled>
                    <i class="bi bi-plus-circle me-1"></i> Add User
                </button>
            </div>
            <div class="card-body">
                <div class="empty-state">
                    <i class="bi bi-people"></i>
                    <h6>No users yet</h6>
                    <p>Start by adding admin users to manage the platform</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Column -->
    <div class="col-lg-4">
        <!-- Quick Actions Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary">
                        <i class="bi bi-person-plus me-2"></i> Add New User
                    </a>
                    <a href="{{ route('admin.learners.create') }}" class="btn btn-outline-success">
                        <i class="bi bi-person-badge me-2"></i> Add Learner
                    </a>
                    <button class="btn btn-outline-warning" disabled>
                        <i class="bi bi-award me-2"></i> Add Certification
                    </button>
                    <button class="btn btn-outline-info" disabled>
                        <i class="bi bi-question-circle me-2"></i> Add Question
                    </button>
                </div>
                <div class="alert alert-info mt-3 mb-0" style="font-size: 0.875rem;">
                    <i class="bi bi-info-circle me-2"></i> Add Certification and Add Question features will be implemented in future updates.
                </div>
            </div>
        </div>
        
        <!-- System Information Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">System Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Your Role:</small>
                    <span class="badge bg-danger">Super Admin</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">User Type:</small>
                    <span class="badge bg-primary">Admin</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Email:</small>
                    <span>{{ auth()->user()->email }}</span>
                </div>
                <div>
                    <small class="text-muted d-block mb-1">Last Login:</small>
                    <span>{{ now()->format('M d, Y h:i A') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Platform Stats Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Platform Statistics</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Total Users</span>
                    <strong>{{ $stats['total_users'] }}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Total Learners</span>
                    <strong>{{ $stats['total_learners'] }}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Certifications</span>
                    <strong>{{ $stats['certifications'] }}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Questions</span>
                    <strong>{{ $stats['questions'] }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
