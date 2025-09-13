<div>
    <!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->

    {{--   Account verification Email Template --}}.

    <div class="max-w-lg p-6 mx-auto mt-10 bg-white rounded-lg shadow-md">
        <h1 class="mb-4 text-2xl font-bold text-center">Verify Your Account</h1>
        <p class="mb-4 text-gray-700">Hello {{ $user->name }},</p>
        <p class="mb-4 text-gray-700">Thank you for registering with us! To complete your registration, please verify
            your email address by clicking the button below:</p>
        <a href="{{ $verificationUrl }}"
            class="px-4 py-2 text-white transition duration-200 bg-blue-500 rounded hover:bg-blue-600">Verify Email
            Address</a>
        <p class="mt-4 text-gray-700">If you did not create an account, no further action is required.</p>
        <p class="mt-4 text-gray-700">Best regards,<br>Your Company Name</p>
        <p class="mt-4 text-gray-700">This email was sent to {{ $user->email }}. If you have any questions or concerns,
            please contact us at <a href="mailto:support@example.com">support@example.com</a>.</p>
    </div>
</div>
