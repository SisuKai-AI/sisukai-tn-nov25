<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication Code</title>
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
        .code-container {
            background-color: #fff;
            border: 2px dashed #696cff;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
        }
        .code {
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 8px;
            color: #696cff;
            font-family: 'Courier New', monospace;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #696cff;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
        }
        .btn:hover {
            background-color: #5f61e6;
        }
        .divider {
            text-align: center;
            margin: 30px 0;
            color: #6c757d;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🎓 SisuKai</div>
            <h2 style="color: #333; margin-top: 10px;">Two-Factor Authentication</h2>
        </div>

        <p>Hello, <strong>{{ $userName }}</strong>!</p>

        <p>You are attempting to sign in to your SisuKai account. To complete the login process, please enter the verification code below:</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $verificationUrl }}" class="btn">✓ Verify with One Click</a>
        </div>

        <div class="divider">
            <p>Or enter this code manually:</p>
        </div>

        <div class="code-container">
            <div class="code">{{ $code }}</div>
        </div>

        <p style="text-align: center; color: #6c757d;">
            This code is valid for <strong>{{ $expiresInMinutes }} minutes</strong>.
        </p>

        <div class="warning">
            <strong>⚠️ Security Notice:</strong> If you did not attempt to sign in, please ignore this email and consider changing your password immediately.
        </div>

        <p>For your security, never share this code with anyone. SisuKai staff will never ask you for your verification code.</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} SisuKai. All rights reserved.</p>
            <p style="font-size: 12px; color: #999;">
                This is an automated message. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html>
