@extends('layouts.admin')
@section('title', isset($testimonial) ? 'Edit Testimonial' : 'Create Testimonial')
@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="mb-1">{{ isset($testimonial) ? 'Edit' : 'Create' }} Testimonial</h4>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ isset($testimonial) ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" method="POST">
                @csrf
                @if(isset($testimonial)) @method('PUT') @endif
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="author_name" class="form-label">Author Name *</label>
                        <input type="text" class="form-control @error('author_name') is-invalid @enderror" 
                               id="author_name" name="author_name" value="{{ old('author_name', $testimonial->author_name ?? '') }}" required>
                        @error('author_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="author_title" class="form-label">Author Title *</label>
                        <input type="text" class="form-control @error('author_title') is-invalid @enderror" 
                               id="author_title" name="author_title" value="{{ old('author_title', $testimonial->author_title ?? '') }}" required>
                        @error('author_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="author_company" class="form-label">Company</label>
                        <input type="text" class="form-control @error('author_company') is-invalid @enderror" 
                               id="author_company" name="author_company" value="{{ old('author_company', $testimonial->author_company ?? '') }}">
                        @error('author_company') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="rating" class="form-label">Rating *</label>
                        <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('rating', $testimonial->rating ?? 5) == $i ? 'selected' : '' }}>{{ $i }} Stars</option>
                            @endfor
                        </select>
                        @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="sort_order" class="form-label">Sort Order *</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? '0') }}" required>
                        @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Testimonial Content *</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" 
                              id="content" name="content" rows="4" required>{{ old('content', $testimonial->content ?? '') }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" 
                               value="1" {{ old('is_featured', $testimonial->is_featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Featured</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                               value="1" {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>{{ isset($testimonial) ? 'Update' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
