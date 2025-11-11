<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 30px;
            margin: 20px 0;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #696cff;
        }
        .btn {
            display: inline-block;
            padding: 14px 40px;
            background-color: #696cff;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #5f61e6;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box {
            background-color: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
        }
        .link-box {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            word-break: break-all;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🎓 SisuKai</div>
            <h2 style="color: #333; margin-top: 10px;">Reset Your Password</h2>
        </div>

        <p>Hello, <strong>{{ $userName }}</strong>!</p>

        <p>You are receiving this email because we received a password reset request for your SisuKai account.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $resetUrl }}" class="btn">🔐 Reset Password</a>
        </div>

        <div class="info-box">
            <strong>ℹ️ Important:</strong> This password reset link will expire in <strong>{{ $expiresInMinutes }} minutes</strong>.
        </div>

        <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:</p>

        <div class="link-box">
            {{ $resetUrl }}
        </div>

        <div class="warning">
            <strong>⚠️ Security Notice:</strong> If you did not request a password reset, no further action is required. Your password will remain unchanged.
        </div>

        <p>For your security, never share your password or reset links with anyone. SisuKai staff will never ask you for your password.</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} SisuKai. All rights reserved.</p>
            <p style="font-size: 12px; color: #999;">
                This is an automated message. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html>
