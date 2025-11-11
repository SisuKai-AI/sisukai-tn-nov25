<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #696cff;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #696cff;
        }
        .content {
            padding: 30px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #696cff;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px 0;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
        .info-box {
            background-color: #e7f3ff;
            border-left: 4px solid #2196f3;
            padding: 12px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">🎓 SisuKai</div>
    </div>
    
    <div class="content">
        <h2>Welcome to SisuKai{{ $learnerName ? ', ' . $learnerName : '' }}!</h2>
        
        <p>Thank you for creating an account with SisuKai. We're excited to help you ace your certification exams!</p>
        
        <p>To get started, please verify your email address by clicking the button below:</p>
        
        <center>
            <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
        </center>
        
        <p>Or copy and paste this link into your browser:</p>
        <p style="word-break: break-all; background-color: #f5f5f5; padding: 10px; border-radius: 5px;">
            {{ $verificationUrl }}
        </p>
        
        <div class="info-box">
            <strong>📚 What's Next?</strong><br>
            Once your email is verified, you'll be able to:
            <ul>
                <li>Browse and enroll in certification programs</li>
                <li>Take practice exams and benchmark tests</li>
                <li>Track your progress and performance</li>
                <li>Access personalized study recommendations</li>
            </ul>
        </div>
        
        <p>If you didn't create an account with SisuKai, please ignore this email.</p>
        
        <p>Happy learning!<br>
        The SisuKai Team</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} SisuKai. All rights reserved.</p>
        <p>This is an automated email. Please do not reply to this message.</p>
    </div>
</body>
</html>
