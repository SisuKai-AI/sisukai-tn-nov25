@extends('layouts.admin')

@section('title', 'Subscription Plans')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Subscription Plans</h4>
            <p class="text-muted mb-0">Manage pricing tiers and subscription features</p>
        </div>
        <a href="{{ route('admin.subscription-plans.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Plan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Plan Name</th>
                            <th>Monthly Price</th>
                            <th>Annual Price</th>
                            <th>Trial Days</th>
                            <th>Cert Limit</th>
                            <th>Status</th>
                            <th>Sort Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                            <tr>
                                <td>
                                    <strong>{{ $plan->name }}</strong><br>
                                    <small class="text-muted">{{ $plan->slug }}</small>
                                </td>
                                <td>${{ number_format($plan->price_monthly, 2) }}</td>
                                <td>${{ number_format($plan->price_annual, 2) }}</td>
                                <td>{{ $plan->trial_days }} days</td>
                                <td>{{ $plan->certification_limit ?? 'Unlimited' }}</td>
                                <td>
                                    @if($plan->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $plan->sort_order }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.subscription-plans.show', $plan) }}" 
                                           class="btn btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.subscription-plans.edit', $plan) }}" 
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" 
                                                onclick="confirmDelete({{ $plan->id }})" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $plan->id }}" 
                                          action="{{ route('admin.subscription-plans.destroy', $plan) }}" 
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No subscription plans found. Create your first plan to get started.
                                </td>
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
    if (confirm('Are you sure you want to delete this subscription plan?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection
