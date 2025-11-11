@extends('layouts.admin')

@section('title', 'Manage Domains - ' . $certification->name)

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.index') }}">Certifications</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.certifications.show', $certification) }}">{{ $certification->name }}</a></li>
            <li class="breadcrumb-item active">Domains</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Knowledge Domains</h4>
            <p class="text-muted mb-0">Manage domains for {{ $certification->name }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.certifications.show', $certification) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
            <a href="{{ route('admin.certifications.domains.create', $certification) }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Domain
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

    <!-- Domains List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="80">Order</th>
                            <th>Domain Name</th>
                            <th>Topics</th>
                            <th>Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($domains as $domain)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary text-white">{{ $domain->order }}</span>
                                </td>
                                <td>
                                    <strong>{{ $domain->name }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-info text-white">{{ $domain->topics_count }} topics</span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ Str::limit($domain->description, 60) }}</small>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.certifications.domains.show', [$certification, $domain]) }}">
                                                    <i class="bi bi-eye me-2"></i>View Details
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.domains.topics.index', $domain) }}">
                                                    <i class="bi bi-list-task me-2"></i>Manage Topics
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.certifications.domains.edit', [$certification, $domain]) }}">
                                                    <i class="bi bi-pencil me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.certifications.domains.destroy', [$certification, $domain]) }}" method="POST" onsubmit="return confirm('Are you sure? This will also delete all topics and questions in this domain.');">
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
                                <td colspan="5" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="bi bi-folder" style="font-size: 3rem; color: #ccc;"></i>
                                        <h6 class="mt-3">No domains yet</h6>
                                        <p class="text-muted">Start by adding knowledge domains for this certification</p>
                                        <a href="{{ route('admin.certifications.domains.create', $certification) }}" class="btn btn-primary mt-2">
                                            <i class="bi bi-plus-circle me-2"></i>Add First Domain
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

