<div x-data="quizComponent('{{ $certification->slug }}', '{{ $certification->id }}')" x-init="init()">
    
    <!-- Loading State -->
    <div x-show="loading" class="text-center py-5">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3 text-muted">Loading quiz questions...</p>
    </div>
    
    <!-- Error State -->
    <div x-show="error" class="alert alert-danger" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <span x-text="error"></span>
    </div>
    
    <!-- Quiz Start State -->
    <div x-show="!loading && !error && !quizStarted && !quizCompleted" class="text-center py-4">
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="bg-light rounded p-3">
                    <i class="bi bi-question-circle fs-4 text-primary mb-2"></i>
                    <h5 class="mb-0">5</h5>
                    <small class="text-muted">Questions</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-light rounded p-3">
                    <i class="bi bi-clock fs-4 text-success mb-2"></i>
                    <h5 class="mb-0">~3</h5>
                    <small class="text-muted">Minutes</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-light rounded p-3">
                    <i class="bi bi-star fs-4 text-warning mb-2"></i>
                    <h5 class="mb-0">Free</h5>
                    <small class="text-muted">No Signup</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-light rounded p-3">
                    <i class="bi bi-trophy fs-4 text-info mb-2"></i>
                    <h5 class="mb-0">Instant</h5>
                    <small class="text-muted">Results</small>
                </div>
            </div>
        </div>
        <button @click="startQuiz()" class="btn btn-primary-custom btn-lg px-5">
            <i class="bi bi-play-circle me-2"></i>Start Free Quiz
        </button>
        <p class="text-muted small mt-3 mb-0">No registration required • Get instant feedback</p>
    </div>
    
    <!-- Quiz Questions State -->
    <div x-show="quizStarted && !quizCompleted">
        <!-- Progress Bar -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small">Question <span x-text="currentQuestionIndex + 1"></span> of 5</span>
                <span class="text-muted small"><span x-text="score"></span> correct</span>
            </div>
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-primary-custom" role="progressbar" 
                     :style="'width: ' + ((currentQuestionIndex / 5) * 100) + '%'"></div>
            </div>
        </div>
        
        <!-- Current Question -->
        <template x-if="currentQuestion">
            <div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="mb-0">Question <span x-text="currentQuestion.number"></span></h5>
                        <span class="badge" 
                              :class="{
                                  'bg-success': currentQuestion.difficulty === 'easy',
                                  'bg-warning': currentQuestion.difficulty === 'medium',
                                  'bg-danger': currentQuestion.difficulty === 'hard'
                              }"
                              x-text="currentQuestion.difficulty"></span>
                    </div>
                    <p class="lead mb-4" x-text="currentQuestion.question_text"></p>
                </div>
                
                <!-- Answer Options -->
                <div class="list-group mb-4">
                    <template x-for="option in ['a', 'b', 'c', 'd']" :key="option">
                        <button 
                            type="button"
                            class="list-group-item list-group-item-action"
                            :class="{
                                'active': selectedAnswer === option && !answerSubmitted,
                                'list-group-item-success': answerSubmitted && option === correctAnswer,
                                'list-group-item-danger': answerSubmitted && option === selectedAnswer && option !== correctAnswer,
                                'disabled': answerSubmitted
                            }"
                            @click="selectAnswer(option)"
                            :disabled="answerSubmitted">
                            <div class="d-flex align-items-center">
                                <span class="badge me-3" 
                                      :class="{
                                          'bg-primary-custom': selectedAnswer === option && !answerSubmitted,
                                          'bg-success': answerSubmitted && option === correctAnswer,
                                          'bg-danger': answerSubmitted && option === selectedAnswer && option !== correctAnswer,
                                          'bg-secondary': selectedAnswer !== option && (!answerSubmitted || option !== correctAnswer)
                                      }"
                                      x-text="option.toUpperCase()"></span>
                                <span x-text="currentQuestion['option_' + option]"></span>
                                <span class="ms-auto">
                                    <i x-show="answerSubmitted && option === correctAnswer" class="bi bi-check-circle-fill text-success"></i>
                                    <i x-show="answerSubmitted && option === selectedAnswer && option !== correctAnswer" class="bi bi-x-circle-fill text-danger"></i>
                                </span>
                            </div>
                        </button>
                    </template>
                </div>
                
                <!-- Explanation (shown after answer) -->
                <div x-show="answerSubmitted && explanation" class="alert alert-info">
                    <h6 class="alert-heading"><i class="bi bi-lightbulb me-2"></i>Explanation</h6>
                    <p class="mb-0 small" x-text="explanation"></p>
                </div>
                
                <!-- Action Buttons -->
                <div class="d-flex justify-content-between">
                    <button @click="previousQuestion()" 
                            x-show="currentQuestionIndex > 0"
                            class="btn btn-outline-custom"
                            :disabled="!answerSubmitted">
                        <i class="bi bi-arrow-left me-2"></i>Previous
                    </button>
                    <div class="ms-auto">
                        <button @click="submitAnswer()" 
                                x-show="!answerSubmitted"
                                class="btn btn-primary-custom"
                                :disabled="!selectedAnswer">
                            Check Answer
                        </button>
                        <button @click="nextQuestion()" 
                                x-show="answerSubmitted && currentQuestionIndex < 4"
                                class="btn btn-primary-custom">
                            Next Question<i class="bi bi-arrow-right ms-2"></i>
                        </button>
                        <button @click="finishQuiz()" 
                                x-show="answerSubmitted && currentQuestionIndex === 4"
                                class="btn btn-success">
                            See Results<i class="bi bi-trophy ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
    
    <!-- Quiz Results State -->
    <div x-show="quizCompleted" class="text-center py-4">
        <div class="mb-4">
            <i class="bi bi-trophy fs-1 mb-3" 
               :class="{
                   'text-success': percentage >= 80,
                   'text-primary': percentage >= 60 && percentage < 80,
                   'text-warning': percentage >= 40 && percentage < 60,
                   'text-danger': percentage < 40
               }"></i>
            <h3 class="mb-2">Quiz Complete!</h3>
            <p class="text-muted mb-4" x-text="resultMessage"></p>
        </div>
        
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="bg-light rounded p-4">
                    <h2 class="mb-0" x-text="score + '/5'"></h2>
                    <small class="text-muted">Score</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-light rounded p-4">
                    <h2 class="mb-0" x-text="percentage + '%'"></h2>
                    <small class="text-muted">Percentage</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-light rounded p-4">
                    <h2 class="mb-0" x-text="passed ? 'Pass' : 'Review'"></h2>
                    <small class="text-muted">Status</small>
                </div>
            </div>
        </div>
        
        <div class="alert alert-primary mb-4">
            <h5 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Want to see your detailed readiness report?</h5>
            <p class="mb-3">Sign up for free to get:</p>
            <ul class="text-start mb-3">
                <li>Detailed performance analysis by domain</li>
                <li>Personalized study recommendations</li>
                <li>Access to {{ $certification->exam_question_count }}+ practice questions</li>
                <li>Timed mock exams and progress tracking</li>
            </ul>
            <a :href="'/register?cert={{ $certification->slug }}&quiz=' + attemptId" 
               class="btn btn-primary-custom btn-lg">
                <i class="bi bi-rocket-takeoff me-2"></i>Start 7-Day Free Trial
            </a>
            <p class="text-muted small mt-3 mb-0">No credit card required • Cancel anytime</p>
        </div>
        
        <button @click="retakeQuiz()" class="btn btn-outline-custom">
            <i class="bi bi-arrow-clockwise me-2"></i>Retake Quiz
        </button>
    </div>
    
