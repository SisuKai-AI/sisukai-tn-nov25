@extends('layouts.learner')

@section('title', 'Practice Session - ' . $session->certification->name)

@section('content')
<div class="container-fluid">
    <!-- Progress Bar -->
    <div class="card mb-3">
        <div class="card-body py-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small">Progress:</span>
                    <strong id="progress-text">0 / {{ $session->total_questions }}</strong>
                </div>
                <div class="flex-grow-1 mx-4">
                    <div class="progress" style="height: 10px;">
                        <div id="progress-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
                <div>
                    <span class="badge bg-success me-2" id="correct-count">0 Correct</span>
                    <span class="badge bg-danger" id="incorrect-count">0 Incorrect</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Question Area -->
        <div class="col-lg-9">
            <div class="card mb-3" id="question-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary" id="domain-badge"></span>
                            <span class="badge bg-info ms-2">Question <span id="current-question-number">1</span> of {{ $session->total_questions }}</span>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-danger" id="quit-btn">
                                <i class="bi bi-x-circle me-1"></i>Quit Practice
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="question-text" class="mb-4" style="font-size: 1.1rem; line-height: 1.6;"></div>
                    
                    <div id="answers-container" class="list-group"></div>
                    
                    <!-- Feedback Area (Hidden initially) -->
                    <div id="feedback-area" class="mt-4" style="display: none;">
                        <div id="feedback-alert" class="alert" role="alert">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <i id="feedback-icon" class="bi" style="font-size: 2rem;"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 id="feedback-title" class="alert-heading mb-2"></h5>
                                    <div id="feedback-explanation" class="mb-3"></div>
                                    <div class="small text-muted">
                                        <strong>Domain:</strong> <span id="feedback-domain"></span> |
                                        <strong>Topic:</strong> <span id="feedback-topic"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg" id="next-btn">
                                <i class="bi bi-arrow-right me-2"></i>Next Question
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Completion Card (Hidden initially) -->
            <div class="card" id="completion-card" style="display: none;">
                <div class="card-body text-center py-5">
                    <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                    <h3 class="mt-3">Practice Session Complete!</h3>
                    <p class="text-muted mb-4">You've answered all questions. Great job!</p>
                    
                    <form action="{{ route('learner.practice.complete', $session->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-bar-chart me-2"></i>View Results
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Question Navigator -->
        <div class="col-lg-3">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-list-ol me-2"></i>Question Navigator</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2" id="question-navigator" style="grid-template-columns: repeat(4, 1fr);">
                        @foreach($session->questions as $index => $question)
                            <button class="btn btn-sm btn-outline-secondary question-nav-btn" 
                                    data-question-index="{{ $index }}"
                                    data-question-id="{{ $question->id }}"
                                    style="width: 40px; height: 40px;">
                                {{ $index + 1 }}
                            </button>
                        @endforeach
                    </div>
                    
                    <hr>
                    
                    <div class="small">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-secondary me-2" style="width: 20px; height: 20px;"></span>
                            <span>Not Answered</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-success me-2" style="width: 20px; height: 20px;"></span>
                            <span>Correct</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-danger me-2" style="width: 20px; height: 20px;"></span>
                            <span>Incorrect</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Questions Data (Hidden) -->
<script id="questions-data" type="application/json">
    @json($session->questions)
</script>

<!-- Answered Questions Data (Hidden) -->
<script id="answered-questions-data" type="application/json">
    @json($answeredQuestions)
</script>

<script>
// Practice Session JavaScript
const sessionId = '{{ $session->id }}';
const csrfToken = '{{ csrf_token() }}';
const questions = JSON.parse(document.getElementById('questions-data').textContent);
const answeredQuestions = JSON.parse(document.getElementById('answered-questions-data').textContent);

let currentQuestionIndex = 0;
let correctCount = 0;
let incorrectCount = 0;
let answeredCount = answeredQuestions.length;
let currentQuestionAnswered = false;

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    loadQuestion(currentQuestionIndex);
    updateProgress();
    updateNavigator();
    
    // Question navigator click handlers
    document.querySelectorAll('.question-nav-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const index = parseInt(this.dataset.questionIndex);
            loadQuestion(index);
        });
    });
    
    // Next button handler
    document.getElementById('next-btn').addEventListener('click', function() {
        if (currentQuestionIndex < questions.length - 1) {
            currentQuestionIndex++;
            loadQuestion(currentQuestionIndex);
        } else {
            showCompletionCard();
        }
    });
    
    // Quit button handler
    document.getElementById('quit-btn').addEventListener('click', function() {
        if (confirm('Are you sure you want to quit this practice session? Your progress will be saved.')) {
            window.location.href = '{{ route("learner.certifications.show", $session->certification_id) }}';
        }
    });
});

