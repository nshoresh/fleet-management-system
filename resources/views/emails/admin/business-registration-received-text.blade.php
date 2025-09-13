BUSINESS REGISTRATION SUBMITTED SUCCESSFULLY
=============================================

Hello {{ $business->name }},

Thank you for registering your business with {{ $appName }}. We have successfully received your application and all
required documents.

REGISTRATION DETAILS
-------------------
Business Name: {{ $business->name }}
Business Type: {{ ucwords(str_replace('_', ' ', $business->type)) }}
Registration Number: {{ $business->registration_number }}
Registration Date: {{ \Carbon\Carbon::parse($business->registration_date)->format('F j, Y') }}
Submitted On: {{ $business->created_at->format('F j, Y \a\t g:i A') }}
Current Status: {{ ucfirst($business->status) }}
Reference Number: {{ $business->uuid }}

WHAT HAPPENS NEXT?
-----------------
1. DOCUMENT REVIEW: Our team will review all submitted documents within 3-5 business days

2. VERIFICATION PROCESS: We may contact you if additional information or documents are required

3. APPROVAL NOTIFICATION: You will receive an email notification once your registration is approved

4. ACCOUNT ACCESS: Upon approval, you will receive login credentials to access your vehicle owner portal

IMPORTANT: Please keep your reference number ({{ $business->uuid }}) safe - you may need it for future correspondence.

BENEFITS AFTER APPROVAL
----------------------
Once your application is approved, you will be able to:
• Register and manage vehicle information
• Access digital certificates and documentation
• Update business and contact information
• Track vehicle registration status

NEED HELP?
----------
If you have any questions about your registration or need assistance, please contact our support team:


Phone: +1 (234) 567-8900
Hours: Monday - Friday, 9:00 AM - 5:00 PM

Please include your reference number {{ $business->uuid }} in any correspondence.

---
{{ $appName }}
{{ $appUrl }}

This is an automated message. Please do not reply to this email.

© {{ date('Y') }} {{ $appName }}. All rights reserved.
