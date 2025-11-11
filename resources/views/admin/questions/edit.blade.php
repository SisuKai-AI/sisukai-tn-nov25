@extends('layouts.admin')

@section('title', 'Edit Question')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit Question</h4>
            <p class="text-muted mb-0">Update question details and answers</p>
        </div>
        <a href="{{ route('admin.questions.show', $question) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Question
        </a>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.questions.update', $question) }}" method="POST" id="questionForm">
                @csrf
                @method('PUT')

                <!-- Topic Selection -->
                <div class="mb-3">
                    <label for="certification_select" class="form-label">Certification <span class="text-danger">*</span></label>
                    <select class="form-select" id="certification_select">
                        <option value="">Select Certification</option>
                        @foreach($certifications as $cert)
                            <option value="{{ $cert->id }}" {{ $cert->id == $question->topic->domain->certification_id ? 'selected' : '' }}>
                                {{ $cert->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" id="topic_container">
                    <label for="topic_id" class="form-label">Topic <span class="text-danger">*</span></label>
                    <select class="form-select @error('topic_id') is-invalid @enderror" id="topic_id" name="topic_id" required>
                        <option value="">Select Topic</option>
                    </select>
                    @error('topic_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                <!-- Question Text -->
                <div class="mb-3">
                    <label for="question_text" class="form-label">Question Text <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('question_text') is-invalid @enderror" 
                              id="question_text" name="question_text" rows="4" required>{{ old('question_text', $question->question_text) }}</textarea>
                    @error('question_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Difficulty and Status -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="difficulty" class="form-label">Difficulty <span class="text-danger">*</span></label>
                        <select class="form-select @error('difficulty') is-invalid @enderror" id="difficulty" name="difficulty" required>
                            <option value="easy" {{ old('difficulty', $question->difficulty) == 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty', $question->difficulty) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ old('difficulty', $question->difficulty) == 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                        @error('difficulty')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="draft" {{ old('status', $question->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="pending_review" {{ old('status', $question->status) == 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                            <option value="approved" {{ old('status', $question->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Explanation -->
                <div class="mb-3">
                    <label for="explanation" class="form-label">Explanation (Optional)</label>
                    <textarea class="form-control @error('explanation') is-invalid @enderror" 
                              id="explanation" name="explanation" rows="3">{{ old('explanation', $question->explanation) }}</textarea>
                    <small class="text-muted">Provide an explanation for the correct answer</small>
                    @error('explanation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                <!-- Answers Section -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Answer Options</h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="addAnswerBtn">
                            <i class="bi bi-plus-circle me-1"></i>Add Answer
                        </button>
                    </div>

                    <div id="answersContainer">
                        <!-- Existing answers will be loaded here -->
                    </div>

                    @error('answers')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.questions.show', $question) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Update Question
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let answerCount = 0;
const certificationsData = @json($certifications);
const question = @json($question);
const existingAnswers = @json($question->answers);

// Initialize form
document.addEventListener('DOMContentLoaded', function() {
    // Load existing answers
    if (existingAnswers && existingAnswers.length > 0) {
        existingAnswers.forEach((answer, index) => {
            addAnswer(answer.answer_text, answer.is_correct);
        });
    } else {
        // Add default 4 answers if none exist
        for (let i = 0; i < 4; i++) {
            addAnswer();
        }
    }
    
    // Pre-populate topic dropdown
    const certSelect = document.getElementById('certification_select');
    const topicSelect = document.getElementById('topic_id');
    const certId = certSelect.value;
    
    if (certId) {
        const cert = certificationsData.find(c => c.id == certId);
        if (cert && cert.domains) {
            topicSelect.innerHTML = '<option value="">Select Topic</option>';
            cert.domains.forEach(domain => {
                if (domain.topics) {
                    domain.topics.forEach(topic => {
                        const option = document.createElement('option');
                        option.value = topic.id;
                        option.textContent = `${domain.name} > ${topic.name}`;
                        if (topic.id == question.topic_id) {
                            option.selected = true;
                        }
                        topicSelect.appendChild(option);
                    });
                }
            });
        }
    }
});

// Certification change handler
document.getElementById('certification_select').addEventListener('change', function() {
    const certId = this.value;
    const topicSelect = document.getElementById('topic_id');
    const topicContainer = document.getElementById('topic_container');
    
    topicSelect.innerHTML = '<option value="">Select Topic</option>';
    
    if (certId) {
        const cert = certificationsData.find(c => c.id == certId);
        if (cert && cert.domains) {
            cert.domains.forEach(domain => {
                if (domain.topics) {
                    domain.topics.forEach(topic => {
                        const option = document.createElement('option');
                        option.value = topic.id;
                        option.textContent = `${domain.name} > ${topic.name}`;
                        topicSelect.appendChild(option);
                    });
                }
            });
        }
        topicContainer.style.display = 'block';
    } else {
        topicContainer.style.display = 'none';
    }
});

// Add answer button
document.getElementById('addAnswerBtn').addEventListener('click', function() {
    if (answerCount < 6) {
        addAnswer();
    } else {
        alert('Maximum 6 answers allowed');
    }
});

function addAnswer(answerText = '', isCorrect = false) {
    const container = document.getElementById('answersContainer');
    const answerDiv = document.createElement('div');
    answerDiv.className = 'card mb-2 answer-item';
    answerDiv.innerHTML = `
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="answers[${answerCount}][answer_text]" 
                           placeholder="Answer option ${answerCount + 1}" value="${answerText}" required>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input correct-answer-radio" type="radio" 
                               name="correct_answer" value="${answerCount}" 
                               ${isCorrect ? 'checked' : ''}
                               onchange="updateCorrectAnswers(${answerCount})">
                        <label class="form-check-label">Correct Answer</label>
                    </div>
                    <input type="hidden" name="answers[${answerCount}][is_correct]" value="${isCorrect ? '1' : '0'}" class="is-correct-input">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeAnswer(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.appendChild(answerDiv);
    answerCount++;
}

function removeAnswer(btn) {
    if (document.querySelectorAll('.answer-item').length > 2) {
        btn.closest('.answer-item').remove();
    } else {
        alert('Minimum 2 answers required');
    }
}

function updateCorrectAnswers(selectedIndex) {
    // Reset all to false
    document.querySelectorAll('.is-correct-input').forEach(input => {
        input.value = '0';
    });
    // Set selected to true
    const inputs = document.querySelectorAll('.is-correct-input');
    if (inputs[selectedIndex]) {
        inputs[selectedIndex].value = '1';
    }
}
</script>
@endsection

