<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - SisuKai</title>
    
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
            max-width: 450px;
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
        
        .btn-social {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            border: 2px solid;
            transition: all 0.3s ease;
        }
        
        .btn-google {
            background-color: #fff;
            border-color: #dadce0;
            color: #4285f4;
        }
        
        .btn-google:hover {
            background-color: #4285f4;
            border-color: #4285f4;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(66, 133, 244, 0.3);
        }
        
        .btn-linkedin {
            background-color: #fff;
            border-color: #dadce0;
            color: #0077b5;
        }
        
        .btn-linkedin:hover {
            background-color: #0077b5;
            border-color: #0077b5;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 119, 181, 0.3);
        }
        
        .btn-facebook {
            background-color: #fff;
            border-color: #dadce0;
            color: #1877f2;
        }
        
        .btn-facebook:hover {
            background-color: #1877f2;
            border-color: #1877f2;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(24, 119, 242, 0.3);
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }
        
        .divider span {
            padding: 0 1rem;
            color: #6c757d;
            font-size: 0.875rem;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.25);
        }
        
        .text-primary-custom {
            color: var(--primary-color) !important;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
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
                        <h4 class="mb-2">Start Your Free Trial 🚀</h4>
                        <p class="text-muted">Create your account and begin your certification journey</p>
                    </div>
                    
                    <!-- Social Auth -->
                    <div class="d-flex justify-content-center gap-3 mb-3">
                        <button type="button" class="btn btn-social btn-google" id="googleAuthBtn" title="Sign up with Google">
                            <i class="bi bi-google"></i>
                        </button>
                        
                        <button type="button" class="btn btn-social btn-linkedin" id="linkedinAuthBtn" title="Sign up with LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </button>
                        
                        <button type="button" class="btn btn-social btn-facebook" id="facebookAuthBtn" title="Sign up with Facebook">
                            <i class="bi bi-facebook"></i>
                        </button>
                    </div>
                    
                    <div class="divider">
                        <span>or sign up with email</span>
                    </div>
                    
                    <!-- Registration Form -->
                    <form method="POST" action="{{ route('learner.register') }}" id="registerForm">
                        @csrf
                        
                        <!-- Hidden fields for certification-specific registration -->
                        @if(request('cert'))
                            <input type="hidden" name="cert" value="{{ request('cert') }}">
                        @endif
                        @if(request('quiz'))
                            <input type="hidden" name="quiz" value="{{ request('quiz') }}">
                        @endif
                        
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Enter your full name"
                                   required 
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Enter your email"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Create a password"
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Must be at least 8 characters</small>
                        </div>
                        
                        <!-- Password Confirmation -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Confirm your password"
                                   required>
                        </div>
                        
                        <!-- Terms Agreement -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="{{ route('landing.legal.show', 'terms-of-service') }}" target="_blank" class="text-primary-custom">Terms of Service</a> 
                                and <a href="{{ route('landing.legal.show', 'privacy-policy') }}" target="_blank" class="text-primary-custom">Privacy Policy</a>
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary-custom w-100 mb-3">
                            <i class="bi bi-rocket-takeoff me-2"></i>
                            Create Account
                        </button>
                    </form>
                    
                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-muted mb-0">
                            Already have an account? 
                            <a href="{{ route('learner.login') }}" class="text-primary-custom fw-semibold">Sign in instead</a>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Back to Home -->
            <div class="text-center mt-3">
                <a href="{{ route('landing.home') }}" class="text-muted text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Back to Home
                </a>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
        
        // Social Auth handlers
        document.getElementById('googleAuthBtn').addEventListener('click', function() {
            window.location.href = '{{ route("auth.google") }}';
        });
        
        document.getElementById('linkedinAuthBtn').addEventListener('click', function() {
            window.location.href = '{{ route("auth.linkedin") }}';
        });
        
        document.getElementById('facebookAuthBtn').addEventListener('click', function() {
            window.location.href = '{{ route("auth.facebook") }}';
        });
    </script>
</body>
</html>
