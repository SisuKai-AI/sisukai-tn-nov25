@extends('layouts.admin')
@section('title', $blogPost->title)
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $blogPost->title }}</h4>
            <p class="text-muted mb-0">
                By {{ $blogPost->author_name }} | 
                {{ $blogPost->published_at?->format('M d, Y') ?? 'Not published' }}
            </p>
        </div>
        <a href="{{ route('admin.blog-posts.edit', $blogPost) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            @if($blogPost->excerpt)
                <div class="alert alert-info">
                    <strong>Excerpt:</strong> {{ $blogPost->excerpt }}
                </div>
            @endif
            <div class="prose">
                {!! nl2br(e($blogPost->content)) !!}
            </div>
        </div>
    </div>
</div>
@endsection
