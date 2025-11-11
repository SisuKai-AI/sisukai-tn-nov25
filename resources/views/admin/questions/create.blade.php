@extends('layouts.admin')

@section('title', 'Create Question')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Create New Question</h4>
            <p class="text-muted mb-0">Add a new exam question</p>
        </div>
        <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.questions.store') }}" method="POST" id="questionForm">
                @csrf

                <!-- Topic Selection -->
                <div class="mb-3">
                    <label for="certification_select" class="form-label">Certification <span class="text-danger">*</span></label>
                    <select class="form-select" id="certification_select">
                        <option value="">Select Certification</option>
                        @foreach($certifications as $cert)
                            <option value="{{ $cert->id }}">{{ $cert->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" id="topic_container" style="display: none;">
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
                              id="question_text" name="question_text" rows="4" required>{{ old('question_text') }}</textarea>
                    @error('question_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Difficulty and Status -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="difficulty" class="form-label">Difficulty <span class="text-danger">*</span></label>
                        <select class="form-select @error('difficulty') is-invalid @enderror" id="difficulty" name="difficulty" required>
                            <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                        @error('difficulty')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="pending_review" {{ old('status') == 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
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
                              id="explanation" name="explanation" rows="3">{{ old('explanation') }}</textarea>
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
                        <!-- Answer options will be added here dynamically -->
                    </div>

                    @error('answers')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Create Question
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let answerCount = 0;
const certificationsData = @json($certifications);
const selectedTopic = @json($selectedTopic);

// Add initial 4 answers
document.addEventListener('DOMContentLoaded', function() {
    for (let i = 0; i < 4; i++) {
        addAnswer();
    }
    
    // Pre-select topic if provided
    if (selectedTopic) {
        const certSelect = document.getElementById('certification_select');
        const topicSelect = document.getElementById('topic_id');
        const topicContainer = document.getElementById('topic_container');
        
        // Find and select the certification
        const cert = certificationsData.find(c => c.id == selectedTopic.domain.certification_id);
        if (cert) {
            certSelect.value = cert.id;
            
            // Populate topics
            topicSelect.innerHTML = '<option value="">Select Topic</option>';
            cert.domains.forEach(domain => {
                if (domain.topics) {
                    domain.topics.forEach(topic => {
                        const option = document.createElement('option');
                        option.value = topic.id;
                        option.textContent = `${domain.name} > ${topic.name}`;
                        if (topic.id == selectedTopic.id) {
                            option.selected = true;
                        }
                        topicSelect.appendChild(option);
                    });
                }
            });
            topicContainer.style.display = 'block';
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

function addAnswer() {
    const container = document.getElementById('answersContainer');
    const answerDiv = document.createElement('div');
    answerDiv.className = 'card mb-2 answer-item';
    answerDiv.innerHTML = `
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="answers[${answerCount}][answer_text]" 
                           placeholder="Answer option ${answerCount + 1}" required>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input correct-answer-radio" type="radio" 
                               name="correct_answer" value="${answerCount}" 
                               onchange="updateCorrectAnswers(${answerCount})">
                        <label class="form-check-label">Correct Answer</label>
                    </div>
                    <input type="hidden" name="answers[${answerCount}][is_correct]" value="0" class="is-correct-input">
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
    document.querySelector(`input[name="answers[${selectedIndex}][is_correct]"]`).value = '1';
}
</script>
@endsection

