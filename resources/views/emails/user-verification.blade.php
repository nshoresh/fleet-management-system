<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }

        .btn {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #218838;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            color: #6c757d;
        }

        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Welcome to Our Platform!</h1>
    </div>
    <div class="content">
        <h2>Hello {{ $user->name }}!</h2>
        <p>Thank you for creating an accont with us. To complete your registration, please verify your email address by
            clicking the button below:</p>
        <div style="text-align: center;">
            <a href="{{ $verificationUrl }}" class="btn">Verify Email Address</a>
        </div>
        <p>If the button above doesn't work, you can copy and paste the following link into your browser:</p>
        <p style="word-break: break-all; background-color: #e9ecef; padding: 10px; border-radius: 3px;">
            {{ $verificationUrl }}
        </p>
        <div class="warning">
            <strong>Important:</strong> This verification link will expire in 60 minutes for security reasons.
        </div>
        <p>If you didn't create an account with us, please ignore this email.</p>
        <p>Best regards,<br>
            The Team</p>
    </div>
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>If you're having trouble with the verification link, please contact our support team.</p>
    </div>
</body>

</html>
