@extends('layouts.admin')

@section('title', 'Create Help Category')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.help-categories.index') }}">Help Categories</a></li>
                <li class="breadcrumb-item active">Create Category</li>
            </ol>
        </nav>
        <h4 class="mb-1">Create Help Category</h4>
        <p class="text-muted mb-0">Add a new category to organize help articles</p>
    </div>

    <!-- Create Form Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Category Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.help-categories.store') }}" method="POST">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Category Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
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
                                Slug <small class="text-muted">(Optional - auto-generated if empty)</small>
                            </label>
                            <input type="text" 
                                   class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug') }}"
                                   placeholder="e.g., getting-started">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                URL-friendly version of the name. Leave empty to auto-generate.
                            </small>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Brief description of what this category covers...">{{ old('description') }}</textarea>
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
                                    <i class="bi" id="icon-preview"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('icon') is-invalid @enderror" 
                                       id="icon" 
                                       name="icon" 
                                       value="{{ old('icon') }}"
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
                                   value="{{ old('order', 0) }}"
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
                                <i class="bi bi-check-circle me-2"></i>Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Help Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="card-title mb-0"><i class="bi bi-lightbulb me-2"></i>Tips</h6>
                </div>
                <div class="card-body">
                    <h6>Category Best Practices</h6>
                    <ul class="small">
                        <li>Use clear, descriptive names</li>
                        <li>Keep categories broad but focused</li>
                        <li>Aim for 4-8 main categories</li>
                        <li>Choose relevant icons for visual recognition</li>
                        <li>Order categories by importance or usage frequency</li>
                    </ul>

                    <hr>

                    <h6>Common Category Examples</h6>
                    <ul class="small mb-0">
                        <li><strong>Getting Started</strong> - Onboarding and basics</li>
                        <li><strong>Account & Billing</strong> - Account management</li>
                        <li><strong>Features</strong> - Product features and usage</li>
                        <li><strong>Technical Support</strong> - Troubleshooting</li>
                        <li><strong>Privacy & Security</strong> - Data and security</li>
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

// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function(e) {
    const slugInput = document.getElementById('slug');
    if (!slugInput.value || slugInput.dataset.autoGenerated) {
        const slug = e.target.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        slugInput.value = slug;
        slugInput.dataset.autoGenerated = 'true';
    }
});

// Mark slug as manually edited
document.getElementById('slug').addEventListener('input', function(e) {
    if (e.target.value) {
        delete e.target.dataset.autoGenerated;
    }
});
</script>
@endpush
@endsection
