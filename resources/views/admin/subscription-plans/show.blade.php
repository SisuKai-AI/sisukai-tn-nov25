@extends('layouts.admin')
@section('title', $subscriptionPlan->name)
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $subscriptionPlan->name }}</h4>
            <p class="text-muted mb-0">Subscription Plan Details</p>
        </div>
        <a href="{{ route('admin.subscription-plans.edit', $subscriptionPlan) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Plan Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Name:</th>
                            <td>{{ $subscriptionPlan->name }}</td>
                        </tr>
                        <tr>
                            <th>Slug:</th>
                            <td><code>{{ $subscriptionPlan->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Monthly Price:</th>
                            <td>${{ number_format($subscriptionPlan->price_monthly, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Annual Price:</th>
                            <td>${{ number_format($subscriptionPlan->price_annual, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Trial Days:</th>
                            <td>{{ $subscriptionPlan->trial_days }} days</td>
                        </tr>
                        <tr>
                            <th>Cert Limit:</th>
                            <td>{{ $subscriptionPlan->certification_limit ?? 'Unlimited' }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($subscriptionPlan->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Features</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-{{ $subscriptionPlan->has_practice_sessions ? 'check-circle text-success' : 'x-circle text-danger' }} me-2"></i>
                            Practice Sessions
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-{{ $subscriptionPlan->has_benchmark_exams ? 'check-circle text-success' : 'x-circle text-danger' }} me-2"></i>
                            Benchmark Exams
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-{{ $subscriptionPlan->has_analytics ? 'check-circle text-success' : 'x-circle text-danger' }} me-2"></i>
                            Performance Analytics
                        </li>
                    </ul>
                    @if($subscriptionPlan->description)
                        <hr>
                        <p class="text-muted mb-0">{{ $subscriptionPlan->description }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
