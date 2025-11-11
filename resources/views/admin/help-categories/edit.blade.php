@extends('layouts.admin')

@section('title', 'Edit Help Category')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.help-categories.index') }}">Help Categories</a></li>
                <li class="breadcrumb-item active">Edit Category</li>
            </ol>
        </nav>
        <h4 class="mb-1">Edit Help Category</h4>
        <p class="text-muted mb-0">Update category information</p>
    </div>

    <!-- Edit Form Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Category Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.help-categories.update', $helpCategory) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Category Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $helpCategory->name) }}" 
                                   required
                                   placeholder="e.g., Getting Started">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                A descriptive name for the category (e.g., "Getting Started", "Account & Billing")
                            </small>
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">
                                Slug <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug', $helpCategory->slug) }}"
                                   required
                                   placeholder="e.g., getting-started">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                URL-friendly version of the name. Changing this will break existing links.
                            </small>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Brief description of what this category covers...">{{ old('description', $helpCategory->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                A brief description to help users understand what this category contains.
                            </small>
                        </div>

                        <!-- Icon -->
                        <div class="mb-3">
                            <label for="icon" class="form-label">
                                Bootstrap Icon Class <small class="text-muted">(Optional)</small>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi {{ $helpCategory->icon }}" id="icon-preview"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('icon') is-invalid @enderror" 
                                       id="icon" 
                                       name="icon" 
                                       value="{{ old('icon', $helpCategory->icon) }}"
                                       placeholder="e.g., bi-person-plus">
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                Bootstrap Icons class name (e.g., "bi-person-plus", "bi-credit-card"). 
                                <a href="https://icons.getbootstrap.com/" target="_blank">Browse icons</a>
                            </small>
                        </div>

                        <!-- Order -->
                        <div class="mb-4">
                            <label for="order" class="form-label">
                                Display Order <small class="text-muted">(Optional)</small>
                            </label>
                            <input type="number" 
                                   class="form-control @error('order') is-invalid @enderror" 
                                   id="order" 
                                   name="order" 
                                   value="{{ old('order', $helpCategory->order ?? 0) }}"
                                   min="0"
                                   style="max-width: 150px;">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Lower numbers appear first. Default is 0.
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.help-categories.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h6 class="card-title mb-0"><i class="bi bi-info-circle me-2"></i>Category Info</h6>
                </div>
                <div class="card-body">
                    <dl class="row mb-0 small">
                        <dt class="col-sm-4">Articles:</dt>
                        <dd class="col-sm-8">{{ $helpCategory->articles()->count() }}</dd>
                        
                        <dt class="col-sm-4">Created:</dt>
                        <dd class="col-sm-8">{{ $helpCategory->created_at->format('M d, Y') }}</dd>
                        
                        <dt class="col-sm-4">Updated:</dt>
                        <dd class="col-sm-8">{{ $helpCategory->updated_at->format('M d, Y') }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="card-title mb-0"><i class="bi bi-lightbulb me-2"></i>Tips</h6>
                </div>
                <div class="card-body">
                    <h6>Editing Best Practices</h6>
                    <ul class="small mb-0">
                        <li>Avoid changing the slug unless necessary</li>
                        <li>Keep category names concise and clear</li>
                        <li>Update descriptions to reflect current content</li>
                        <li>Use consistent icon styles across categories</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Live icon preview
document.getElementById('icon').addEventListener('input', function(e) {
    const iconPreview = document.getElementById('icon-preview');
    const iconClass = e.target.value;
    
    // Remove all classes and add the new one
    iconPreview.className = 'bi';
    if (iconClass) {
        iconPreview.classList.add(iconClass);
    }
});

// Auto-generate slug from name (only if manually cleared)
document.getElementById('name').addEventListener('input', function(e) {
    const slugInput = document.getElementById('slug');
    if (!slugInput.value) {
        const slug = e.target.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        slugInput.value = slug;
    }
});
</script>
@endpush
@endsection
