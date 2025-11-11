@extends('layouts.admin')

@section('title', 'Payment Settings')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3">Payment Processor Settings</h1>
            <p class="text-muted">Configure Stripe and Paddle payment processors for accepting payments.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.payment-settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Stripe Settings -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-stripe me-2"></i>Stripe
                        </h5>
                        @if(isset($settings['stripe']) && $settings['stripe']->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="stripe_publishable_key" class="form-label">Publishable Key</label>
                            <input type="text" 
                                   class="form-control @error('stripe_publishable_key') is-invalid @enderror" 
                                   id="stripe_publishable_key" 
                                   name="stripe_publishable_key" 
                                   value="{{ old('stripe_publishable_key', $settings['stripe']->publishable_key ?? '') }}"
                                   placeholder="pk_test_...">
                            @error('stripe_publishable_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Your Stripe publishable key (starts with pk_)</small>
                        </div>

                        <div class="mb-3">
                            <label for="stripe_secret_key" class="form-label">Secret Key</label>
                            <input type="password" 
                                   class="form-control @error('stripe_secret_key') is-invalid @enderror" 
                                   id="stripe_secret_key" 
                                   name="stripe_secret_key" 
                                   placeholder="sk_test_...">
                            @error('stripe_secret_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Your Stripe secret key (starts with sk_) - encrypted in database</small>
                        </div>

                        <div class="mb-3">
                            <label for="stripe_webhook_secret" class="form-label">Webhook Secret</label>
                            <input type="password" 
                                   class="form-control @error('stripe_webhook_secret') is-invalid @enderror" 
                                   id="stripe_webhook_secret" 
                                   name="stripe_webhook_secret" 
                                   placeholder="whsec_...">
                            @error('stripe_webhook_secret')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Webhook signing secret (starts with whsec_)</small>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="stripe_is_active" 
                                   name="stripe_is_active" 
                                   value="1"
                                   {{ (isset($settings['stripe']) && $settings['stripe']->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="stripe_is_active">
                                Enable Stripe payments
                            </label>
                        </div>

                        @if(isset($settings['stripe']) && $settings['stripe']->is_active)
                            <button type="button" 
                                    class="btn btn-outline-primary btn-sm" 
                                    onclick="testConnection('stripe')">
                                <i class="bi bi-check-circle me-1"></i>Test Connection
                            </button>
                            <div id="stripe-test-result" class="mt-2"></div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Paddle Settings -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-credit-card me-2"></i>Paddle
                        </h5>
                        @if(isset($settings['paddle']) && $settings['paddle']->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="paddle_vendor_id" class="form-label">Vendor ID</label>
                            <input type="text" 
                                   class="form-control @error('paddle_vendor_id') is-invalid @enderror" 
                                   id="paddle_vendor_id" 
                                   name="paddle_vendor_id" 
                                   value="{{ old('paddle_vendor_id', $settings['paddle']->publishable_key ?? '') }}"
                                   placeholder="12345">
                            @error('paddle_vendor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Your Paddle vendor ID</small>
                        </div>

                        <div class="mb-3">
                            <label for="paddle_auth_code" class="form-label">Auth Code</label>
                            <input type="password" 
                                   class="form-control @error('paddle_auth_code') is-invalid @enderror" 
                                   id="paddle_auth_code" 
                                   name="paddle_auth_code" 
                                   placeholder="Enter auth code">
                            @error('paddle_auth_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Paddle API auth code - encrypted in database</small>
                        </div>

                        <div class="mb-3">
                            <label for="paddle_public_key" class="form-label">Public Key</label>
                            <textarea class="form-control @error('paddle_public_key') is-invalid @enderror" 
                                      id="paddle_public_key" 
                                      name="paddle_public_key" 
                                      rows="4"
                                      placeholder="-----BEGIN PUBLIC KEY-----">{{ old('paddle_public_key', isset($settings['paddle']) ? $settings['paddle']->public_key : '') }}</textarea>
                            @error('paddle_public_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Paddle public key for webhook verification</small>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="paddle_is_active" 
                                   name="paddle_is_active" 
                                   value="1"
                                   {{ (isset($settings['paddle']) && $settings['paddle']->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="paddle_is_active">
                                Enable Paddle payments
                            </label>
                        </div>

                        @if(isset($settings['paddle']) && $settings['paddle']->is_active)
                            <button type="button" 
                                    class="btn btn-outline-info btn-sm" 
                                    onclick="testConnection('paddle')">
                                <i class="bi bi-check-circle me-1"></i>Test Connection
                            </button>
                            <div id="paddle-test-result" class="mt-2"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Default Processor Selection -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Default Payment Processor</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Active Payment Processor</label>
                            <p class="text-muted small">Select which payment processor will be used for all customer checkouts. Users will not see any difference in the checkout experience.</p>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="default_processor" 
                                       id="default_stripe" 
                                       value="stripe"
                                       {{ ($activeProcessor === 'stripe') ? 'checked' : '' }}>
                                <label class="form-check-label" for="default_stripe">
                                    <strong>Stripe</strong> - Lower fees (2.9% + $0.30), faster payouts
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="default_processor" 
                                       id="default_paddle" 
                                       value="paddle"
                                       {{ ($activeProcessor === 'paddle') ? 'checked' : '' }}>
                                <label class="form-check-label" for="default_paddle">
                                    <strong>Paddle</strong> - Handles global taxes (Merchant of Record), higher fees (5% + $0.50)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="row mt-4">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Save Settings
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function testConnection(processor) {
    const resultDiv = document.getElementById(processor + '-test-result');
    resultDiv.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Testing...</span></div> Testing connection...';
    
    fetch(`/admin/payment-settings/test/${processor}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.innerHTML = `<div class="alert alert-success alert-sm mb-0">${data.message}</div>`;
            if (data.account) {
                resultDiv.innerHTML += `<small class="text-muted">Account: ${data.account.email} (${data.account.country})</small>`;
            }
        } else {
            resultDiv.innerHTML = `<div class="alert alert-danger alert-sm mb-0">${data.message}</div>`;
        }
    })
    .catch(error => {
        resultDiv.innerHTML = `<div class="alert alert-danger alert-sm mb-0">Connection test failed: ${error.message}</div>`;
    });
}
</script>
@endpush
@endsection
