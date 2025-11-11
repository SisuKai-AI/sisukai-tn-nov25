@extends('layouts.admin')

@section('title', 'Edit Help Article')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.help-articles.index') }}">Help Articles</a></li>
                <li class="breadcrumb-item active">Edit Article</li>
            </ol>
        </nav>
        <h4 class="mb-1">Edit Help Article</h4>
        <p class="text-muted mb-0">Update article content and settings</p>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('admin.help-articles.update', $helpArticle) }}" method="POST">
        @csrf
        @method('PUT')
        
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
                                   value="{{ old('title', $helpArticle->title) }}" 
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
                                      required>{{ old('content', $helpArticle->content) }}</textarea>
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
                                            {{ old('category_id', $helpArticle->category_id) == $category->id ? 'selected' : '' }}>
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
                                       {{ old('is_featured', $helpArticle->is_featured) ? 'checked' : '' }}>
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
                                <i class="bi bi-check-circle me-2"></i>Update Article
                            </button>
                            <a href="{{ route('landing.help.article.show', $helpArticle->slug) }}" 
                               class="btn btn-outline-info"
                               target="_blank">
                                <i class="bi bi-eye me-2"></i>Preview Article
                            </a>
                            <a href="{{ route('admin.help-articles.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="card mb-3">
                    <div class="card-header bg-white">
                        <h6 class="card-title mb-0"><i class="bi bi-bar-chart me-2"></i>Statistics</h6>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0 small">
                            <dt class="col-sm-5">Views:</dt>
                            <dd class="col-sm-7">{{ number_format($helpArticle->views) }}</dd>
                            
                            <dt class="col-sm-5">Created:</dt>
                            <dd class="col-sm-7">{{ $helpArticle->created_at->format('M d, Y') }}</dd>
                            
                            <dt class="col-sm-5">Updated:</dt>
                            <dd class="col-sm-7">{{ $helpArticle->updated_at->format('M d, Y') }}</dd>
                            
                            <dt class="col-sm-5">Last Updated:</dt>
                            <dd class="col-sm-7">{{ $helpArticle->updated_at->diffForHumans() }}</dd>
                        </dl>
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
                                Slug <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-sm @error('slug') is-invalid @enderror" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug', $helpArticle->slug) }}"
                                   required>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                ⚠️ Changing this will break existing links
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
                                   value="{{ old('order', $helpArticle->order ?? 0) }}"
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
                        <h6 class="card-title mb-0"><i class="bi bi-lightbulb me-2"></i>Editing Tips</h6>
                    </div>
                    <div class="card-body">
                        <ul class="small mb-0">
                            <li>Keep content up-to-date</li>
                            <li>Review and update screenshots</li>
                            <li>Check for broken links</li>
                            <li>Update based on user feedback</li>
                            <li>Maintain consistent formatting</li>
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

// Auto-generate slug from title (only if manually cleared)
document.getElementById('title').addEventListener('input', function(e) {
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
