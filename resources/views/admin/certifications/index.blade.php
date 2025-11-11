@extends('layouts.admin')

@section('title', 'Certifications Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Certifications Management</h4>
            <p class="text-muted mb-0">Manage certification exams and their content</p>
        </div>
        <a href="{{ route('admin.certifications.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Certification
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search and Filter Card -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.certifications.index') }}" class="row g-3">
                <!-- Search -->
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Search by name, provider, or description..." 
                           value="{{ request('search') }}">
                </div>

                <!-- Provider Filter -->
                <div class="col-md-3">
                    <label for="provider" class="form-label">Provider</label>
                    <select class="form-select" id="provider" name="provider">
                        <option value="">All Providers</option>
                        @foreach($providers as $provider)
                            <option value="{{ $provider }}" {{ request('provider') == $provider ? 'selected' : '' }}>
                                {{ $provider }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Sort By -->
                <div class="col-md-2">
                    <label for="sort_by" class="form-label">Sort By</label>
                    <select class="form-select" id="sort_by" name="sort_by">
                        <option value="created_at" {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Date Created</option>
                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="provider" {{ request('sort_by') == 'provider' ? 'selected' : '' }}>Provider</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i>
                    </button>
                </div>
            </form>
            
            @if(request()->hasAny(['search', 'provider', 'status', 'sort_by']))
                <div class="mt-3">
                    <a href="{{ route('admin.certifications.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i>Clear Filters
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Certifications Table Card -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Certification</th>
                            <th>Provider</th>
                            <th>Domains</th>
                            <th>Questions</th>
                            <th>Attempts</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($certifications as $certification)
                            <tr>
                                <td>
                                    <div>
                                        <span class="fw-medium">{{ $certification->name }}</span>
                                        <br>
                                        <small class="text-muted">{{ $certification->slug }}</small>
                                    </div>
                                </td>
                                <td>{{ $certification->provider }}</td>
                                <td>
                                    <span class="badge bg-info text-white">{{ $certification->domains_count }} domains</span>
                                </td>
                                <td>{{ $certification->exam_question_count }} questions</td>
                                <td>{{ $certification->exam_attempts_count }} attempts</td>
                                <td>
                                    @if($certification->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.certifications.show', $certification) }}">
                                                    <i class="bi bi-eye me-2"></i>View Details
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.certifications.edit', $certification) }}">
                                                    <i class="bi bi-pencil me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.certifications.domains.index', $certification) }}">
                                                    <i class="bi bi-folder me-2"></i>Manage Domains
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.certifications.toggleStatus', $certification) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bi bi-{{ $certification->is_active ? 'pause' : 'play' }}-circle me-2"></i>
                                                        {{ $certification->is_active ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.certifications.destroy', $certification) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this certification?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="bi bi-award" style="font-size: 3rem; color: #ccc;"></i>
                                        <h6 class="mt-3">No certifications yet</h6>
                                        <p class="text-muted">Start by adding your first certification</p>
                                        <a href="{{ route('admin.certifications.create') }}" class="btn btn-primary mt-2">
                                            <i class="bi bi-plus-circle me-2"></i>Add Certification
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($certifications->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $certifications->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

