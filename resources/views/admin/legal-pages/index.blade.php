@extends('layouts.admin')
@section('title', 'Legal Pages')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Legal Pages</h4>
            <p class="text-muted mb-0">Manage legal documents and policies</p>
        </div>
        <a href="{{ route('admin.legal-pages.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Page
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Last Updated</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($legalPages as $page)
                            <tr>
                                <td><strong>{{ $page->title }}</strong></td>
                                <td><code>{{ $page->slug }}</code></td>
                                <td>{{ $page->updated_at->format('M d, Y') }}</td>
                                <td>
                                    @if($page->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.legal-pages.show', $page) }}" 
                                           class="btn btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.legal-pages.edit', $page) }}" 
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" 
                                                onclick="confirmDelete({{ $page->id }})" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $page->id }}" 
                                          action="{{ route('admin.legal-pages.destroy', $page) }}" 
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No legal pages found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this legal page?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection
