@extends('layouts.admin')

@section('title', 'Create Certification')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Create New Certification</h4>
            <p class="text-muted mb-0">Add a new certification exam to the platform</p>
        </div>
        <a href="{{ route('admin.certifications.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.certifications.store') }}" method="POST">
                        @csrf

                        <!-- Basic Information -->
                        <h5 class="mb-3">Basic Information</h5>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Certification Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug') }}" 
                                   placeholder="Leave blank to auto-generate">
                            <small class="text-muted">URL-friendly identifier (auto-generated if left blank)</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="provider" class="form-label">Provider <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('provider') is-invalid @enderror" 
                                   id="provider" name="provider" value="{{ old('provider') }}" 
                                   placeholder="e.g., AWS, CompTIA, Microsoft" required>
                            @error('provider')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
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
                                       value="{{ old('exam_question_count', 65) }}" min="1" required>
                                @error('exam_question_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="exam_duration_minutes" class="form-label">Duration (minutes) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('exam_duration_minutes') is-invalid @enderror" 
                                       id="exam_duration_minutes" name="exam_duration_minutes" 
                                       value="{{ old('exam_duration_minutes', 130) }}" min="1" required>
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
                                       value="{{ old('passing_score', 70) }}" min="0" max="100" required>
                                @error('passing_score')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price_single_cert" class="form-label">Price ($) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price_single_cert') is-invalid @enderror" 
                                       id="price_single_cert" name="price_single_cert" 
                                       value="{{ old('price_single_cert', 150.00) }}" step="0.01" min="0" required>
                                @error('price_single_cert')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active (available for learners)
                                </label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.certifications.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Create Certification
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Help Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-info-circle me-2"></i>Quick Guide
                    </h6>
                    <p class="small text-muted">
                        After creating the certification, you'll be able to:
                    </p>
                    <ul class="small text-muted">
                        <li>Add knowledge domains</li>
                        <li>Create topics within domains</li>
                        <li>Add questions to topics</li>
                        <li>Configure exam settings</li>
                    </ul>
                    <hr>
                    <h6 class="small fw-bold">Tips:</h6>
                    <ul class="small text-muted mb-0">
                        <li>Use a descriptive name</li>
                        <li>Set realistic passing scores</li>
                        <li>Consider exam duration carefully</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('blur', function() {
    const slugInput = document.getElementById('slug');
    if (!slugInput.value) {
        slugInput.value = this.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
});
</script>
@endsection

