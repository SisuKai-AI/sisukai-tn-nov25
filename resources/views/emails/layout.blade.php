<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SisuKai</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 20px;
            text-align: center;
        }
        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #ffffff;
            text-decoration: none;
            letter-spacing: 1px;
        }
        .content {
            padding: 40px 30px;
        }
        .content h1 {
            color: #667eea;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .content p {
            margin-bottom: 15px;
            color: #51545e;
        }
        .button {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .button:hover {
            opacity: 0.9;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            background-color: #f4f4f7;
            padding: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #6b7280;
            text-decoration: none;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <a href="{{ config('app.url') }}" class="logo">SisuKai</a>
        </div>

        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="social-links">
                <a href="#">Twitter</a> •
                <a href="#">LinkedIn</a> •
                <a href="#">Facebook</a>
            </div>
            <p>
                <strong>SisuKai</strong><br>
                Your Partner in Certification Success
            </p>
            <p>
                <a href="{{ route('landing.help.index') }}">Help Center</a> •
                <a href="{{ route('landing.contact') }}">Contact Us</a> •
                <a href="#">Unsubscribe</a>
            </p>
            <p style="color: #9ca3af; font-size: 12px; margin-top: 20px;">
                © {{ date('Y') }} SisuKai. All rights reserved.<br>
                This email was sent to {{ $email ?? 'you' }} because you have an account with SisuKai.
            </p>
        </div>
    </div>
</body>
</html>
