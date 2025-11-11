@extends('layouts.admin')

@section('title', 'Learner Management')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Learners</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Learner Management</h4>
            <p class="text-muted mb-0">Manage learner accounts and activity</p>
        </div>
        <a href="{{ route('admin.learners.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Learner
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.learners.index') }}">
                <div class="row g-3">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i>Filter
                        </button>
                    </div>
                </div>
                @if(request('search'))
                <div class="mt-3">
                    <a href="{{ route('admin.learners.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i>Clear Filters
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Learners Table -->
    <div class="card">
        <div class="card-body" style="overflow: visible;">
            @if($learners->count() > 0)
            <div class="table-responsive" style="overflow: visible;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($learners as $learner)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                            {{ strtoupper(substr($learner->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="fw-medium">{{ $learner->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $learner->email }}</td>
                            <td>
                                @if($learner->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Disabled</span>
                                @endif
                            </td>
                            <td>{{ $learner->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.learners.show', $learner) }}">
                                                <i class="bi bi-eye me-2"></i>View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.learners.edit', $learner) }}">
                                                <i class="bi bi-pencil me-2"></i>Edit
                                            </a>
                                        </li>
                                        @php
                                            $canDisable = auth()->user()->hasPermission('learners.disable');
                                            $canEnable = auth()->user()->hasPermission('learners.enable');
                                            $canToggle = ($learner->status === 'active' && $canDisable) || ($learner->status === 'disabled' && $canEnable);
                                        @endphp
                                        @if($canToggle)
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button type="button" class="dropdown-item text-warning" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#toggleStatusModal" 
                                                    data-learner-id="{{ $learner->id }}" 
                                                    data-learner-name="{{ $learner->name }}"
                                                    data-learner-status="{{ $learner->status }}">
                                                <i class="bi bi-{{ $learner->status === 'active' ? 'x-circle' : 'check-circle' }} me-2"></i>{{ $learner->status === 'active' ? 'Disable' : 'Enable' }} Account
                                            </button>
                                        </li>
                                        @endif
                                        <li>
                                            <button type="button" class="dropdown-item text-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteLearnerModal" 
                                                    data-learner-id="{{ $learner->id }}" 
                                                    data-learner-name="{{ $learner->name }}">
                                                <i class="bi bi-trash me-2"></i>Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($learners->hasPages())
                <div class="mt-4">
                    {{ $learners->links() }}
                </div>
            @endif
            @else
            <div class="text-center py-5">
                <i class="bi bi-people" style="font-size: 3rem; color: #ddd;"></i>
                <p class="text-muted mt-3">
                    @if(request('search'))
                        No learners found matching your search.
                    @else
                        No learners yet. Add your first learner to get started!
                    @endif
                </p>
                @if(!request('search'))
                <a href="{{ route('admin.learners.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle me-2"></i>Add New Learner
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Toggle Status Confirmation Modal -->
<div class="modal fade" id="toggleStatusModal" tabindex="-1" aria-labelledby="toggleStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="toggleStatusModalLabel">
                    <i class="bi bi-exclamation-circle text-warning me-2"></i>Confirm Action
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0" id="toggleStatusMessage"></p>
                <p class="text-muted small mt-2 mb-0" id="toggleStatusDescription"></p>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </button>
                <form id="toggleStatusForm" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning" id="toggleStatusButton">
                        <i class="bi bi-check-circle me-1"></i>Confirm
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteLearnerModal" tabindex="-1" aria-labelledby="deleteLearnerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="deleteLearnerModalLabel">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete <strong id="learnerName"></strong>?</p>
                <p class="text-muted small mt-2 mb-0">This action cannot be undone. All learner data, progress, and activity will be permanently deleted.</p>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </button>
                <form id="deleteLearnerForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Delete Learner
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Status Modal
    const toggleStatusModal = document.getElementById('toggleStatusModal');
    toggleStatusModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const learnerId = button.getAttribute('data-learner-id');
        const learnerName = button.getAttribute('data-learner-name');
        const learnerStatus = button.getAttribute('data-learner-status');
        
        const modalMessage = toggleStatusModal.querySelector('#toggleStatusMessage');
        const modalDescription = toggleStatusModal.querySelector('#toggleStatusDescription');
        const toggleForm = toggleStatusModal.querySelector('#toggleStatusForm');
        const toggleButton = toggleStatusModal.querySelector('#toggleStatusButton');
        
        if (learnerStatus === 'active') {
            modalMessage.innerHTML = 'Are you sure you want to <strong>disable</strong> the account for <strong>' + learnerName + '</strong>?';
            modalDescription.textContent = 'The learner will not be able to log in or access their account until it is re-enabled.';
            toggleButton.innerHTML = '<i class="bi bi-x-circle me-1"></i>Disable Account';
        } else {
            modalMessage.innerHTML = 'Are you sure you want to <strong>enable</strong> the account for <strong>' + learnerName + '</strong>?';
            modalDescription.textContent = 'The learner will be able to log in and access their account again.';
            toggleButton.innerHTML = '<i class="bi bi-check-circle me-1"></i>Enable Account';
        }
        
        toggleForm.action = '/admin/learners/' + learnerId + '/toggle-status';
    });
    
    // Delete Modal
    const deleteModal = document.getElementById('deleteLearnerModal');
    deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const learnerId = button.getAttribute('data-learner-id');
        const learnerName = button.getAttribute('data-learner-name');
        
        const modalLearnerName = deleteModal.querySelector('#learnerName');
        const deleteForm = deleteModal.querySelector('#deleteLearnerForm');
        
        modalLearnerName.textContent = learnerName;
        deleteForm.action = '/admin/learners/' + learnerId;
    });
});
</script>
@endsection
