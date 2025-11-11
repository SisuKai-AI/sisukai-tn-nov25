<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Step Verification - SisuKai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --primary-color: #696cff; }
        body { background-color: #f5f5f9; min-height: 100vh; display: flex; align-items: center; }
        .auth-card { max-width: 450px; margin: 2rem auto; }
        .card { border: none; box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12); border-radius: 0.5rem; }
        .btn-primary-custom { background-color: var(--primary-color); border-color: var(--primary-color); color: white; }
        .logo { font-size: 1.5rem; font-weight: 700; color: var(--primary-color); }
        .code-input { width: 3rem; height: 3rem; text-align: center; font-size: 1.5rem; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-card">
            <div class="card">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-shield-lock text-primary-custom" style="font-size: 3rem;"></i>
                    </div>
                    <div class="text-center mb-4">
                        <h4 class="mb-2">Two-Step Verification</h4>
                        <p class="text-muted">Enter the 6-digit code we sent to your email</p>
                    </div>
                    <form method="POST" action="{{ route('two-factor.verify') }}">
                        @csrf
                        <div class="d-flex justify-content-center gap-2 mb-4">
                            <input type="text" class="form-control code-input" maxlength="1" name="code[]" required>
                            <input type="text" class="form-control code-input" maxlength="1" name="code[]" required>
                            <input type="text" class="form-control code-input" maxlength="1" name="code[]" required>
                            <input type="text" class="form-control code-input" maxlength="1" name="code[]" required>
                            <input type="text" class="form-control code-input" maxlength="1" name="code[]" required>
                            <input type="text" class="form-control code-input" maxlength="1" name="code[]" required>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100 mb-3">Verify Code</button>
                    </form>
                    <div class="text-center">
                        <p class="text-muted mb-0">Didn't receive the code? <a href="#" class="text-primary-custom">Resend</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const inputs = document.querySelectorAll('.code-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    </script>
</body>
</html>