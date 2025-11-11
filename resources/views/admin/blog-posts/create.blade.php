@extends('layouts.admin')
@section('title', isset($blogPost) ? 'Edit Blog Post' : 'Create Blog Post')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="mb-1">{{ isset($blogPost) ? 'Edit' : 'Create' }} Blog Post</h4>
    </div>
    
    <div class="row">
        <!-- Editor Column -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($blogPost) ? route('admin.blog-posts.update', $blogPost) : route('admin.blog-posts.store') }}" 
                          method="POST" id="blogPostForm">
                        @csrf
                        @if(isset($blogPost)) @method('PUT') @endif
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $blogPost->title ?? '') }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="slug" class="form-label">Slug *</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                       id="slug" name="slug" value="{{ old('slug', $blogPost->slug ?? '') }}" required>
                                @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ old('category_id', $blogPost->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                      id="excerpt" name="excerpt" rows="2">{{ old('excerpt', $blogPost->excerpt ?? '') }}</textarea>
                            @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <!-- Editor Toggle -->
                        <div class="mb-3">
                            <label class="form-label">Editor Mode</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="editor_mode" id="editor_wysiwyg" value="wysiwyg" checked>
                                <label class="btn btn-outline-primary" for="editor_wysiwyg">
                                    <i class="bi bi-file-richtext me-1"></i>WYSIWYG (TinyMCE)
                                </label>
                                
                                <input type="radio" class="btn-check" name="editor_mode" id="editor_markdown" value="markdown">
                                <label class="btn btn-outline-primary" for="editor_markdown">
                                    <i class="bi bi-markdown me-1"></i>Markdown (SimpleMDE)
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Content *</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="15" required>{{ old('content', $blogPost->content ?? '') }}</textarea>
                            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="featured_image" class="form-label">Featured Image URL</label>
                            <input type="text" class="form-control @error('featured_image') is-invalid @enderror" 
                                   id="featured_image" name="featured_image" 
                                   value="{{ old('featured_image', $blogPost->featured_image ?? '') }}">
                            @error('featured_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                          id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $blogPost->meta_description ?? '') }}</textarea>
                                @error('meta_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <textarea class="form-control @error('meta_keywords') is-invalid @enderror" 
                                          id="meta_keywords" name="meta_keywords" rows="2">{{ old('meta_keywords', $blogPost->meta_keywords ?? '') }}</textarea>
                                @error('meta_keywords') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="draft" {{ old('status', $blogPost->status ?? 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $blogPost->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ old('status', $blogPost->status ?? '') == 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="published_at" class="form-label">Publish Date</label>
                                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                       id="published_at" name="published_at" 
                                       value="{{ old('published_at', isset($blogPost) && $blogPost->published_at ? $blogPost->published_at->format('Y-m-d\TH:i') : '') }}">
                                @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>{{ isset($blogPost) ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Preview Column -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 1rem;">
                <div class="card-header">
                    <h5 class="mb-0">Live Preview</h5>
                </div>
                <div class="card-body" id="preview-content" style="max-height: 600px; overflow-y: auto;">
                    <p class="text-muted">Start typing to see preview...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<style>
.blog-content {
    font-size: 1rem;
    line-height: 1.6;
}
.blog-content h1 { font-size: 2rem; margin-top: 1.5rem; margin-bottom: 1rem; font-weight: 600; }
.blog-content h2 { font-size: 1.75rem; margin-top: 1.5rem; margin-bottom: 0.75rem; font-weight: 600; }
.blog-content h3 { font-size: 1.5rem; margin-top: 1.25rem; margin-bottom: 0.75rem; font-weight: 600; }
.blog-content p { margin-bottom: 1rem; }
.blog-content img { max-width: 100%; height: auto; border-radius: 0.5rem; margin: 1rem 0; }
.blog-content ul, .blog-content ol { margin-bottom: 1rem; padding-left: 2rem; }
.blog-content li { margin-bottom: 0.5rem; }
.blog-content blockquote {
    border-left: 4px solid #696cff;
    padding-left: 1rem;
    margin: 1rem 0;
    font-style: italic;
    color: #6c757d;
}
.blog-content code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.9em;
}
.blog-content pre {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
}
.CodeMirror { height: 400px; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
let tinyMCEInstance = null;
let simpleMDEInstance = null;
let currentEditor = 'wysiwyg';

// Initialize TinyMCE
function initTinyMCE() {
    if (tinyMCEInstance) {
        return;
    }
    
    tinymce.init({
        selector: '#content',
        height: 400,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code preview',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }',
        setup: function(editor) {
            tinyMCEInstance = editor;
            editor.on('change keyup', function() {
                updatePreview(editor.getContent());
            });
        }
    });
}

// Initialize SimpleMDE
function initSimpleMDE() {
    if (simpleMDEInstance) {
        return;
    }
    
    simpleMDEInstance = new SimpleMDE({
        element: document.getElementById('content'),
        spellChecker: false,
        status: false,
        toolbar: ["bold", "italic", "heading", "|", "quote", "unordered-list", "ordered-list", "|", "link", "image", "|", "preview", "side-by-side", "fullscreen", "|", "guide"]
    });
    
    simpleMDEInstance.codemirror.on('change', function() {
        updatePreview(marked.parse(simpleMDEInstance.value()));
    });
}

// Update preview
function updatePreview(content) {
    const previewContent = document.getElementById('preview-content');
    if (content && content.trim() !== '') {
        previewContent.innerHTML = '<div class="blog-content">' + content + '</div>';
    } else {
        previewContent.innerHTML = '<p class="text-muted">Start typing to see preview...</p>';
    }
}

// Switch editors
function switchEditor(mode) {
    const textarea = document.getElementById('content');
    let currentContent = '';
    
    // Get current content
    if (currentEditor === 'wysiwyg' && tinyMCEInstance) {
        currentContent = tinyMCEInstance.getContent();
        tinymce.remove('#content');
        tinyMCEInstance = null;
    } else if (currentEditor === 'markdown' && simpleMDEInstance) {
        currentContent = simpleMDEInstance.value();
        simpleMDEInstance.toTextArea();
        simpleMDEInstance = null;
    } else {
        currentContent = textarea.value;
    }
    
    // Set content
    textarea.value = currentContent;
    
    // Initialize new editor
    currentEditor = mode;
    if (mode === 'wysiwyg') {
        initTinyMCE();
    } else {
        initSimpleMDE();
    }
}

// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const slug = this.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('slug').value = slug;
});

// Editor mode toggle
document.querySelectorAll('input[name="editor_mode"]').forEach(radio => {
    radio.addEventListener('change', function() {
        switchEditor(this.value);
    });
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initTinyMCE();
});
</script>
@endpush
