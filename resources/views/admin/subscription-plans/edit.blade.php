@extends('layouts.admin')

@section('title', isset($subscriptionPlan) ? 'Edit Subscription Plan' : 'Create Subscription Plan')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="mb-1">{{ isset($subscriptionPlan) ? 'Edit' : 'Create' }} Subscription Plan</h4>
        <p class="text-muted mb-0">{{ isset($subscriptionPlan) ? 'Update' : 'Add a new' }} pricing tier</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($subscriptionPlan) ? route('admin.subscription-plans.update', $subscriptionPlan) : route('admin.subscription-plans.store') }}" 
                  method="POST">
                @csrf
                @if(isset($subscriptionPlan))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Plan Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $subscriptionPlan->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label">Slug *</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" value="{{ old('slug', $subscriptionPlan->slug ?? '') }}" required>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="price_monthly" class="form-label">Monthly Price ($) *</label>
                        <input type="number" step="0.01" class="form-control @error('price_monthly') is-invalid @enderror" 
                               id="price_monthly" name="price_monthly" value="{{ old('price_monthly', $subscriptionPlan->price_monthly ?? '0.00') }}" required>
                        @error('price_monthly')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="price_annual" class="form-label">Annual Price ($) *</label>
                        <input type="number" step="0.01" class="form-control @error('price_annual') is-invalid @enderror" 
                               id="price_annual" name="price_annual" value="{{ old('price_annual', $subscriptionPlan->price_annual ?? '0.00') }}" required>
                        @error('price_annual')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="trial_days" class="form-label">Trial Days *</label>
                        <input type="number" class="form-control @error('trial_days') is-invalid @enderror" 
                               id="trial_days" name="trial_days" value="{{ old('trial_days', $subscriptionPlan->trial_days ?? '7') }}" required>
                        @error('trial_days')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="certification_limit" class="form-label">Certification Limit</label>
                        <input type="number" class="form-control @error('certification_limit') is-invalid @enderror" 
                               id="certification_limit" name="certification_limit" 
                               value="{{ old('certification_limit', $subscriptionPlan->certification_limit ?? '') }}" 
                               placeholder="Leave empty for unlimited">
                        @error('certification_limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Leave empty for unlimited certifications</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="sort_order" class="form-label">Sort Order *</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" name="sort_order" value="{{ old('sort_order', $subscriptionPlan->sort_order ?? '0') }}" required>
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description', $subscriptionPlan->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Features</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="has_practice_sessions" id="has_practice_sessions" 
                                   value="1" {{ old('has_practice_sessions', $subscriptionPlan->has_practice_sessions ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_practice_sessions">
                                Practice Sessions
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="has_benchmark_exams" id="has_benchmark_exams" 
                                   value="1" {{ old('has_benchmark_exams', $subscriptionPlan->has_benchmark_exams ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_benchmark_exams">
                                Benchmark Exams
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="has_analytics" id="has_analytics" 
                                   value="1" {{ old('has_analytics', $subscriptionPlan->has_analytics ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_analytics">
                                Performance Analytics
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                               value="1" {{ old('is_active', $subscriptionPlan->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>{{ isset($subscriptionPlan) ? 'Update' : 'Create' }} Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
