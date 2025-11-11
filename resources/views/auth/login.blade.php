<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SisuKai</title>
    
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
                        <h4 class="mb-2">Welcome Back! 👋</h4>
                        <p class="text-muted">Sign in to continue your learning journey</p>
                    </div>
                    
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <!-- Social Auth -->
                    <div class="d-flex justify-content-center gap-3 mb-3">
                        <button type="button" class="btn btn-social btn-google" id="googleAuthBtn" title="Sign in with Google">
                            <i class="bi bi-google"></i>
                        </button>
                        
                        <button type="button" class="btn btn-social btn-linkedin" id="linkedinAuthBtn" title="Sign in with LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </button>
                        
                        <button type="button" class="btn btn-social btn-facebook" id="facebookAuthBtn" title="Sign in with Facebook">
                            <i class="bi bi-facebook"></i>
                        </button>
                    </div>
                    
                    <div class="divider">
                        <span>or sign in with email</span>
                    </div>
                    
                    <!-- Login Form -->
                    <form method="POST" action="{{ route('learner.login') }}" id="loginForm">
                        @csrf
                        
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Enter your email"
                                   required 
                                   autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="password" class="form-label mb-0">Password</label>
                                <a href="{{ route('password.request') }}" class="text-primary-custom text-decoration-none small">
                                    Forgot password?
                                </a>
                            </div>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Enter your password"
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary-custom w-100 mb-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Sign In
                        </button>
                    </form>
                    
                    <!-- Magic Link Option -->
                    <div class="text-center mb-3">
                        <button type="button" class="btn btn-outline-secondary w-100" id="magicLinkBtn">
                            <i class="bi bi-envelope-fill me-2"></i>
                            Send Magic Link Instead
                        </button>
                    </div>
                    
                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-muted mb-0">
                            Don't have an account? 
                            <a href="{{ route('learner.register') }}" class="text-primary-custom fw-semibold">Create one now</a>
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
    
    <!-- Magic Link Modal -->
    <div class="modal fade" id="magicLinkModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-envelope-fill text-primary-custom me-2"></i>
                        Magic Link Login
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Enter your email address and we'll send you a secure link to sign in instantly.</p>
                    <form id="magicLinkForm">
                        <div class="mb-3">
                            <label for="magic_email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="magic_email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div id="magicLinkMessage"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary-custom" id="sendMagicLinkBtn">
                        <i class="bi bi-send me-2"></i>
                        Send Magic Link
                    </button>
                </div>
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
        
        // Magic Link Modal
        const magicLinkModal = new bootstrap.Modal(document.getElementById('magicLinkModal'));
        
        document.getElementById('magicLinkBtn').addEventListener('click', function() {
            magicLinkModal.show();
        });
        
        // Send Magic Link
        document.getElementById('sendMagicLinkBtn').addEventListener('click', function() {
            const email = document.getElementById('magic_email').value;
            const messageDiv = document.getElementById('magicLinkMessage');
            const sendBtn = this;
            
            if (!email) {
                messageDiv.innerHTML = '<div class="alert alert-danger">Please enter your email address.</div>';
                return;
            }
            
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
            
            // AJAX request to send magic link
            fetch('{{ route("auth.magic-link.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = '<div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>' + data.message + '</div>';
                    setTimeout(() => {
                        magicLinkModal.hide();
                        messageDiv.innerHTML = '';
                        document.getElementById('magic_email').value = '';
                    }, 3000);
                } else {
                    messageDiv.innerHTML = '<div class="alert alert-danger"><i class="bi bi-exclamation-circle me-2"></i>' + data.message + '</div>';
                }
            })
            .catch(error => {
                messageDiv.innerHTML = '<div class="alert alert-danger"><i class="bi bi-exclamation-circle me-2"></i>An error occurred. Please try again.</div>';
            })
            .finally(() => {
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<i class="bi bi-send me-2"></i>Send Magic Link';
            });
        });
    </script>
</body>
</html>
