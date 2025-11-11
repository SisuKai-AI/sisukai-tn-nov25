@extends('layouts.learner')

@section('title', 'Manage Subscription')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1 class="mb-4">Manage Subscription</h1>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if($subscription)
                <!-- Current Subscription Card -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Current Plan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="mb-2">{{ $subscription->plan->name }}</h3>
                                <p class="text-muted mb-3">{{ $subscription->plan->description }}</p>
                                
                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <strong>Status:</strong>
                                        @if($subscription->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($subscription->status === 'trialing')
                                            <span class="badge bg-info">Trial</span>
                                        @elseif($subscription->status === 'past_due')
                                            <span class="badge bg-warning">Past Due</span>
                                        @elseif($subscription->status === 'canceled')
                                            <span class="badge bg-danger">Canceled</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($subscription->status) }}</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <strong>Billing Cycle:</strong>
                                        {{ ucfirst($subscription->plan->billing_cycle) }}
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <strong>Price:</strong>
                                        ${{ number_format($subscription->plan->price, 2) }}/{{ $subscription->plan->billing_cycle === 'monthly' ? 'mo' : 'yr' }}
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <strong>Next Billing:</strong>
                                        {{ $subscription->current_period_end->format('M j, Y') }}
                                    </div>
                                </div>

                                @if($subscription->status === 'trialing' && $subscription->trial_ends_at)
                                    <div class="alert alert-info mb-0">
                                        <strong>Trial Period:</strong> Your trial ends on {{ $subscription->trial_ends_at->format('F j, Y') }}
                                        ({{ $subscription->trial_ends_at->diffForHumans() }})
                                    </div>
                                @endif

                                @if($subscription->status === 'canceling' && $subscription->ends_at)
                                    <div class="alert alert-warning mb-0">
                                        <strong>Cancellation Scheduled:</strong> Your subscription will end on {{ $subscription->ends_at->format('F j, Y') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4 text-end">
                                <h2 class="text-primary mb-0">${{ number_format($subscription->plan->price, 2) }}</h2>
                                <p class="text-muted">per {{ $subscription->plan->billing_cycle === 'monthly' ? 'month' : 'year' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Subscription Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            @if($subscription->status === 'active' || $subscription->status === 'trialing')
                                <form action="{{ route('learner.payment.subscription.cancel') }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to cancel your subscription? You will retain access until {{ $subscription->current_period_end->format('F j, Y') }}.')">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="bi bi-x-circle"></i> Cancel Subscription
                                    </button>
                                </form>
                            @elseif($subscription->status === 'canceling')
                                <form action="{{ route('learner.payment.subscription.resume') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-arrow-clockwise"></i> Resume Subscription
                                    </button>
                                </form>
                            @endif
                            
                            <a href="{{ route('learner.payment.billing-history') }}" class="btn btn-outline-primary">
                                <i class="bi bi-receipt"></i> View Billing History
                            </a>
                            
                            <a href="{{ route('learner.payment.pricing') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left-right"></i> Change Plan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Subscription Benefits -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Your Benefits</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success"></i> Access to all {{ $certificationCount ?? '18' }} certifications</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success"></i> Unlimited practice questions</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success"></i> Adaptive learning engine</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success"></i> Performance analytics dashboard</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success"></i> Timed exam simulations</li>
                            <li class="mb-0"><i class="bi bi-check-circle-fill text-success"></i> Mobile app access</li>
                        </ul>
                    </div>
                </div>
            @else
                <!-- No Subscription -->
                <div class="alert alert-info">
                    <h4 class="alert-heading">No Active Subscription</h4>
                    <p class="mb-3">You don't have an active subscription. Upgrade to unlock all SisuKai features!</p>
                    <a href="{{ route('learner.payment.pricing') }}" class="btn btn-primary">
                        View Plans
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
