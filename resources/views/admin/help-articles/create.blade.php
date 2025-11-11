@extends('layouts.admin')

@section('title', 'Create Help Article')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.help-articles.index') }}">Help Articles</a></li>
                <li class="breadcrumb-item active">Create Article</li>
            </ol>
        </nav>
        <h4 class="mb-1">Create Help Article</h4>
        <p class="text-muted mb-0">Add a new help article to assist users</p>
    </div>

    <!-- Create Form -->
    <form action="{{ route('admin.help-articles.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Article Content</h5>
                    </div>
                    <div class="card-body">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">
                                Article Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   required
                                   placeholder="e.g., How do I reset my password?">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content Editor -->
                        <div class="mb-3">
                            <label for="content" class="form-label">
                                Article Content <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" 
                                      name="content" 
                                      rows="20"
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Use the rich text editor to format your content. HTML is automatically sanitized for security.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Publish Card -->
                <div class="card mb-3">
                    <div class="card-header bg-white">
                        <h6 class="card-title mb-0">Publish</h6>
                    </div>
                    <div class="card-body">
                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" 
                                    name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Featured -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_featured" 
                                       name="is_featured"
                                       value="1"
                                       {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    <i class="bi bi-star me-1"></i>Featured Article
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                Featured articles appear on the help center homepage
                            </small>
                        </div>

                        <hr>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Publish Article
                            </button>
                            <a href="{{ route('admin.help-articles.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Settings Card -->
                <div class="card mb-3">
                    <div class="card-header bg-white">
                        <h6 class="card-title mb-0">Settings</h6>
                    </div>
                    <div class="card-body">
                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">
                                Slug <small class="text-muted">(Optional)</small>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-sm @error('slug') is-invalid @enderror" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug') }}"
                                   placeholder="auto-generated">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Leave empty to auto-generate from title
                            </small>
                        </div>

                        <!-- Order -->
                        <div class="mb-0">
                            <label for="order" class="form-label">
                                Display Order <small class="text-muted">(Optional)</small>
                            </label>
                            <input type="number" 
                                   class="form-control form-control-sm @error('order') is-invalid @enderror" 
                                   id="order" 
                                   name="order" 
                                   value="{{ old('order', 0) }}"
                                   min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Lower numbers appear first
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="card">
                    <div class="card-header bg-white">
                        <h6 class="card-title mb-0"><i class="bi bi-lightbulb me-2"></i>Writing Tips</h6>
                    </div>
                    <div class="card-body">
                        <ul class="small mb-0">
                            <li>Use clear, concise titles</li>
                            <li>Break content into sections with headings</li>
                            <li>Include step-by-step instructions</li>
                            <li>Add screenshots or images when helpful</li>
                            <li>Link to related articles</li>
                            <li>Keep language simple and friendly</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#content',
    height: 600,
    menubar: true,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | bold italic underline strikethrough | ' +
             'alignleft aligncenter alignright alignjustify | ' +
             'bullist numlist outdent indent | link image | ' +
             'forecolor backcolor | removeformat | code fullscreen',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 14px; }',
    branding: false,
    promotion: false,
    relative_urls: false,
    remove_script_host: false,
    convert_urls: true,
});

// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function(e) {
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
