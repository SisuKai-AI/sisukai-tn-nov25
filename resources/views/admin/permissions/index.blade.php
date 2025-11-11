@extends('layouts.admin')

@section('title', 'Permissions - SisuKai Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Permissions Management</h4>
            <p class="text-muted mb-0">View and manage system permissions</p>
        </div>
    </div>

    <!-- Search and Filter Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.permissions.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label">Search Permissions</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" 
                               class="form-control" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search by name or description...">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="category" class="form-label">Filter by Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                    @if(request('search') || request('category'))
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-label-secondary">
                            <i class="bi bi-x-circle me-1"></i>Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @foreach($permissions as $category => $categoryPermissions)
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-folder me-2"></i>{{ $category }}
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Permission</th>
                                <th style="width: 35%;">Description</th>
                                <th style="width: 15%;">Assigned Roles</th>
                                <th style="width: 15%;">Created</th>
                                <th style="width: 10%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categoryPermissions as $permission)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="permission-icon me-2">
                                                <i class="bi bi-key"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $permission->display_name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $permission->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $permission->description }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary">
                                            {{ $permission->roles_count }} {{ Str::plural('role', $permission->roles_count) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $permission->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.permissions.show', $permission) }}" 
                                           class="btn btn-sm btn-label-primary"
                                           title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

    @if($permissions->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-key" style="font-size: 3rem; color: #ddd;"></i>
                @if(request('search') || request('category'))
                    <p class="text-muted mt-3 mb-2">No permissions found matching your criteria</p>
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-sm btn-label-primary mt-2">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Clear Filters
                    </a>
                @else
                    <p class="text-muted mt-3 mb-0">No permissions found</p>
                @endif
            </div>
        </div>
    @endif
</div>

<style>
.permission-icon {
    width: 40px;
    height: 40px;
    border-radius: 0.375rem;
    background: rgba(105, 108, 255, 0.08);
    color: #696cff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
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

.bg-label-primary {
    background-color: rgba(105, 108, 255, 0.16) !important;
    color: #696cff !important;
}
</style>
@endsection

