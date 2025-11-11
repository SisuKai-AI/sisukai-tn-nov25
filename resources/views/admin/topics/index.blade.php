@extends('layouts.admin')

@section('title', 'Manage Topics - ' . $domain->name)

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.index') }}">Certifications</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.show', $domain->certification) }}">{{ $domain->certification->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.domains.index', $domain->certification) }}">Domains</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.domains.show', [$domain->certification, $domain]) }}">{{ $domain->name }}</a></li>
            <li class="breadcrumb-item active">Topics</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Topics in {{ $domain->name }}</h4>
            <p class="text-muted mb-0">Manage topics for this domain</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.certifications.domains.show', [$domain->certification, $domain]) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
            <a href="{{ route('admin.domains.topics.create', $domain) }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Topic
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Topics List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="80">Order</th>
                            <th>Topic Name</th>
                            <th>Questions</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topics as $topic)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary text-white">{{ $topic->order }}</span>
                                </td>
                                <td>
                                    <strong>{{ $topic->name }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-info text-white">{{ $topic->questions_count }} questions</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.domains.topics.show', [$domain, $topic]) }}">
                                                    <i class="bi bi-eye me-2"></i>View Details
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.domains.topics.edit', [$domain, $topic]) }}">
                                                    <i class="bi bi-pencil me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.questions.index', ['topic_id' => $topic->id]) }}">
                                                    <i class="bi bi-question-circle me-2"></i>Manage Questions
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.domains.topics.destroy', [$domain, $topic]) }}" method="POST" onsubmit="return confirm('Are you sure? This will also delete all questions in this topic.');">
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
                                <td colspan="4" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="bi bi-list-task" style="font-size: 3rem; color: #ccc;"></i>
                                        <h6 class="mt-3">No topics yet</h6>
                                        <p class="text-muted">Start by adding topics for this domain</p>
                                        <a href="{{ route('admin.domains.topics.create', $domain) }}" class="btn btn-primary mt-2">
                                            <i class="bi bi-plus-circle me-2"></i>Add First Topic
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

