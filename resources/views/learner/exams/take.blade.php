@extends('layouts.learner')

@section('title', 'Taking Exam')

@section('content')
<div class="container-fluid">
    {{-- Timer and Progress Bar --}}
    <div class="card border-0 shadow-sm mb-3 sticky-top" style="top: 70px; z-index: 100;">
        <div class="card-body py-2">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clock text-danger fs-4 me-2"></i>
                        <div>
                            <small class="text-muted d-block">Time Remaining</small>
                            <strong id="timer" class="text-danger fs-5">{{ sprintf('%02d:%02d:00', floor($remainingMinutes / 60), $remainingMinutes % 60) }}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center">
                        <small class="text-muted d-block mb-1">Question <span id="currentQuestionNum">1</span> of {{ $questions->count() }}</small>
                        <div class="progress" style="height: 8px;">
                            <div id="progressBar" class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-end">
                    <span class="badge bg-info me-2">
                        <i class="bi bi-check-circle"></i> <span id="answeredCount">0</span> Answered
                    </span>
                    <span class="badge bg-warning text-dark">
                        <i class="bi bi-flag"></i> <span id="flaggedCount">0</span> Flagged
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Question Display --}}
        <div class="col-lg-9 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div id="questionContainer">
                        {{-- Question will be loaded here via JavaScript --}}
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <button type="button" id="prevBtn" class="btn btn-outline-secondary" disabled>
                            <i class="bi bi-arrow-left"></i> Previous
                        </button>
                        
                        <div class="d-flex gap-2">
                            <button type="button" id="flagBtn" class="btn btn-outline-warning">
                                <i class="bi bi-flag"></i> <span id="flagBtnText">Flag</span>
                            </button>
                            <button type="button" id="submitExamBtn" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#submitModal">
                                <i class="bi bi-check-circle"></i> Submit Exam
                            </button>
                        </div>

                        <button type="button" id="nextBtn" class="btn btn-primary">
                            Next <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Question Navigator --}}
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm sticky-top" style="top: 150px;">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0">Question Navigator</h6>
                </div>
                <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                    <div id="questionNav" class="d-grid gap-2" style="grid-template-columns: repeat(5, 1fr);">
                        @foreach($questions as $index => $q)
                            <button type="button" 
                                    class="btn btn-sm btn-outline-secondary question-nav-btn" 
                                    data-question-num="{{ $index + 1 }}"
                                    data-question-id="{{ $q->question_id }}">
                                {{ $index + 1 }}
                            </button>
                        @endforeach
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <small class="d-flex align-items-center mb-2">
                            <span class="badge bg-primary me-2" style="width: 20px; height: 20px;"></span>
                            Current
                        </small>
                        <small class="d-flex align-items-center mb-2">
                            <span class="badge bg-success me-2" style="width: 20px; height: 20px;"></span>
                            Answered
                        </small>
                        <small class="d-flex align-items-center mb-2">
                            <span class="badge bg-warning text-dark me-2" style="width: 20px; height: 20px;"></span>
                            Flagged
                        </small>
                        <small class="d-flex align-items-center">
                            <span class="badge bg-outline-secondary me-2" style="width: 20px; height: 20px; border: 1px solid #dee2e6;"></span>
                            Not Answered
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Submit Confirmation Modal --}}
<div class="modal fade" id="submitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle"></i> Submit Exam
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <strong>Are you sure you want to submit your exam?</strong>
                </div>
                <p class="mb-2">Review your answers:</p>
                <ul class="mb-0">
                    <li>Total Questions: <strong>{{ $questions->count() }}</strong></li>
                    <li>Answered: <strong><span id="modalAnsweredCount">0</span></strong></li>
                    <li>Unanswered: <strong><span id="modalUnansweredCount">{{ $questions->count() }}</span></strong></li>
                    <li>Flagged for Review: <strong><span id="modalFlaggedCount">0</span></strong></li>
                </ul>
                <p class="text-danger mt-3 mb-0">
                    <i class="bi bi-exclamation-circle"></i> 
                    <strong>This action cannot be undone.</strong> Once submitted, you cannot change your answers.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancel
                </button>
                <form action="{{ route('learner.exams.submit', $examSession->id) }}" method="POST" id="submitForm">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-check-circle"></i> Submit Exam
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Exam State
const examState = {
    attemptId: '{{ $examSession->id }}',
    totalQuestions: {{ $questions->count() }},
    currentQuestion: 1,
    questions: @json($questions->pluck('question_id')),
    answeredQuestions: @json($answeredQuestionIds),
    flaggedQuestions: @json($questions->where('is_flagged', true)->pluck('question_id')->values()),
    remainingSeconds: {{ $remainingMinutes * 60 }},
    timerInterval: null,
    csrfToken: '{{ csrf_token() }}'
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeExam();
    startTimer();
    loadQuestion(1);
});

