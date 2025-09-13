<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Required</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .email-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .content {
            padding: 40px 30px;
        }

        .verification-code {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            padding: 25px;
            border-radius: 8px;
            margin: 25px 0;
            letter-spacing: 4px;
            font-family: 'Courier New', monospace;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 25px;
            margin: 20px 0;
            font-weight: bold;
            transition: transform 0.2s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .info-box {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 20px;
            border-radius: 0 8px 8px 0;
            margin: 25px 0;
        }

        .info-box h3 {
            margin: 0 0 10px 0;
            color: #1976d2;
            font-size: 18px;
        }

        .info-box ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        .info-box li {
            margin: 8px 0;
        }

        .steps {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }

        .steps h3 {
            margin: 0 0 15px 0;
            color: #495057;
        }

        .steps ol {
            margin: 0;
            padding-left: 20px;
        }

        .steps li {
            margin: 10px 0;
            font-weight: 500;
        }

        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }

        .warning strong {
            color: #dc3545;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 25px 30px;
            border-top: 1px solid #dee2e6;
            font-size: 14px;
            color: #6c757d;
            text-align: center;
        }

        .footer a {
            color: #667eea;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .company-name {
            font-weight: bold;
            color: #495057;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .content {
                padding: 25px 20px;
            }

            .verification-code {
                font-size: 24px;
                letter-spacing: 2px;
            }

            .header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>Email Verification Required</h1>
        </div>

        <div class="content">
            <p><strong>Hello,</strong></p>

            <p>You have requested to verify your email address for <strong>{{ $appName ?? 'Our Platform' }}</strong>
                business registration.</p>

            <div class="verification-code">
                {{ $verificationCode ?? 'ABC123' }}
            </div>

            <div class="info-box">
                <h3>Important Details:</h3>
                <ul>
                    <li>This code will expire in <strong>{{ $expiryMinutes ?? '15' }} minutes</strong></li>
                    <li>Enter this code exactly as shown (case-sensitive)</li>
                    <li>Do not share this code with anyone</li>
                </ul>
            </div>

            <div class="steps">
                <h3>What's Next?</h3>
                <ol>
                    <li>Return to the registration form</li>
                    <li>Enter the verification code above</li>
                    <li>Complete your business registration</li>
                </ol>
            </div>

            <div style="text-align: center;">
                <a href="{{ $verificationUrl ?? '#' }}" class="btn">Verify Email Address</a>
            </div>

            <div class="warning">
                <strong>Security Notice:</strong> If you didn't request this verification code, please ignore this
                email. Your account security has not been compromised.
            </div>

            <p>Best regards,<br>
                <span class="company-name">{{ $companyName ?? 'The Team' }}</span>
            </p>
        </div>

        <div class="footer">
            <p>Need help? Contact our support team at
                <a
                    href="mailto:{{ $supportEmail ?? 'support@example.com' }}">{{ $supportEmail ?? 'support@example.com' }}</a>
            </p>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>

</html>
