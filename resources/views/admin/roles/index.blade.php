@extends('layouts.admin')

@section('title', 'Role Management - SisuKai Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Role Management</h4>
            <p class="text-muted mb-0">Manage admin roles and permissions</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Role
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

    <!-- Roles Grid -->
    <div class="row">
        @forelse($roles as $role)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="role-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.roles.show', $role) }}">
                                            <i class="bi bi-eye me-2"></i>View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.roles.edit', $role) }}">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a>
                                    </li>
                                    @if($role->users_count == 0)
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this role?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i>Delete
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        
                        <h5 class="card-title mb-2">{{ ucwords(str_replace('_', ' ', $role->name)) }}</h5>
                        <p class="card-text text-muted small mb-3">{{ $role->description }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-label-primary">
                                    <i class="bi bi-people me-1"></i>{{ $role->users_count }} {{ Str::plural('user', $role->users_count) }}
                                </span>
                            </div>
                            <div>
                                <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-sm btn-label-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-shield-x" style="font-size: 3rem; color: #ddd;"></i>
                        <p class="text-muted mt-3 mb-0">No roles found</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($roles->hasPages())
        <div class="mt-4">
            {{ $roles->links() }}
        </div>
    @endif
</div>

<style>
.role-icon {
    width: 48px;
    height: 48px;
    border-radius: 0.5rem;
    background: rgba(105, 108, 255, 0.16);
    color: #696cff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.btn-icon {
    padding: 0.375rem 0.5rem;
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

.card {
    box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
    border: none;
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px 0 rgba(67, 89, 113, 0.16);
}
</style>
@endsection