// Initialize exam interface
function initializeExam() {
    // Set up navigation buttons
    document.getElementById('prevBtn').addEventListener('click', () => navigateQuestion(-1));
    document.getElementById('nextBtn').addEventListener('click', () => navigateQuestion(1));
    document.getElementById('flagBtn').addEventListener('click', toggleFlag);
    
    // Set up question navigator buttons
    document.querySelectorAll('.question-nav-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const questionNum = parseInt(this.dataset.questionNum);
            loadQuestion(questionNum);
        });
    });
    
    // Update counts
    updateCounts();
}

// Start countdown timer
function startTimer() {
    updateTimerDisplay();
    
    examState.timerInterval = setInterval(() => {
        examState.remainingSeconds--;
        updateTimerDisplay();
        
        // Save to localStorage for persistence
        localStorage.setItem(`exam_${examState.attemptId}_time`, examState.remainingSeconds);
        
        if (examState.remainingSeconds <= 0) {
            clearInterval(examState.timerInterval);
            alert('Time is up! Your exam will be automatically submitted.');
            document.getElementById('submitForm').submit();
        }
    }, 1000);
}

// Update timer display
function updateTimerDisplay() {
    const hours = Math.floor(examState.remainingSeconds / 3600);
    const minutes = Math.floor((examState.remainingSeconds % 3600) / 60);
    const seconds = examState.remainingSeconds % 60;
    
    const timerEl = document.getElementById('timer');
    timerEl.textContent = `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
    
    // Change color when time is running low
    if (examState.remainingSeconds < 300) { // Less than 5 minutes
        timerEl.classList.add('text-danger');
    }
}

// Load question
async function loadQuestion(questionNum) {
    examState.currentQuestion = questionNum;
    
    // Show loading
    document.getElementById('questionContainer').innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    
    try {
        const response = await fetch(`/learner/exams/${examState.attemptId}/question/${questionNum}`);
        const data = await response.json();
        
        renderQuestion(data);
        updateNavigationState();
        updateProgressBar();
    } catch (error) {
        console.error('Error loading question:', error);
        alert('Failed to load question. Please try again.');
    }
}

// Render question
function renderQuestion(data) {
    const question = data.question;
    const selectedAnswerId = data.selected_answer_id;
    const isFlagged = data.is_flagged;
    
    let html = `
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h5>Question ${examState.currentQuestion}</h5>
                <span class="badge bg-secondary">${question.topic.domain.name}</span>
            </div>
            <p class="fs-5 mb-4">${question.question_text}</p>
        </div>
        <div class="list-group">
    `;
    
    question.answers.forEach(answer => {
        const isSelected = answer.id === selectedAnswerId;
        html += `
            <label class="list-group-item list-group-item-action ${isSelected ? 'active' : ''}" style="cursor: pointer;">
                <input type="radio" 
                       name="answer" 
                       value="${answer.id}" 
                       data-question-id="${question.id}"
                       ${isSelected ? 'checked' : ''}
                       class="form-check-input me-2">
                ${answer.answer_text}
            </label>
        `;
    });
    
    html += '</div>';
    
    document.getElementById('questionContainer').innerHTML = html;
    
    // Update flag button
    const flagBtn = document.getElementById('flagBtn');
    const flagBtnText = document.getElementById('flagBtnText');
    if (isFlagged) {
        flagBtn.classList.remove('btn-outline-warning');
        flagBtn.classList.add('btn-warning', 'text-dark');
        flagBtnText.textContent = 'Unflag';
    } else {
        flagBtn.classList.remove('btn-warning', 'text-dark');
        flagBtn.classList.add('btn-outline-warning');
        flagBtnText.textContent = 'Flag';
    }
    
    // Add event listeners to radio buttons
    document.querySelectorAll('input[name="answer"]').forEach(radio => {
        radio.addEventListener('change', function() {
            submitAnswer(this.dataset.questionId, this.value);
        });
    });
}

// Submit answer via AJAX
async function submitAnswer(questionId, answerId) {
    try {
        const response = await fetch(`/learner/exams/${examState.attemptId}/answer`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': examState.csrfToken
            },
            body: JSON.stringify({
                question_id: questionId,
                answer_id: answerId
            })
        });
        
        if (response.ok) {
            // Add to answered questions if not already there
            if (!examState.answeredQuestions.includes(questionId)) {
                examState.answeredQuestions.push(questionId);
            }
            updateCounts();
            updateQuestionNavButton(examState.currentQuestion);
        }
    } catch (error) {
        console.error('Error submitting answer:', error);
    }
}

// Toggle flag
async function toggleFlag() {
    const questionId = examState.questions[examState.currentQuestion - 1];
    
    try {
        const response = await fetch(`/learner/exams/${examState.attemptId}/flag/${questionId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': examState.csrfToken
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            if (data.is_flagged) {
                examState.flaggedQuestions.push(questionId);
            } else {
                examState.flaggedQuestions = examState.flaggedQuestions.filter(id => id !== questionId);
            }
            
            // Update UI
            const flagBtn = document.getElementById('flagBtn');
            const flagBtnText = document.getElementById('flagBtnText');
            if (data.is_flagged) {
                flagBtn.classList.remove('btn-outline-warning');
                flagBtn.classList.add('btn-warning', 'text-dark');
                flagBtnText.textContent = 'Unflag';
            } else {
                flagBtn.classList.remove('btn-warning', 'text-dark');
                flagBtn.classList.add('btn-outline-warning');
                flagBtnText.textContent = 'Flag';
            }
            
            updateCounts();
            updateQuestionNavButton(examState.currentQuestion);
        }
    } catch (error) {
        console.error('Error toggling flag:', error);
    }
}

