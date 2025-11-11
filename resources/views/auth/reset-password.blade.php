<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SisuKai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --primary-color: #696cff; --primary-hover: #5f61e6; }
        body { background-color: #f5f5f9; min-height: 100vh; display: flex; align-items: center; }
        .auth-card { max-width: 450px; margin: 2rem auto; }
        .card { border: none; box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12); border-radius: 0.5rem; }
        .btn-primary-custom { background-color: var(--primary-color); border-color: var(--primary-color); color: white; }
        .btn-primary-custom:hover { background-color: var(--primary-hover); border-color: var(--primary-hover); }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.25); }
        .text-primary-custom { color: var(--primary-color) !important; }
        .logo { font-size: 1.5rem; font-weight: 700; color: var(--primary-color); }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-card">
            <div class="card">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <a href="{{ route('landing.home') }}" class="logo text-decoration-none">
                            <i class="bi bi-mortarboard-fill"></i> SisuKai
                        </a>
                    </div>
                    <div class="text-center mb-4">
                        <h4 class="mb-2">Reset Password 🔐</h4>
                        <p class="text-muted">Enter your new password below</p>
                    </div>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autofocus>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100 mb-3">
                            <i class="bi bi-check-circle me-2"></i>Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>