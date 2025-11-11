@extends('layouts.admin')

@section('title', 'Help Articles Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Help Articles Management</h4>
            <p class="text-muted mb-0">Manage help center articles and content</p>
        </div>
        <div>
            <a href="{{ route('admin.help-categories.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-folder me-2"></i>Manage Categories
            </a>
            <a href="{{ route('admin.help-articles.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Article
            </a>
        </div>
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

    <!-- Articles Table Card -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Help Articles ({{ $articles->total() }})</h5>
        </div>
        <div class="card-body p-0">
            @if($articles->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">Order</th>
                                <th style="width: 30%;">Title</th>
                                <th style="width: 15%;">Category</th>
                                <th style="width: 15%;">Slug</th>
                                <th style="width: 8%;" class="text-center">Featured</th>
                                <th style="width: 8%;" class="text-center">Views</th>
                                <th style="width: 12%;">Updated</th>
                                <th style="width: 7%;" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary">{{ $article->order ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-start">
                                            <div>
                                                <strong>{{ $article->title }}</strong>
                                                @if($article->is_featured)
                                                    <span class="badge bg-warning text-dark ms-2">
                                                        <i class="bi bi-star-fill"></i>
                                                    </span>
                                                @endif
                                                <br>
                                                <small class="text-muted">
                                                    {{ Str::limit(strip_tags($article->content), 80) }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($article->category)
                                            <span class="badge bg-primary">
                                                <i class="bi {{ $article->category->icon ?? 'bi-folder' }} me-1"></i>
                                                {{ $article->category->name }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Uncategorized</span>
                                        @endif
                                    </td>
                                    <td>
                                        <code class="small">{{ Str::limit($article->slug, 20) }}</code>
                                    </td>
                                    <td class="text-center">
                                        @if($article->is_featured)
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                        @else
                                            <i class="bi bi-circle text-muted"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ number_format($article->views) }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $article->updated_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('landing.help.article.show', $article->slug) }}" 
                                               class="btn btn-outline-info" 
                                               title="View"
                                               target="_blank">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.help-articles.edit', $article) }}" 
                                               class="btn btn-outline-primary" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.help-articles.destroy', $article) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this article?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-outline-danger" 
                                                        title="Delete">
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
                    <i class="bi bi-file-text-x display-1 text-muted"></i>
                    <p class="text-muted mt-3">No help articles found.</p>
                    <a href="{{ route('admin.help-articles.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Create Your First Article
                    </a>
                </div>
            @endif
        </div>
        @if($articles->hasPages())
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-center">
                    {{ $articles->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
