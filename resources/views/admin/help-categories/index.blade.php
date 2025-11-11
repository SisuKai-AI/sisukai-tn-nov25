@extends('layouts.admin')

@section('title', 'Help Categories Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Help Categories Management</h4>
            <p class="text-muted mb-0">Organize help articles into categories</p>
        </div>
        <a href="{{ route('admin.help-categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Category
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

    <!-- Categories Table Card -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Help Categories ({{ $categories->total() }})</h5>
        </div>
        <div class="card-body p-0">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">Order</th>
                                <th style="width: 5%;">Icon</th>
                                <th style="width: 20%;">Name</th>
                                <th style="width: 15%;">Slug</th>
                                <th style="width: 30%;">Description</th>
                                <th style="width: 10%;" class="text-center">Articles</th>
                                <th style="width: 15%;" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary">{{ $category->order ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <i class="bi {{ $category->icon ?? 'bi-folder' }} fs-5"></i>
                                    </td>
                                    <td>
                                        <strong>{{ $category->name }}</strong>
                                    </td>
                                    <td>
                                        <code class="small">{{ $category->slug }}</code>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit($category->description, 80) }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $category->articles_count }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.help-categories.edit', $category) }}" 
                                               class="btn btn-outline-primary" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.help-categories.destroy', $category) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this category? This will also delete all articles in this category.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-outline-danger" 
                                                        title="Delete"
                                                        {{ $category->articles_count > 0 ? 'disabled' : '' }}>
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-folder-x display-1 text-muted"></i>
                    <p class="text-muted mt-3">No help categories found.</p>
                    <a href="{{ route('admin.help-categories.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Create Your First Category
                    </a>
                </div>
            @endif
        </div>
        @if($categories->hasPages())
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-center">
                    {{ $categories->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Info Alert -->
    <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Note:</strong> Categories with articles cannot be deleted. Please move or delete all articles first.
    </div>
</div>
@endsection