</div>

<script>
function quizComponent(certSlug, certId) {
    return {
        loading: false,
        error: null,
        quizStarted: false,
        quizCompleted: false,
        questions: [],
        currentQuestionIndex: 0,
        currentQuestion: null,
        selectedAnswer: null,
        answerSubmitted: false,
        correctAnswer: null,
        explanation: null,
        answers: [],
        score: 0,
        sessionId: null,
        attemptId: null,
        percentage: 0,
        resultMessage: '',
        passed: false,
        
        init() {
            // Component initialized
        },
        
        async startQuiz() {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await fetch(`/api/quiz/${certSlug}/questions`);
                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.error || 'Failed to load quiz');
                }
                
                this.questions = data.questions;
                this.sessionId = data.session_id;
                this.currentQuestion = this.questions[0];
                this.quizStarted = true;
            } catch (err) {
                this.error = err.message;
            } finally {
                this.loading = false;
            }
        },
        
        selectAnswer(option) {
            if (!this.answerSubmitted) {
                this.selectedAnswer = option;
            }
        },
        
        async submitAnswer() {
            if (!this.selectedAnswer) return;
            
            try {
                const response = await fetch('/api/quiz/submit-answer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        question_id: this.currentQuestion.id,
                        answer: this.selectedAnswer,
                        session_id: this.sessionId
                    })
                });
                
                const data = await response.json();
                
                this.answerSubmitted = true;
                this.correctAnswer = data.correct_answer;
                this.explanation = data.explanation;
                
                if (data.correct) {
                    this.score++;
                }
                
                this.answers.push({
                    question_id: this.currentQuestion.id,
                    answer: this.selectedAnswer,
                    correct: data.correct
                });
                
            } catch (err) {
                this.error = 'Failed to submit answer. Please try again.';
            }
        },
        
        nextQuestion() {
            if (this.currentQuestionIndex < 4) {
                this.currentQuestionIndex++;
                this.currentQuestion = this.questions[this.currentQuestionIndex];
                this.selectedAnswer = null;
                this.answerSubmitted = false;
                this.correctAnswer = null;
                this.explanation = null;
            }
        },
        
        previousQuestion() {
            if (this.currentQuestionIndex > 0) {
                this.currentQuestionIndex--;
                this.currentQuestion = this.questions[this.currentQuestionIndex];
                // Load previous answer if exists
                const prevAnswer = this.answers[this.currentQuestionIndex];
                if (prevAnswer) {
                    this.selectedAnswer = prevAnswer.answer;
                    this.answerSubmitted = true;
                }
            }
        },
        
        async finishQuiz() {
            try {
                const response = await fetch('/api/quiz/complete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        certification_id: certId,
                        session_id: this.sessionId,
                        score: this.score,
                        answers: this.answers
                    })
                });
                
                const data = await response.json();
                
                this.attemptId = data.attempt_id;
                this.percentage = data.percentage;
                this.resultMessage = data.message;
                this.passed = data.passed;
                this.quizCompleted = true;
                
            } catch (err) {
                this.error = 'Failed to save quiz results. Please try again.';
            }
        },
        
        retakeQuiz() {
            // Reset all state
            this.quizStarted = false;
            this.quizCompleted = false;
            this.currentQuestionIndex = 0;
            this.currentQuestion = null;
            this.selectedAnswer = null;
            this.answerSubmitted = false;
            this.correctAnswer = null;
            this.explanation = null;
            this.answers = [];
            this.score = 0;
            this.percentage = 0;
            this.resultMessage = '';
            this.passed = false;
            
            // Start new quiz
            this.startQuiz();
        }
    }
}
</script>
