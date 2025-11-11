<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - SisuKai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --primary-color: #696cff; }
        body { background-color: #f5f5f9; min-height: 100vh; display: flex; align-items: center; }
        .auth-card { max-width: 450px; margin: 2rem auto; }
        .card { border: none; box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12); border-radius: 0.5rem; }
        .btn-primary-custom { background-color: var(--primary-color); border-color: var(--primary-color); color: white; }
        .logo { font-size: 1.5rem; font-weight: 700; color: var(--primary-color); }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-card">
            <div class="card">
                <div class="card-body p-4 p-md-5 text-center">
                    <div class="mb-4">
                        <i class="bi bi-envelope-check text-primary-custom" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="mb-3">Verify Your Email Address</h4>
                    <p class="text-muted mb-4">We've sent a verification link to your email. Please check your inbox and click the link to verify your account.</p>
                    @if(session('resent'))
                        <div class="alert alert-success">A fresh verification link has been sent to your email address.</div>
                    @endif
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary-custom w-100 mb-3">
                            <i class="bi bi-arrow-clockwise me-2"></i>Resend Verification Email
                        </button>
                    </form>
                    <a href="{{ route('learner.dashboard') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-house me-2"></i>Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>