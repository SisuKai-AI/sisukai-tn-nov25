<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Magic Login Link</title>
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
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
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
        <h2>Hello{{ $learnerName ? ', ' . $learnerName : '' }}!</h2>
        
        <p>You requested a magic link to sign in to your SisuKai account. Click the button below to log in instantly:</p>
        
        <center>
            <a href="{{ $magicLink }}" class="button">Sign In to SisuKai</a>
        </center>
        
        <p>Or copy and paste this link into your browser:</p>
        <p style="word-break: break-all; background-color: #f5f5f5; padding: 10px; border-radius: 5px;">
            {{ $magicLink }}
        </p>
        
        <div class="warning">
            <strong>⚠️ Security Notice:</strong><br>
            This magic link will expire in <strong>{{ $expiresInMinutes }} minutes</strong> and can only be used once. 
            If you didn't request this link, please ignore this email.
        </div>
        
        <p>Happy learning!<br>
        The SisuKai Team</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} SisuKai. All rights reserved.</p>
        <p>This is an automated email. Please do not reply to this message.</p>
    </div>
</body>
</html>
