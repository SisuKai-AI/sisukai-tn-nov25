@extends('layouts.admin')

@section('title', 'Edit Certification')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit Certification</h4>
            <p class="text-muted mb-0">Update certification details</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.certifications.show', $certification) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.certifications.update', $certification) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <h5 class="mb-3">Basic Information</h5>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Certification Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $certification->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug', $certification->slug) }}">
                            <small class="text-muted">URL-friendly identifier</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="provider" class="form-label">Provider <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('provider') is-invalid @enderror" 
                                   id="provider" name="provider" value="{{ old('provider', $certification->provider) }}" required>
                            @error('provider')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $certification->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Exam Configuration -->
                        <h5 class="mb-3">Exam Configuration</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="exam_question_count" class="form-label">Number of Questions <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('exam_question_count') is-invalid @enderror" 
                                       id="exam_question_count" name="exam_question_count" 
                                       value="{{ old('exam_question_count', $certification->exam_question_count) }}" min="1" required>
                                @error('exam_question_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="exam_duration_minutes" class="form-label">Duration (minutes) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('exam_duration_minutes') is-invalid @enderror" 
                                       id="exam_duration_minutes" name="exam_duration_minutes" 
                                       value="{{ old('exam_duration_minutes', $certification->exam_duration_minutes) }}" min="1" required>
                                @error('exam_duration_minutes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="passing_score" class="form-label">Passing Score (%) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('passing_score') is-invalid @enderror" 
                                       id="passing_score" name="passing_score" 
                                       value="{{ old('passing_score', $certification->passing_score) }}" min="0" max="100" required>
                                @error('passing_score')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price_single_cert" class="form-label">Price ($) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price_single_cert') is-invalid @enderror" 
                                       id="price_single_cert" name="price_single_cert" 
                                       value="{{ old('price_single_cert', $certification->price_single_cert) }}" step="0.01" min="0" required>
                                @error('price_single_cert')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', $certification->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active (available for learners)
                                </label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.certifications.show', $certification) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Certification
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Metadata Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-info-circle me-2"></i>Information
                    </h6>
                    <div class="mb-2">
                        <small class="text-muted">Created</small>
                        <div class="small">{{ $certification->created_at->format('M d, Y H:i') }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Last Updated</small>
                        <div class="small">{{ $certification->updated_at->format('M d, Y H:i') }}</div>
                    </div>
                    <hr>
                    <div class="mb-2">
                        <small class="text-muted">Domains</small>
                        <div class="small">{{ $certification->domains()->count() }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Exam Attempts</small>
                        <div class="small">{{ $certification->examAttempts()->count() }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Certificates Issued</small>
                        <div class="small">{{ $certification->certificates()->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