function loadQuestion(index) {
    currentQuestionIndex = index;
    const question = questions[index];
    currentQuestionAnswered = answeredQuestions.includes(question.id);
    
    // Update question display
    document.getElementById('current-question-number').textContent = index + 1;
    document.getElementById('domain-badge').textContent = question.topic.domain.name;
    document.getElementById('question-text').textContent = question.question_text;
    
    // Clear and populate answers
    const answersContainer = document.getElementById('answers-container');
    answersContainer.innerHTML = '';
    
    question.answers.forEach(answer => {
        const answerBtn = document.createElement('button');
        answerBtn.className = 'list-group-item list-group-item-action';
        answerBtn.dataset.answerId = answer.id;
        answerBtn.innerHTML = `<i class="bi bi-circle me-2"></i>${answer.answer_text}`;
        
        if (!currentQuestionAnswered) {
            answerBtn.addEventListener('click', function() {
                submitAnswer(question.id, answer.id);
            });
        } else {
            answerBtn.disabled = true;
            answerBtn.classList.add('disabled');
        }
        
        answersContainer.appendChild(answerBtn);
    });
    
    // Hide feedback area
    document.getElementById('feedback-area').style.display = 'none';
    
    // Update active question in navigator
    document.querySelectorAll('.question-nav-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`[data-question-index="${index}"]`).classList.add('active');
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function submitAnswer(questionId, answerId) {
    if (currentQuestionAnswered) return;
    
    // Disable all answer buttons
    document.querySelectorAll('#answers-container button').forEach(btn => {
        btn.disabled = true;
    });
    
    // Submit answer via AJAX
    fetch(`/learner/practice/${sessionId}/answer`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            question_id: questionId,
            answer_id: answerId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showFeedback(data, answerId);
            currentQuestionAnswered = true;
            answeredQuestions.push(questionId);
            
            // Update counts
            if (data.is_correct) {
                correctCount++;
            } else {
                incorrectCount++;
            }
            answeredCount++;
            
            updateProgress();
            updateNavigator();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
        // Re-enable buttons
        document.querySelectorAll('#answers-container button').forEach(btn => {
            btn.disabled = false;
        });
    });
}

function showFeedback(data, selectedAnswerId) {
    const feedbackArea = document.getElementById('feedback-area');
    const feedbackAlert = document.getElementById('feedback-alert');
    const feedbackIcon = document.getElementById('feedback-icon');
    const feedbackTitle = document.getElementById('feedback-title');
    const feedbackExplanation = document.getElementById('feedback-explanation');
    const feedbackDomain = document.getElementById('feedback-domain');
    const feedbackTopic = document.getElementById('feedback-topic');
    
    // Highlight correct and selected answers
    document.querySelectorAll('#answers-container button').forEach(btn => {
        const answerId = btn.dataset.answerId;
        
        if (answerId === data.correct_answer_id) {
            btn.classList.remove('list-group-item-action');
            btn.classList.add('list-group-item-success');
            btn.innerHTML = `<i class="bi bi-check-circle-fill me-2"></i>${btn.textContent.trim()}`;
        } else if (answerId === selectedAnswerId && !data.is_correct) {
            btn.classList.remove('list-group-item-action');
            btn.classList.add('list-group-item-danger');
            btn.innerHTML = `<i class="bi bi-x-circle-fill me-2"></i>${btn.textContent.trim()}`;
        }
    });
    
    // Set feedback content
    if (data.is_correct) {
        feedbackAlert.className = 'alert alert-success';
        feedbackIcon.className = 'bi bi-check-circle-fill text-success';
        feedbackTitle.textContent = 'Correct! Well done!';
    } else {
        feedbackAlert.className = 'alert alert-danger';
        feedbackIcon.className = 'bi bi-x-circle-fill text-danger';
        feedbackTitle.textContent = 'Incorrect. Let\'s learn from this.';
    }
    
    feedbackExplanation.textContent = data.explanation || 'No explanation available.';
    feedbackDomain.textContent = data.domain;
    feedbackTopic.textContent = data.topic;
    
    // Show feedback area
    feedbackArea.style.display = 'block';
    
    // Scroll to feedback
    feedbackArea.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function updateProgress() {
    const progressPercentage = (answeredCount / questions.length) * 100;
    document.getElementById('progress-bar').style.width = progressPercentage + '%';
    document.getElementById('progress-text').textContent = `${answeredCount} / ${questions.length}`;
    document.getElementById('correct-count').textContent = `${correctCount} Correct`;
    document.getElementById('incorrect-count').textContent = `${incorrectCount} Incorrect`;
}

function updateNavigator() {
    document.querySelectorAll('.question-nav-btn').forEach((btn, index) => {
        const questionId = btn.dataset.questionId;
        
        if (answeredQuestions.includes(questionId)) {
            // Check if correct or incorrect (we need to track this)
            btn.classList.remove('btn-outline-secondary');
            btn.classList.add('btn-success'); // For now, mark as answered
        }
    });
}

function showCompletionCard() {
    document.getElementById('question-card').style.display = 'none';
    document.getElementById('completion-card').style.display = 'block';
}
</script>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Submission Failed
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Failed to submit answer. Please check your connection and try again.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
