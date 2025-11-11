@extends('layouts.admin')

@section('title', 'View Learner')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.learners.index') }}">Learners</a></li>
            <li class="breadcrumb-item active">View Learner</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Learner Details</h4>
            <p class="text-muted mb-0">View learner information and activity</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.learners.edit', $learner) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-2"></i>Edit Learner
            </a>
            <a href="{{ route('admin.learners.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <!-- Learner Information -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3" style="width: 80px; height: 80px;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: #696cff; color: white; font-size: 2rem; font-weight: 600;">
                                {{ strtoupper(substr($learner->name, 0, 2)) }}
                            </div>
                        </div>
                        <div>
                            <h4 class="mb-1">{{ $learner->name }}</h4>
                            <p class="text-muted mb-0">
                                <i class="bi bi-envelope me-2"></i>{{ $learner->email }}
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Learner ID</label>
                            <p class="fw-semibold">#{{ $learner->id }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">User Type</label>
                            <p><span class="badge" style="background-color: #696cff; color: white;">{{ ucfirst($learner->user_type) }}</span></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Account Status</label>
                            <p>
                                <span class="badge bg-{{ $learner->status === 'active' ? 'success' : 'danger' }}">
                                    <i class="bi bi-{{ $learner->status === 'active' ? 'check-circle' : 'x-circle' }} me-1"></i>{{ ucfirst($learner->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Joined Date</label>
                            <p class="fw-semibold">{{ $learner->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Last Updated</label>
                            <p class="fw-semibold">{{ $learner->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Section -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <i class="bi bi-activity" style="font-size: 3rem; color: #ddd;"></i>
                        <p class="text-muted mt-3">No activity recorded yet</p>
                        <small class="text-muted">Activity tracking coming soon</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning-charge me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.learners.edit', $learner) }}" class="btn btn-info">
                            <i class="bi bi-pencil me-2"></i>Edit Learner
                        </a>
                        @php
                            $canDisable = auth()->user()->hasPermission('learners.disable');
                            $canEnable = auth()->user()->hasPermission('learners.enable');
                            $canToggle = ($learner->status === 'active' && $canDisable) || ($learner->status === 'disabled' && $canEnable);
                        @endphp
                        @if($canToggle)
                        <button type="button" class="btn btn-{{ $learner->status === 'active' ? 'warning' : 'success' }} w-100" data-bs-toggle="modal" data-bs-target="#toggleStatusModal">
                            <i class="bi bi-{{ $learner->status === 'active' ? 'x-circle' : 'check-circle' }} me-2"></i>{{ $learner->status === 'active' ? 'Disable' : 'Enable' }} Account
                        </button>
                        @endif
                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteLearnerModal">
                            <i class="bi bi-trash me-2"></i>Delete Learner
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bar-chart me-2"></i>Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Member for</span>
                            <span class="fw-semibold">{{ $learner->created_at->diffForHumans(null, true) }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Certifications</span>
                            <span class="fw-semibold">0</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Practice Sessions</span>
                            <span class="fw-semibold">0</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Average Score</span>
                            <span class="fw-semibold">0%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toggle Status Modal -->
<div class="modal fade" id="toggleStatusModal" tabindex="-1" aria-labelledby="toggleStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="toggleStatusModalLabel">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>Confirm Action
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to <strong id="modalAction">{{ $learner->status === 'active' ? 'disable' : 'enable' }}</strong> the account for <strong>{{ $learner->name }}</strong>?</p>
                <p class="text-muted small mb-0" id="modalWarning">
                    @if($learner->status === 'active')
                        The learner will not be able to log in or access their account until it is re-enabled.
                    @else
                        The learner will be able to log in and access their account again.
                    @endif
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </button>
                <form id="toggleStatusForm" action="{{ route('admin.learners.toggleStatus', $learner) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-{{ $learner->status === 'active' ? 'warning' : 'success' }}">
                        <i class="bi bi-{{ $learner->status === 'active' ? 'x-circle' : 'check-circle' }} me-2"></i>{{ $learner->status === 'active' ? 'Disable' : 'Enable' }} Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Learner Modal -->
<div class="modal fade" id="deleteLearnerModal" tabindex="-1" aria-labelledby="deleteLearnerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLearnerModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to <strong class="text-danger">permanently delete</strong> <strong>{{ $learner->name }}</strong>?</p>
                <p class="text-muted small mb-0">
                    <i class="bi bi-exclamation-circle me-1"></i>This action cannot be undone. All learner data, progress, and history will be permanently removed.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </button>
                <form action="{{ route('admin.learners.destroy', $learner) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Delete Learner
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

