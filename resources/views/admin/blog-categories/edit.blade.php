@extends('layouts.admin')
@section('title', isset($blogCategory) ? 'Edit Blog Category' : 'Create Blog Category')
@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="mb-1">{{ isset($blogCategory) ? 'Edit' : 'Create' }} Blog Category</h4>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ isset($blogCategory) ? route('admin.blog-categories.update', $blogCategory) : route('admin.blog-categories.store') }}" method="POST">
                @csrf
                @if(isset($blogCategory)) @method('PUT') @endif
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $blogCategory->name ?? '') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label">Slug *</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" value="{{ old('slug', $blogCategory->slug ?? '') }}" required>
                        @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description', $blogCategory->description ?? '') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                               value="1" {{ old('is_active', $blogCategory->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>{{ isset($blogCategory) ? 'Update' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
