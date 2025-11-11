<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Two-Factor Authentication - SisuKai</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #696cff;
            --primary-hover: #5f61e6;
        }
        
        body {
            background-color: #f5f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Inter', sans-serif;
        }
        
        .auth-card {
            max-width: 500px;
            margin: 2rem auto;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
            border-radius: 0.5rem;
        }
        
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary-custom:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }
        
        .text-primary-custom {
            color: var(--primary-color) !important;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .code-input {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
            font-weight: 600;
            text-align: center;
            border: 2px solid #d9dee3;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }
        
        .code-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.25);
            outline: none;
        }
        
        .code-input:not(:placeholder-shown) {
            border-color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-card">
            <div class="card">
                <div class="card-body p-4 p-md-5">
                    <!-- Logo -->
                    <div class="text-center mb-4">
                        <a href="{{ route('landing.home') }}" class="logo text-decoration-none">
                            <i class="bi bi-mortarboard-fill"></i> SisuKai
                        </a>
                    </div>
                    
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h4 class="mb-2">Two Step Verification 💬</h4>
                        <p class="text-muted mb-1">
                            We sent a verification code to your email address. Enter the code from your email in the field below.
                        </p>
                        <p class="text-muted mb-0">
                            <span class="fw-medium">{{ session('two_factor_email_masked', '******@*****.com') }}</span>
                        </p>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Verification Form -->
                    <form id="twoFactorForm" action="{{ route('auth.two-factor.verify') }}" method="POST">
                        @csrf

                        <p class="text-center text-muted mb-3 small">Type your 6 digit security code</p>
                        
                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <input type="text" class="form-control code-input @error('code') is-invalid @enderror" 
                                       maxlength="1" autofocus data-index="0">
                                <input type="text" class="form-control code-input @error('code') is-invalid @enderror" 
                                       maxlength="1" data-index="1">
                                <input type="text" class="form-control code-input @error('code') is-invalid @enderror" 
                                       maxlength="1" data-index="2">
                                <input type="text" class="form-control code-input @error('code') is-invalid @enderror" 
                                       maxlength="1" data-index="3">
                                <input type="text" class="form-control code-input @error('code') is-invalid @enderror" 
                                       maxlength="1" data-index="4">
                                <input type="text" class="form-control code-input @error('code') is-invalid @enderror" 
                                       maxlength="1" data-index="5">
                            </div>
                            <input type="hidden" name="code" id="code" value="">
                            @error('code')
                                <div class="text-danger text-center mt-2 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary-custom w-100" type="submit">
                                <i class="bi bi-shield-check me-2"></i>
                                Verify my account
                            </button>
                        </div>
                    </form>

                    <!-- Resend Code -->
                    <div class="text-center mb-3">
                        <p class="text-muted mb-0 small">
                            Didn't get the code?
                            <form action="{{ route('auth.two-factor.resend') }}" method="POST" id="resendForm" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-link btn-sm p-0 align-baseline text-primary-custom" id="resendBtn" style="text-decoration: none;">
                                    Resend
                                </button>
                            </form>
                        </p>
                    </div>

                    <!-- Back to Login -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-muted text-decoration-none small">
                            <i class="bi bi-arrow-left me-1"></i>
                            Back to login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.code-input');
        const codeInput = document.getElementById('code');
        const form = document.getElementById('twoFactorForm');
        
        inputs.forEach((input, index) => {
            // Only allow numbers
            input.addEventListener('input', function(e) {
                const value = e.target.value;
                
                // Remove non-numeric characters
                e.target.value = value.replace(/[^0-9]/g, '');
                
                // Update hidden input
                updateCode();
                
                // Move to next input if value entered
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                
                // Auto-submit when all 6 digits are entered
                if (index === inputs.length - 1 && e.target.value.length === 1) {
                    const code = Array.from(inputs).map(inp => inp.value).join('');
                    if (code.length === 6) {
                        form.submit();
                    }
                }
            });
            
            // Handle backspace
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });
            
            // Handle paste
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
                
                if (pastedData.length === 6) {
                    pastedData.split('').forEach((char, i) => {
                        if (inputs[i]) {
                            inputs[i].value = char;
                        }
                    });
                    updateCode();
                    inputs[5].focus();
                    
                    // Auto-submit after paste
                    setTimeout(() => {
                        form.submit();
                    }, 100);
                }
            });
        });
        
        function updateCode() {
            const code = Array.from(inputs).map(input => input.value).join('');
            codeInput.value = code;
        }
        
        // Resend code with cooldown
        let resendCooldown = 0;
        const resendBtn = document.getElementById('resendBtn');
        const resendForm = document.getElementById('resendForm');
        
        resendForm.addEventListener('submit', function(e) {
            if (resendCooldown > 0) {
                e.preventDefault();
                return;
            }
            
            // Start cooldown
            resendCooldown = 60;
            resendBtn.disabled = true;
            
            const originalText = resendBtn.innerHTML;
            const interval = setInterval(() => {
                resendCooldown--;
                resendBtn.innerHTML = `Resend (${resendCooldown}s)`;
                
                if (resendCooldown <= 0) {
                    clearInterval(interval);
                    resendBtn.disabled = false;
                    resendBtn.innerHTML = originalText;
                }
            }, 1000);
        });
        
        // Focus on first input on page load
        inputs[0].focus();
    });
    </script>
</body>
</html>
