@extends('layouts.admin')
@section('title', 'Settings')
@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="mb-1">Global Settings</h4>
        <p class="text-muted mb-0">Manage global site settings</p>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="trial_period_days" class="form-label">Free Trial Period (Days) *</label>
                        <input type="number" class="form-control @error('trial_period_days') is-invalid @enderror" 
                               id="trial_period_days" name="trial_period_days" 
                               value="{{ old('trial_period_days', $settings['trial_period_days']) }}" required>
                        @error('trial_period_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Number of days for the free trial period</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="site_name" class="form-label">Site Name *</label>
                        <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                               id="site_name" name="site_name" 
                               value="{{ old('site_name', $settings['site_name']) }}" required>
                        @error('site_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="support_email" class="form-label">Support Email *</label>
                        <input type="email" class="form-control @error('support_email') is-invalid @enderror" 
                               id="support_email" name="support_email" 
                               value="{{ old('support_email', $settings['support_email']) }}" required>
                        @error('support_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
