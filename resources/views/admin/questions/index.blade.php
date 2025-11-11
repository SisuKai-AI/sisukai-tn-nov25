@extends('layouts.admin')

@section('title', isset($topic) ? $topic->name . ' - Questions' : 'Questions Management')

@section('content')
<div class="container-fluid">
    @if(isset($topic))
        <!-- Breadcrumb for Topic-Scoped View -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.certifications.index') }}">Certifications</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.certifications.show', $topic->domain->certification) }}">{{ $topic->domain->certification->name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.certifications.domains.index', $topic->domain->certification) }}">Domains</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.certifications.domains.show', [$topic->domain->certification, $topic->domain]) }}">{{ $topic->domain->name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.domains.topics.index', $topic->domain) }}">Topics</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.domains.topics.show', [$topic->domain, $topic]) }}">{{ $topic->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Questions</li>
            </ol>
        </nav>
    @endif

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            @if(isset($topic))
                <h4 class="mb-1">{{ $topic->name }} - Questions</h4>
                <p class="text-muted mb-0">{{ $topic->domain->certification->name }} / {{ $topic->domain->name }}</p>
            @else
                <h4 class="mb-1">Questions Management</h4>
                <p class="text-muted mb-0">Manage exam questions across all certifications</p>
            @endif
        </div>
        @if(isset($topic))
            <a href="{{ route('admin.questions.create', ['topic_id' => $topic->id]) }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Question
            </a>
        @else
            <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Question
            </a>
        @endif
    </div>

    <!-- Filters -->
    @if(!isset($topic))
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.questions.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="certification_id" class="form-label">Certification</label>
                    <select name="certification_id" id="certification_id" class="form-select">
                        <option value="">All Certifications</option>
                        @foreach($certifications as $cert)
                            <option value="{{ $cert->id }}" {{ request('certification_id') == $cert->id ? 'selected' : '' }}>
                                {{ $cert->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="difficulty" class="form-label">Difficulty</label>
                    <select name="difficulty" id="difficulty" class="form-select">
                        <option value="">All Levels</option>
                        <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                        <option value="medium" {{ request('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="hard" {{ request('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="pending_review" {{ request('status') == 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Bulk Actions -->
    <div class="card mb-3" id="bulkActionsCard" style="display: none;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong><span id="selectedCount">0</span> question(s) selected</strong>
                </div>
                <div>
                    <button type="button" class="btn btn-success" id="bulkApproveBtn">
                        <i class="bi bi-check-circle me-2"></i>Approve Selected
                    </button>
                    <button type="button" class="btn btn-secondary" id="clearSelectionBtn">
                        <i class="bi bi-x-circle me-2"></i>Clear Selection
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Questions Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 40px;">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>Question</th>
                            <th>Certification</th>
                            <th>Topic</th>
                            <th>Difficulty</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                            <tr>
                                <td>
                                    @if($question->status == 'draft')
                                        <input type="checkbox" class="form-check-input question-checkbox" value="{{ $question->id }}">
                                    @endif
                                </td>
                                <td style="max-width: 400px;">
                                    <div class="text-truncate">{{ $question->question_text }}</div>
                                    <small class="text-muted">{{ $question->answers->count() }} answers</small>
                                </td>
                                <td>
                                    <small>{{ $question->topic->domain->certification->name }}</small>
                                </td>
                                <td>
                                    <small>{{ $question->topic->name }}</small>
                                </td>
                                <td>
                                    @if($question->difficulty == 'easy')
                                        <span class="badge bg-success">Easy</span>
                                    @elseif($question->difficulty == 'medium')
                                        <span class="badge bg-warning">Medium</span>
                                    @else
                                        <span class="badge bg-danger">Hard</span>
                                    @endif
                                </td>
                                <td>
                                    @if($question->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($question->status == 'pending_review')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($question->status == 'draft')
                                        <span class="badge bg-secondary">Draft</span>
                                    @else
                                        <span class="badge bg-dark">Archived</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.questions.show', $question) }}">
                                                    <i class="bi bi-eye me-2"></i>View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.questions.edit', $question) }}">
                                                    <i class="bi bi-pencil me-2"></i>Edit
                                                </a>
                                            </li>
                                            @if($question->status != 'approved')
                                                <li>
                                                    <form action="{{ route('admin.questions.approve', $question) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="bi bi-check-circle me-2"></i>Approve
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="bi bi-question-circle" style="font-size: 3rem; color: #ccc;"></i>
                                        <h6 class="mt-3">No questions yet</h6>
                                        <p class="text-muted">Start by adding your first question</p>
                                        <a href="{{ route('admin.questions.create') }}" class="btn btn-primary mt-2">
                                            <i class="bi bi-plus-circle me-2"></i>Add Question
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($questions->hasPages())
                <div class="mt-3">
                    {{ $questions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Approve Confirmation Modal -->
<div class="modal fade" id="bulkApproveModal" tabindex="-1" aria-labelledby="bulkApproveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkApproveModalLabel">
                    <i class="bi bi-check-circle text-success me-2"></i>
                    Confirm Bulk Approval
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve <strong><span id="modalQuestionCount">0</span> question(s)</strong>?</p>
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Note:</strong> Approved questions will be available for learners to practice.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>
                    Cancel
                </button>
                <button type="button" class="btn btn-success" id="confirmBulkApproveBtn">
                    <i class="bi bi-check-circle me-1"></i>
                    Approve Questions
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const bulkActionsCard = document.getElementById('bulkActionsCard');
    const selectedCountSpan = document.getElementById('selectedCount');
    const bulkApproveBtn = document.getElementById('bulkApproveBtn');
    const clearSelectionBtn = document.getElementById('clearSelectionBtn');

    // Select All checkbox
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.question-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkActions();
        });
    }

    // Individual checkboxes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('question-checkbox')) {
            updateSelectAllState();
            updateBulkActions();
        }
    });

    // Clear selection button
    if (clearSelectionBtn) {
        clearSelectionBtn.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.question-checkbox');
            checkboxes.forEach(cb => cb.checked = false);
            if (selectAllCheckbox) selectAllCheckbox.checked = false;
            updateBulkActions();
        });
    }

    // Bulk approve button - Show modal
    if (bulkApproveBtn) {
        bulkApproveBtn.addEventListener('click', function() {
            const selectedCheckboxes = document.querySelectorAll('.question-checkbox:checked');
            const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);

            if (selectedIds.length === 0) {
                alert('Please select at least one question to approve.');
                return;
            }

            // Update modal with count
            document.getElementById('modalQuestionCount').textContent = selectedIds.length;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('bulkApproveModal'));
            modal.show();
        });
    }

    // Confirm bulk approve button in modal
    const confirmBulkApproveBtn = document.getElementById('confirmBulkApproveBtn');
    if (confirmBulkApproveBtn) {
        confirmBulkApproveBtn.addEventListener('click', function() {
            const selectedCheckboxes = document.querySelectorAll('.question-checkbox:checked');
            const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);

            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.questions.bulk-approve") }}';

            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = '{{ csrf_token() }}';
            form.appendChild(tokenInput);

            const idsInput = document.createElement('input');
            idsInput.type = 'hidden';
            idsInput.name = 'question_ids';
            idsInput.value = JSON.stringify(selectedIds);
            form.appendChild(idsInput);

            document.body.appendChild(form);
            form.submit();
        });
    }

    function updateSelectAllState() {
        const checkboxes = document.querySelectorAll('.question-checkbox');
        const checkedBoxes = document.querySelectorAll('.question-checkbox:checked');
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = checkboxes.length > 0 && checkboxes.length === checkedBoxes.length;
        }
    }

    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.question-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (selectedCountSpan) {
            selectedCountSpan.textContent = count;
        }
        
        if (bulkActionsCard) {
            if (count > 0) {
                bulkActionsCard.style.display = 'block';
            } else {
                bulkActionsCard.style.display = 'none';
            }
        }
    }
});
</script>
@endsection

