@extends('layouts.admin')
@section('title', 'Newsletter Subscribers')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Newsletter Subscribers</h4>
            <p class="text-muted mb-0">Manage newsletter subscriptions</p>
        </div>
        <a href="{{ route('admin.newsletter-subscribers.export') }}" class="btn btn-success">
            <i class="bi bi-download me-2"></i>Export CSV
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Subscribers</h6>
                    <h3>{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Subscribed</h6>
                    <h3 class="text-success">{{ $stats['subscribed'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Unsubscribed</h6>
                    <h3 class="text-danger">{{ $stats['unsubscribed'] }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Source</th>
                            <th>Subscribed At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscribers as $subscriber)
                            <tr>
                                <td>{{ $subscriber->email }}</td>
                                <td>{{ $subscriber->name ?? '-' }}</td>
                                <td>
                                    @if($subscriber->status === 'subscribed')
                                        <span class="badge bg-success">Subscribed</span>
                                    @else
                                        <span class="badge bg-secondary">Unsubscribed</span>
                                    @endif
                                </td>
                                <td>{{ $subscriber->subscription_source ?? '-' }}</td>
                                <td>{{ $subscriber->subscribed_at?->format('M d, Y') ?? '-' }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="confirmDelete({{ $subscriber->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $subscriber->id }}" 
                                          action="{{ route('admin.newsletter-subscribers.destroy', $subscriber) }}" 
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No subscribers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $subscribers->links() }}
        </div>
    </div>
</div>
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this subscriber?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection
