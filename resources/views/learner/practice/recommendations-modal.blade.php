<!-- Practice Recommendations Modal -->
<div class="modal fade" id="practiceModal" tabindex="-1" aria-labelledby="practiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="practiceModalLabel">
                    <i class="bi bi-book me-2"></i>Practice Session - {{ $certification->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav Tabs -->
                <ul class="nav nav-tabs mb-4" id="practiceTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="recommended-tab" data-bs-toggle="tab" data-bs-target="#recommended" type="button" role="tab" aria-controls="recommended" aria-selected="true">
                            <i class="bi bi-star me-2"></i>Recommended
                            @if($weakDomains->count() > 0)
                                <span class="badge bg-danger ms-1">{{ $weakDomains->count() }}</span>
                            @endif
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="by-domain-tab" data-bs-toggle="tab" data-bs-target="#by-domain" type="button" role="tab" aria-controls="by-domain" aria-selected="false">
                            <i class="bi bi-folder me-2"></i>By Domain
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="by-topic-tab" data-bs-toggle="tab" data-bs-target="#by-topic" type="button" role="tab" aria-controls="by-topic" aria-selected="false">
                            <i class="bi bi-list-ul me-2"></i>By Topic
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="quick-tab" data-bs-toggle="tab" data-bs-target="#quick" type="button" role="tab" aria-controls="quick" aria-selected="false">
                            <i class="bi bi-lightning me-2"></i>Quick Practice
                        </button>
                    </li>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content" id="practiceTabContent">
                    <!-- Tab 1: Recommended (Weak Domains) -->
                    <div class="tab-pane fade show active" id="recommended" role="tabpanel" aria-labelledby="recommended-tab">
                        <h6 class="text-muted mb-3">
                            <i class="bi bi-info-circle me-2"></i>Based on Your Benchmark Results ({{ number_format($benchmark->score_percentage, 1) }}%)
                        </h6>
                        
                        @if($weakDomains->count() > 0)
                            <div class="row g-3 mb-4">
                                @foreach($weakDomains as $domain)
                                    <div class="col-md-6">
                                        <div class="card border-danger h-100">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <span class="badge bg-danger me-2">Weak</span>
                                                    {{ $domain['name'] }}
                                                </h6>
                                                <p class="card-text small text-muted mb-3">
                                                    <strong>Benchmark Score:</strong> {{ number_format($domain['percentage'], 0) }}%<br>
                                                    <strong>Questions Available:</strong> {{ $domain['questions_count'] }}<br>
                                                    <strong>Recommended:</strong> 5-10 practice sessions
                                                </p>
                                                <form action="{{ route('learner.practice.create') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="certification_id" value="{{ $certification->id }}">
                                                    <input type="hidden" name="domain_id" value="{{ $domain['id'] }}">
                                                    <input type="hidden" name="question_count" value="20">
                                                    <input type="hidden" name="practice_mode" value="recommended">
                                                    <button type="submit" class="btn btn-sm btn-primary w-100">
                                                        <i class="bi bi-play-circle me-2"></i>Start Practice (20 questions)
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Quick Action: Practice All Weak Domains -->
                            <div class="alert alert-info">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h6 class="mb-1"><i class="bi bi-lightbulb me-2"></i>Practice All Weak Domains</h6>
                                        <p class="mb-0 small">Get a mixed set of 20 questions from all your weak domains for comprehensive practice.</p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <form action="{{ route('learner.practice.create') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="certification_id" value="{{ $certification->id }}">
                                            <input type="hidden" name="question_count" value="20">
                                            <input type="hidden" name="practice_mode" value="mixed">
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-play-circle me-2"></i>Start Mixed Practice
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-success">
                                <h6 class="mb-2"><i class="bi bi-trophy me-2"></i>Excellent Work!</h6>
                                <p class="mb-0">You have no weak domains. Consider practicing moderate domains or taking a full practice exam to prepare for the final certification exam.</p>
                            </div>
                            
                            @if($moderateDomains->count() > 0)
                                <h6 class="mt-4 mb-3">Moderate Domains (60-79%)</h6>
                                <div class="row g-3">
                                    @foreach($moderateDomains as $domain)
                                        <div class="col-md-6">
                                            <div class="card border-warning h-100">
                                                <div class="card-body">
                                                    <h6 class="card-title">
                                                        <span class="badge bg-warning me-2">Moderate</span>
                                                        {{ $domain['name'] }}
                                                    </h6>
                                                    <p class="card-text small text-muted mb-3">
                                                        <strong>Benchmark Score:</strong> {{ number_format($domain['percentage'], 0) }}%<br>
                                                        <strong>Questions Available:</strong> {{ $domain['questions_count'] }}
                                                    </p>
                                                    <form action="{{ route('learner.practice.create') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="certification_id" value="{{ $certification->id }}">
                                                        <input type="hidden" name="domain_id" value="{{ $domain['id'] }}">
                                                        <input type="hidden" name="question_count" value="20">
                                                        <input type="hidden" name="practice_mode" value="domain">
                                                        <button type="submit" class="btn btn-sm btn-warning w-100">
                                                            <i class="bi bi-play-circle me-2"></i>Start Practice (20 questions)
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>
                    
                    <!-- Tab 2: By Domain -->
                    <div class="tab-pane fade" id="by-domain" role="tabpanel" aria-labelledby="by-domain-tab">
                        <h6 class="text-muted mb-3">
                            <i class="bi bi-info-circle me-2"></i>Choose a domain to practice
                        </h6>
                        
                        <div class="row g-3">
                            @foreach($allDomains as $domain)
                                @php
                                    $domainPerf = $domainPerformance->firstWhere('id', $domain->id);
                                    $perfPercentage = $domainPerf ? $domainPerf['percentage'] : 0;
                                    $badgeClass = $perfPercentage < 60 ? 'danger' : ($perfPercentage < 80 ? 'warning' : 'success');
                                    $badgeText = $perfPercentage < 60 ? 'Weak' : ($perfPercentage < 80 ? 'Moderate' : 'Strong');
                                @endphp
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <span class="badge bg-{{ $badgeClass }} me-2">{{ $badgeText }}</span>
                                                {{ $domain->name }}
                                            </h6>
                                            <p class="card-text small text-muted mb-3">
                                                @if($domainPerf)
                                                    <strong>Benchmark Score:</strong> {{ number_format($perfPercentage, 0) }}%<br>
                                                @endif
                                                <strong>Questions Available:</strong> {{ $domain->questions_count }}<br>
                                                <strong>Topics:</strong> {{ $domain->topics->count() }}
                                            </p>
                                            <form action="{{ route('learner.practice.create') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="certification_id" value="{{ $certification->id }}">
                                                <input type="hidden" name="domain_id" value="{{ $domain->id }}">
                                                <input type="hidden" name="question_count" value="20">
                                                <input type="hidden" name="practice_mode" value="domain">
                                                <button type="submit" class="btn btn-sm btn-primary w-100">
                                                    <i class="bi bi-play-circle me-2"></i>Start Practice (20 questions)
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Tab 3: By Topic -->
                    <div class="tab-pane fade" id="by-topic" role="tabpanel" aria-labelledby="by-topic-tab">
                        <h6 class="text-muted mb-3">
                            <i class="bi bi-info-circle me-2"></i>Choose a specific topic to practice
                        </h6>
                        
                        <div class="accordion" id="topicAccordion">
                            @foreach($allDomains as $domainIndex => $domain)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $domainIndex }}">
                                        <button class="accordion-button {{ $domainIndex > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $domainIndex }}" aria-expanded="{{ $domainIndex === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $domainIndex }}">
                                            {{ $domain->name }} <span class="badge bg-secondary ms-2">{{ $domain->topics->count() }} topics</span>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $domainIndex }}" class="accordion-collapse collapse {{ $domainIndex === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $domainIndex }}" data-bs-parent="#topicAccordion">
                                        <div class="accordion-body">
                                            @if($domain->topics->count() > 0)
                                                <div class="list-group">
                                                    @foreach($domain->topics as $topic)
                                                        <div class="list-group-item">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <h6 class="mb-1">{{ $topic->name }}</h6>
                                                                    <small class="text-muted">{{ $topic->questions_count }} questions available</small>
                                                                </div>
                                                                <div>
                                                                    <form action="{{ route('learner.practice.create') }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <input type="hidden" name="certification_id" value="{{ $certification->id }}">
                                                                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                                                                        <input type="hidden" name="question_count" value="10">
                                                                        <input type="hidden" name="practice_mode" value="topic">
                                                                        <button type="submit" class="btn btn-sm btn-outline-primary" {{ $topic->questions_count < 5 ? 'disabled' : '' }}>
                                                                            <i class="bi bi-play-circle me-1"></i>Practice (10)
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-muted mb-0">No topics available for this domain.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Tab 4: Quick Practice -->
                    <div class="tab-pane fade" id="quick" role="tabpanel" aria-labelledby="quick-tab">
                        <h6 class="text-muted mb-3">
                            <i class="bi bi-info-circle me-2"></i>Quick practice sessions for focused learning
                        </h6>
                        
                        <div class="row g-3">
                            <!-- 10 Questions -->
                            <div class="col-md-4">
                                <div class="card text-center h-100">
                                    <div class="card-body">
                                        <i class="bi bi-lightning-charge text-primary" style="font-size: 3rem;"></i>
                                        <h4 class="mt-3">10 Questions</h4>
                                        <p class="text-muted small">Quick 10-minute session</p>
                                        <form action="{{ route('learner.practice.create') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="certification_id" value="{{ $certification->id }}">
                                            <input type="hidden" name="question_count" value="10">
                                            <input type="hidden" name="practice_mode" value="quick">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="bi bi-play-circle me-2"></i>Start
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 20 Questions -->
                            <div class="col-md-4">
                                <div class="card text-center h-100 border-primary">
                                    <div class="card-body">
                                        <i class="bi bi-lightning text-success" style="font-size: 3rem;"></i>
                                        <h4 class="mt-3">20 Questions</h4>
                                        <p class="text-muted small">Standard 20-minute session</p>
                                        <span class="badge bg-primary mb-2">Recommended</span>
                                        <form action="{{ route('learner.practice.create') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="certification_id" value="{{ $certification->id }}">
                                            <input type="hidden" name="question_count" value="20">
                                            <input type="hidden" name="practice_mode" value="quick">
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="bi bi-play-circle me-2"></i>Start
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 30 Questions -->
                            <div class="col-md-4">
                                <div class="card text-center h-100">
                                    <div class="card-body">
                                        <i class="bi bi-fire text-danger" style="font-size: 3rem;"></i>
                                        <h4 class="mt-3">30 Questions</h4>
                                        <p class="text-muted small">Extended 30-minute session</p>
                                        <form action="{{ route('learner.practice.create') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="certification_id" value="{{ $certification->id }}">
                                            <input type="hidden" name="question_count" value="30">
                                            <input type="hidden" name="practice_mode" value="quick">
                                            <button type="submit" class="btn btn-warning w-100">
                                                <i class="bi bi-play-circle me-2"></i>Start
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>
