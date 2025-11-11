@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.profile.show') }}">My Profile</a></li>
            <li class="breadcrumb-item active">Edit Profile</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="mb-4">
        <h4 class="mb-1">Edit Profile</h4>
        <p class="text-muted mb-0">Update your account information and password</p>
    </div>

    <div class="row">
        <!-- Edit Profile Form -->
        <div class="col-md-8">
            <!-- Two-Factor Authentication Card -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Two-Factor Authentication</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-1">Enable Two-Factor Authentication</h6>
                            <p class="text-muted mb-0 small">Add an extra layer of security to your admin account by requiring a verification code when you sign in.</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="two_factor_enabled" 
                                   {{ $user->two_factor_enabled ? 'checked' : '' }}
                                   onchange="toggle2FA(this.checked)">
                        </div>
                    </div>

                    <div id="2fa-method-section" class="{{ $user->two_factor_enabled ? '' : 'd-none' }}">
                        <hr>
                        <div class="mb-3">
                            <label for="two_factor_method" class="form-label">Verification Method</label>
                            <select class="form-select" id="two_factor_method" name="two_factor_method" 
                                    onchange="update2FAMethod(this.value)">
                                <option value="email" {{ $user->two_factor_method === 'email' ? 'selected' : '' }}>
                                    Email ({{ $user->email }})
                                </option>
                                <option value="sms" disabled>
                                    SMS (Coming Soon)
                                </option>
                            </select>
                            <small class="form-text text-muted">Choose how you want to receive your verification codes</small>
                        </div>

                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Important:</strong> You'll receive a 6-digit code via email each time you sign in. Make sure you have access to {{ $user->email }}.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Profile Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3"><i class="bi bi-shield-lock me-2"></i>Change Password</h6>
                        <p class="text-muted small mb-3">Leave blank if you don't want to change your password</p>

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Required if you want to change your password</div>
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                   id="new_password" name="new_password">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Minimum 8 characters</div>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" 
                                   id="new_password_confirmation" name="new_password_confirmation">
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Profile
                            </button>
                            <a href="{{ route('admin.profile.show') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Profile Preview Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Account Details</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; border-radius: 50%; background-color: #696cff; color: white; font-size: 2rem; font-weight: 600;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">USER TYPE</label>
                        <p class="mb-0">
                            <span class="badge bg-primary">{{ ucfirst($user->user_type) }}</span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">ROLES</label>
                        <p class="mb-0">
                            @foreach($user->roles as $role)
                                <span class="badge bg-info me-1">{{ $role->name }}</span>
                            @endforeach
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">ACCOUNT STATUS</label>
                        <p class="mb-0">
                            @if($user->status === 'active')
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Active</span>
                            @else
                                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Disabled</span>
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">MEMBER SINCE</label>
                        <p class="mb-0">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>

                    <div>
                        <label class="form-label fw-bold small text-muted">LAST UPDATED</label>
                        <p class="mb-0">{{ $user->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
function toggle2FA(enabled) {
    const methodSection = document.getElementById('2fa-method-section');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    if (enabled) {
        methodSection.classList.remove('d-none');
        // Enable 2FA
        fetch('{{ route("admin.profile.two-factor.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                enabled: true,
                method: document.getElementById('two_factor_method').value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', '2FA Enabled', 'Two-factor authentication has been enabled for your account.');
            } else {
                showToast('error', 'Error', data.message || 'Failed to enable 2FA');
                document.getElementById('two_factor_enabled').checked = false;
                methodSection.classList.add('d-none');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'Error', 'An error occurred while enabling 2FA');
            document.getElementById('two_factor_enabled').checked = false;
            methodSection.classList.add('d-none');
        });
    } else {
        // Confirm before disabling
        if (confirm('Are you sure you want to disable two-factor authentication? This will make your account less secure.')) {
            methodSection.classList.add('d-none');
            // Disable 2FA
            fetch('{{ route("admin.profile.two-factor.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    enabled: false
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('info', '2FA Disabled', 'Two-factor authentication has been disabled for your account.');
                } else {
                    showToast('error', 'Error', data.message || 'Failed to disable 2FA');
                    document.getElementById('two_factor_enabled').checked = true;
                    methodSection.classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', 'Error', 'An error occurred while disabling 2FA');
                document.getElementById('two_factor_enabled').checked = true;
                methodSection.classList.remove('d-none');
            });
        } else {
            // User cancelled, restore checkbox
            document.getElementById('two_factor_enabled').checked = true;
        }
    }
}

function update2FAMethod(method) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('{{ route("admin.profile.two-factor.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            enabled: true,
            method: method
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', 'Method Updated', `Verification method updated to ${method.toUpperCase()}`);
        } else {
            showToast('error', 'Error', data.message || 'Failed to update method');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'Error', 'An error occurred while updating method');
    });
}

function showToast(type, title, message) {
    // Simple toast notification using Bootstrap alert
    const alertClass = type === 'success' ? 'alert-success' : type === 'error' ? 'alert-danger' : 'alert-info';
    const iconClass = type === 'success' ? 'bi-check-circle' : type === 'error' ? 'bi-x-circle' : 'bi-info-circle';
    
    const toast = document.createElement('div');
    toast.className = `alert ${alertClass} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    toast.style.zIndex = '9999';
    toast.innerHTML = `
        <i class="bi ${iconClass} me-2"></i>
        <strong>${title}:</strong> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 5000);
}
</script>
@endpush
