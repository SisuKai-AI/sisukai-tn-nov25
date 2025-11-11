@extends('layouts.admin')

@section('title', 'Edit Exam Session')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="h3 mb-0">Edit Exam Session</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.exam-sessions.index') }}">Exam Sessions</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.exam-sessions.show', $examSession) }}">{{ $examSession->id }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.exam-sessions.update', $examSession) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <h5 class="mb-3">Basic Information</h5>

                        <div class="mb-3">
                            <label for="learner_id" class="form-label">Learner <span class="text-danger">*</span></label>
                            <select name="learner_id" id="learner_id" class="form-select @error('learner_id') is-invalid @enderror" required>
                                <option value="">Select a learner...</option>
                                @foreach($learners as $learner)
                                    <option value="{{ $learner->id }}" {{ old('learner_id', $examSession->learner_id) == $learner->id ? 'selected' : '' }}>
                                        {{ $learner->name }} ({{ $learner->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('learner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="certification_id" class="form-label">Certification <span class="text-danger">*</span></label>
                            <select name="certification_id" id="certification_id" class="form-select @error('certification_id') is-invalid @enderror" required>
                                <option value="">Select a certification...</option>
                                @foreach($certifications as $cert)
                                    <option value="{{ $cert->id }}" {{ old('certification_id', $examSession->certification_id) == $cert->id ? 'selected' : '' }}>
                                        {{ $cert->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('certification_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Exam Type <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exam_type" id="type_benchmark" value="benchmark" {{ old('exam_type', $examSession->exam_type) == 'benchmark' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_benchmark">
                                            <strong>Benchmark</strong>
                                            <br>
                                            <small class="text-muted">Assess baseline knowledge</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exam_type" id="type_practice" value="practice" {{ old('exam_type', $examSession->exam_type) == 'practice' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_practice">
                                            <strong>Practice</strong>
                                            <br>
                                            <small class="text-muted">Improve weak areas</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exam_type" id="type_final" value="final" {{ old('exam_type', $examSession->exam_type) == 'final' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_final">
                                            <strong>Final</strong>
                                            <br>
                                            <small class="text-muted">Simulate real exam</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('exam_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Configuration -->
                        <h5 class="mb-3">Configuration</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="total_questions" class="form-label">Total Questions <span class="text-danger">*</span></label>
                                <input type="number" name="total_questions" id="total_questions" class="form-control @error('total_questions') is-invalid @enderror" 
                                       value="{{ old('total_questions', $examSession->total_questions) }}" min="5" max="200" required>
                                <small class="text-muted">Number of questions in the exam (5-200)</small>
                                @error('total_questions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="passing_score" class="form-label">Passing Score (%) <span class="text-danger">*</span></label>
                                <input type="number" name="passing_score" id="passing_score" class="form-control @error('passing_score') is-invalid @enderror" 
                                       value="{{ old('passing_score', $examSession->passing_score) }}" min="0" max="100" required>
                                <small class="text-muted">Minimum score to pass (0-100)</small>
                                @error('passing_score')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="time_limit_minutes" class="form-label">Time Limit (minutes)</label>
                                <input type="number" name="time_limit_minutes" id="time_limit_minutes" class="form-control @error('time_limit_minutes') is-invalid @enderror" 
                                       value="{{ old('time_limit_minutes', $examSession->time_limit_minutes) }}" min="5" max="300">
                                <small class="text-muted">Leave empty for no time limit</small>
                                @error('time_limit_minutes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="difficulty_level" class="form-label">Difficulty Level</label>
                                <select name="difficulty_level" id="difficulty_level" class="form-select @error('difficulty_level') is-invalid @enderror">
                                    <option value="">Standard</option>
                                    <option value="easy" {{ old('difficulty_level', $examSession->difficulty_level) == 'easy' ? 'selected' : '' }}>Easy</option>
                                    <option value="medium" {{ old('difficulty_level', $examSession->difficulty_level) == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="hard" {{ old('difficulty_level', $examSession->difficulty_level) == 'hard' ? 'selected' : '' }}>Hard</option>
                                    <option value="mixed" {{ old('difficulty_level', $examSession->difficulty_level) == 'mixed' ? 'selected' : '' }}>Mixed</option>
                                </select>
                                <small class="text-muted">For practice exams only</small>
                                @error('difficulty_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="adaptive_mode" id="adaptive_mode" value="1" {{ old('adaptive_mode', $examSession->adaptive_mode) ? 'checked' : '' }}>
                                <label class="form-check-label" for="adaptive_mode">
                                    Enable Adaptive Mode
                                    <br>
                                    <small class="text-muted">Adjust difficulty based on learner performance</small>
                                </label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.exam-sessions.show', $examSession) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Exam Session
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar with Help -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle me-2"></i>Exam Type Guide
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-info">Benchmark Exam</h6>
                        <p class="small text-muted mb-0">
                            Determines learner's baseline knowledge and identifies weak areas. Covers all domains evenly with mixed difficulty.
                        </p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h6 class="text-warning">Practice Exam</h6>
                        <p class="small text-muted mb-0">
                            Helps learners improve on specific domains or topics. Can be customized with difficulty levels and adaptive mode.
                        </p>
                    </div>
                    <hr>
                    <div class="mb-0">
                        <h6 class="text-primary">Final Exam</h6>
                        <p class="small text-muted mb-0">
                            Simulates actual certification exam conditions with strict time limits and passing requirements.
                        </p>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-warning bg-opacity-10">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle text-warning me-2"></i>Note
                    </h5>
                </div>
                <div class="card-body">
                    <p class="small mb-0">
                        You can only edit exam sessions that haven't been started yet. Once a learner begins the exam, the configuration is locked.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

