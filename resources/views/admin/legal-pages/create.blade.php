@extends('layouts.admin')
@section('title', isset($legalPage) ? 'Edit Legal Page' : 'Create Legal Page')
@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="mb-1">{{ isset($legalPage) ? 'Edit' : 'Create' }} Legal Page</h4>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ isset($legalPage) ? route('admin.legal-pages.update', $legalPage) : route('admin.legal-pages.store') }}" method="POST">
                @csrf
                @if(isset($legalPage)) @method('PUT') @endif
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Title *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $legalPage->title ?? '') }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label">Slug *</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" value="{{ old('slug', $legalPage->slug ?? '') }}" required>
                        @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content *</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" 
                              id="content" name="content" rows="15" required>{{ old('content', $legalPage->content ?? '') }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Supports Markdown formatting</small>
                </div>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                               value="1" {{ old('is_active', $legalPage->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.legal-pages.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>{{ isset($legalPage) ? 'Update' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
