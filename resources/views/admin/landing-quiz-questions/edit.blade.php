@extends('layouts.admin')

@section('title', 'Select Quiz Questions - ' . $certification->name)

@section('content')
<div class="container-fluid px-4">
    <div class="mb-4">
        <a href="{{ route('admin.landing-quiz-questions.index') }}" class="btn btn-sm btn-secondary mb-3">
            <i class="fas fa-arrow-left me-2"></i>Back to All Certifications
        </a>
        <h1 class="h3">Select Landing Page Quiz Questions</h1>
        <p class="text-muted">{{ $certification->name }} - {{ $certification->provider }}</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Currently Selected Questions -->
        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-check-circle me-2"></i>Selected Questions (<span id="selected-count">{{ $selectedQuestions->count() }}</span>/5)
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.landing-quiz-questions.update', $certification) }}" method="POST" id="quiz-form">
                        @csrf
                        @method('PUT')
                        
                        <div id="selected-questions-list" class="mb-3">
                            @if($selectedQuestions->count() > 0)
                                @foreach($selectedQuestions as $index => $mapping)
                                    <div class="selected-question-item mb-3 p-3 border rounded" data-question-id="{{ $mapping->question->id }}">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <span class="badge bg-secondary me-2">Q{{ $index + 1 }}</span>
                                                <strong>{{ Str::limit($mapping->question->question_text, 100) }}</strong>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-danger remove-question">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="question_ids[]" value="{{ $mapping->question->id }}">
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted text-center py-4" id="no-selection-message">
                                    <i class="fas fa-hand-pointer fa-2x mb-2"></i><br>
                                    No questions selected yet.<br>
                                    Click "Add" on questions from the right panel.
                                </p>
                            @endif
                        </div>

                        <div class="alert alert-info small">
                            <i class="fas fa-info-circle me-2"></i>
                            You must select exactly 5 questions. Questions will appear in the order listed above.
                        </div>

                        <button type="submit" class="btn btn-success w-100" id="save-btn" {{ $selectedQuestions->count() != 5 ? 'disabled' : '' }}>
                            <i class="fas fa-save me-2"></i>Save Quiz Questions
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Available Questions -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Available Questions ({{ $availableQuestions->count() }})
                    </h5>
                </div>
                <div class="card-body" style="max-height: 700px; overflow-y: auto;">
                    @forelse($availableQuestions as $question)
                        <div class="question-item mb-3 p-3 border rounded" data-question-id="{{ $question->id }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <p class="mb-2"><strong>{{ $question->question_text }}</strong></p>
                                    <div class="small text-muted">
                                        <span class="badge bg-secondary me-2">{{ ucfirst($question->difficulty) }}</span>
                                        <span class="badge bg-info">{{ ucfirst($question->question_type) }}</span>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-primary add-question ms-3" data-question-id="{{ $question->id }}">
                                    <i class="fas fa-plus me-1"></i>Add
                                </button>
                            </div>
                            
                            <!-- Show options for multiple choice -->
                            @if($question->question_type === 'multiple_choice' && $question->options)
                                <div class="mt-2 small">
                                    <ul class="mb-0">
                                        @foreach($question->options as $key => $option)
                                            <li class="{{ $key === $question->correct_answer ? 'text-success fw-bold' : '' }}">
                                                {{ $option }}
                                                @if($key === $question->correct_answer)
                                                    <i class="fas fa-check-circle text-success"></i>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>
                            No approved questions found for this certification.<br>
                            Please add and approve questions first.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectedList = document.getElementById('selected-questions-list');
    const selectedCount = document.getElementById('selected-count');
    const saveBtn = document.getElementById('save-btn');
    const noSelectionMessage = document.getElementById('no-selection-message');
    
    // Add question
    document.querySelectorAll('.add-question').forEach(btn => {
        btn.addEventListener('click', function() {
            const questionId = this.dataset.questionId;
            const currentCount = selectedList.querySelectorAll('.selected-question-item').length;
            
            if (currentCount >= 5) {
                alert('You can only select 5 questions. Remove one first.');
                return;
            }
            
            // Check if already selected
            if (selectedList.querySelector(`[data-question-id="${questionId}"]`)) {
                alert('This question is already selected.');
                return;
            }
            
            const questionItem = this.closest('.question-item');
            const questionText = questionItem.querySelector('strong').textContent;
            
            // Hide no selection message
            if (noSelectionMessage) {
                noSelectionMessage.style.display = 'none';
            }
            
            // Add to selected list
            const newItem = document.createElement('div');
            newItem.className = 'selected-question-item mb-3 p-3 border rounded';
            newItem.dataset.questionId = questionId;
            newItem.innerHTML = `
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <span class="badge bg-secondary me-2">Q${currentCount + 1}</span>
                        <strong>${questionText.substring(0, 100)}${questionText.length > 100 ? '...' : ''}</strong>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger remove-question">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <input type="hidden" name="question_ids[]" value="${questionId}">
            `;
            
            selectedList.appendChild(newItem);
            updateCount();
            
            // Disable add button
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-check me-1"></i>Added';
        });
    });
    
    // Remove question (using event delegation)
    selectedList.addEventListener('click', function(e) {
        if (e.target.closest('.remove-question')) {
            const item = e.target.closest('.selected-question-item');
            const questionId = item.dataset.questionId;
            
            item.remove();
            updateCount();
            
            // Re-enable add button
            const addBtn = document.querySelector(`.add-question[data-question-id="${questionId}"]`);
            if (addBtn) {
                addBtn.disabled = false;
                addBtn.innerHTML = '<i class="fas fa-plus me-1"></i>Add';
            }
            
            // Show no selection message if empty
            if (selectedList.querySelectorAll('.selected-question-item').length === 0 && noSelectionMessage) {
                noSelectionMessage.style.display = 'block';
            }
        }
    });
    
    function updateCount() {
        const count = selectedList.querySelectorAll('.selected-question-item').length;
        selectedCount.textContent = count;
        saveBtn.disabled = count !== 5;
        
        // Update question numbers
        selectedList.querySelectorAll('.selected-question-item').forEach((item, index) => {
            item.querySelector('.badge').textContent = `Q${index + 1}`;
        });
    }
    
    // Disable already selected questions
    document.querySelectorAll('.selected-question-item').forEach(item => {
        const questionId = item.dataset.questionId;
        const addBtn = document.querySelector(`.add-question[data-question-id="${questionId}"]`);
        if (addBtn) {
            addBtn.disabled = true;
            addBtn.innerHTML = '<i class="fas fa-check me-1"></i>Added';
        }
    });
});
</script>
@endpush
@endsection
