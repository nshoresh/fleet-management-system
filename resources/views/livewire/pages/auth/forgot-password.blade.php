<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $email = '';
    public bool $isLoading = false;

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->isLoading = true;

        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink($this->only('email'));

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            $this->isLoading = false;
            return;
        }

        $this->reset('email');
        $this->isLoading = false;

        session()->flash('status', __($status));
    }
}; ?>

<div
    class="flex items-center justify-center min-h-screen px-4 py-12 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 sm:px-6 lg:px-8 rounded-3xl">
    <div class="w-full max-w-3xl space-y-8">
        <!-- Header Section -->
        <div class="text-center">
            <div class="flex items-center justify-center w-20 h-20 mx-auto bg-white shadow-lg rounded-2xl">
                <x-application-logo-lg />
            </div>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                {{ __('Reset Your Password') }}
            </h2>
            <p class="max-w-sm mx-auto mt-2 text-sm leading-relaxed text-gray-600">
                {{ __('Enter your email address and we\'ll send you a secure link to reset your password.') }}
            </p>
        </div>

        <!-- Main Card -->
        <div class="p-8 space-y-6 bg-white border border-gray-100 shadow-xl rounded-3xl">
            <!-- Success Message -->
            @if (session('status'))
                <div class="flex items-start p-4 space-x-3 border border-green-200 bg-green-50 rounded-2xl">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-green-800">{{ session('status') }}</p>
                        <p class="mt-1 text-xs text-green-600">Check your email inbox and spam folder.</p>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form wire:submit="sendPasswordResetLink" class="space-y-6">
                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-gray-700">
                        {{ __('Email Address') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                </path>
                            </svg>
                        </div>
                        <input wire:model="email" id="email" type="email" name="email" required autofocus
                            placeholder="Enter your email address"
                            class="block w-full pl-12 pr-4 py-4 text-base text-gray-900 placeholder-gray-400 bg-gray-50 border-2 border-gray-200 rounded-2xl transition-all duration-300 focus:border-yellow-500 focus:bg-white focus:ring-4 focus:ring-yellow-500/20 hover:border-gray-300 hover:bg-white/70 @error('email') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                    </div>
                    @error('email')
                        <div class="flex items-center p-3 space-x-2 border border-red-200 bg-red-50 rounded-xl">
                            <svg class="flex-shrink-0 w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm text-red-700">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full flex  justify-between px-6 py-4 text-base font-semibold text-white text-center bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-2xl shadow-lg hover:from-yellow-700 hover:to-yellow-800 focus:outline-none focus:ring-4 focus:ring-yellow-500/30 transform transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                    <span wire:loading.remove class="flex">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ __('Send Reset Link') }}
                    </span>
                    <span wire:loading class="flex">
                        <svg class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        {{ __('Sending...') }}
                    </span>
                </button>
            </form>

            <!-- Footer Links -->
            <div class="pt-4 text-center border-t border-gray-100">
                <p class="text-sm text-gray-600">
                    {{ __('Remember your password?') }}
                    <a href="{{ route('login') }}"
                        class="font-semibold text-yellow-600 transition-colors duration-200 hover:text-yellow-500">
                        {{ __('Sign in here') }}
                    </a>
                </p>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="text-center">
            <p class="max-w-sm mx-auto text-xs leading-relaxed text-gray-500">
                {{ __('This is a secure password reset process. The link will expire in 60 minutes for your security.') }}
            </p>
        </div>
    </div>
</div>
