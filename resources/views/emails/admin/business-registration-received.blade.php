<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Registration Submitted</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .header .icon {
            font-size: 48px;
            margin-bottom: 16px;
            display: block;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            margin-bottom: 24px;
            color: #2d3748;
        }

        .success-message {
            background-color: #f0fff4;
            border-left: 4px solid #48bb78;
            padding: 20px;
            margin: 24px 0;
            border-radius: 6px;
        }

        .success-message h2 {
            color: #2f855a;
            margin: 0 0 12px 0;
            font-size: 20px;
        }

        .success-message p {
            color: #2f855a;
            margin: 0;
            font-size: 16px;
        }

        .details-section {
            background-color: #f7fafc;
            border-radius: 8px;
            padding: 24px;
            margin: 24px 0;
        }

        .details-section h3 {
            color: #2d3748;
            margin: 0 0 16px 0;
            font-size: 18px;
            font-weight: 600;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #4a5568;
            flex: 1;
        }

        .detail-value {
            color: #2d3748;
            flex: 2;
            text-align: right;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            background-color: #fef5e7;
            color: #c05621;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .next-steps {
            background-color: #ebf8ff;
            border-left: 4px solid #4299e1;
            padding: 20px;
            margin: 24px 0;
            border-radius: 6px;
        }

        .next-steps h3 {
            color: #2b6cb0;
            margin: 0 0 12px 0;
            font-size: 18px;
        }

        .next-steps ul {
            color: #2c5282;
            margin: 12px 0;
            padding-left: 20px;
        }

        .next-steps li {
            margin-bottom: 8px;
        }

        .contact-section {
            background-color: #f7fafc;
            border-radius: 8px;
            padding: 24px;
            margin: 24px 0;
            text-align: center;
        }

        .contact-section h3 {
            color: #2d3748;
            margin: 0 0 16px 0;
            font-size: 18px;
        }

        .contact-info {
            color: #4a5568;
            font-size: 16px;
            line-height: 1.5;
        }

        .contact-info a {
            color: #4299e1;
            text-decoration: none;
            font-weight: 600;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        .footer {
            background-color: #2d3748;
            color: #a0aec0;
            padding: 30px;
            text-align: center;
            font-size: 14px;
        }

        .footer p {
            margin: 8px 0;
        }

        .footer a {
            color: #63b3ed;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .reference-number {
            font-family: 'Courier New', monospace;
            background-color: #edf2f7;
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: bold;
            color: #2d3748;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .header,
            .content,
            .contact-section {
                padding: 20px;
            }

            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }

            .detail-value {
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <span class="icon">✅</span>
            <h1>Registration Submitted</h1>
        </div>

        <div class="content">
            <div class="greeting">
                Hello <strong>{{ $business->name }}</strong>,
            </div>

            <div class="success-message">
                <h2>Registration Successfully Submitted!</h2>
                <p>Your business registration has been received and is currently being processed by our team.</p>
            </div>

            <p>Thank you for registering your business with {{ $appName }}. We have received your application and
                all required documents. Below are the details of your submission:</p>

            <div class="details-section">
                <h3>Registration Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Business Name:</span>
                    <span class="detail-value">{{ $business->business_name }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Registration Number:</span>
                    <span class="detail-value">{{ $business->business_registration_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Registration Date:</span>
                    <span
                        class="detail-value">{{ \Carbon\Carbon::parse($business->registration_date)->format('F j, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Submitted On:</span>
                    <span class="detail-value">{{ $business->created_at->format('F j, Y \a\t g:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Current Status:</span>
                    <span class="detail-value">
                        <span class="status-badge">{{ ucfirst($business->status) }}</span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Reference Number:</span>
                    <span class="detail-value">
                        <span class="reference-number">{{ $business->uuid }}</span>
                    </span>
                </div>
            </div>

            <div class="next-steps">
                <h3>What Happens Next?</h3>
                <ul>
                    <li><strong>Document Review:</strong> Our team will review all submitted documents within 3-5
                        business days</li>
                    <li><strong>Verification Process:</strong> We may contact you if additional information or documents
                        are required</li>
                    <li><strong>Approval Notification:</strong> You will receive an email notification once your
                        registration is approved</li>
                    <li><strong>Account Access:</strong> Upon approval, you will receive login credentials to access
                        your vehicle owner portal</li>
                </ul>
                <p><strong>Please keep your reference number safe</strong> - you may need it for future correspondence.
                </p>
            </div>

            <p>We appreciate your patience during the review process. If your application is approved, you will be able
                to:</p>
            <ul>
                <li>Register and manage vehicle information</li>
                <li>Access digital certificates and documentation</li>
                <li>Update business and contact information</li>
                <li>Track vehicle registration status</li>
            </ul>
        </div>

        <div class="contact-section">
            <h3>Need Help?</h3>
            <div class="contact-info">
                <p>If you have any questions about your registration or need assistance, please don't hesitate to
                    contact our support team:</p>
                <p>

                    <strong>Phone:</strong> <a href="tel:+1234567890">+1 (234) 567-8900</a><br>
                    <strong>Hours:</strong> Monday - Friday, 9:00 AM - 5:00 PM
                </p>
                <p>Please include your reference number <strong>{{ $business->uuid }}</strong> in any correspondence.
                </p>
            </div>
        </div>

        <div class="footer">
            <p><strong>{{ $appName }}</strong></p>
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>
                <a href="{{ $appUrl }}">Visit our website</a> |
                <a href="{{ $appUrl }}/privacy">Privacy Policy</a> |
                <a href="{{ $appUrl }}/terms">Terms of Service</a>
            </p>
            <p>&copy; {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