// Navigate question
function navigateQuestion(direction) {
    const newQuestion = examState.currentQuestion + direction;
    if (newQuestion >= 1 && newQuestion <= examState.totalQuestions) {
        loadQuestion(newQuestion);
    }
}

// Update navigation state
function updateNavigationState() {
    document.getElementById('prevBtn').disabled = examState.currentQuestion === 1;
    document.getElementById('nextBtn').disabled = examState.currentQuestion === examState.totalQuestions;
    document.getElementById('currentQuestionNum').textContent = examState.currentQuestion;
}

// Update progress bar
function updateProgressBar() {
    const progress = (examState.currentQuestion / examState.totalQuestions) * 100;
    document.getElementById('progressBar').style.width = progress + '%';
}

// Update counts
function updateCounts() {
    const answeredCount = examState.answeredQuestions.length;
    const flaggedCount = examState.flaggedQuestions.length;
    const unansweredCount = examState.totalQuestions - answeredCount;
    
    document.getElementById('answeredCount').textContent = answeredCount;
    document.getElementById('flaggedCount').textContent = flaggedCount;
    document.getElementById('modalAnsweredCount').textContent = answeredCount;
    document.getElementById('modalUnansweredCount').textContent = unansweredCount;
    document.getElementById('modalFlaggedCount').textContent = flaggedCount;
}

// Update question nav button
function updateQuestionNavButton(questionNum) {
    const questionId = examState.questions[questionNum - 1];
    const btn = document.querySelector(`.question-nav-btn[data-question-num="${questionNum}"]`);
    
    // Remove all state classes
    btn.classList.remove('btn-primary', 'btn-success', 'btn-warning', 'text-dark', 'btn-outline-secondary');
    
    // Add appropriate class
    if (questionNum === examState.currentQuestion) {
        btn.classList.add('btn-primary');
    } else if (examState.flaggedQuestions.includes(questionId)) {
        btn.classList.add('btn-warning', 'text-dark');
    } else if (examState.answeredQuestions.includes(questionId)) {
        btn.classList.add('btn-success');
    } else {
        btn.classList.add('btn-outline-secondary');
    }
}

// Helper function to pad numbers
function pad(num) {
    return num.toString().padStart(2, '0');
}

// Warn before leaving page
window.addEventListener('beforeunload', function(e) {
    e.preventDefault();
    e.returnValue = '';
});
</script>
@endsection

