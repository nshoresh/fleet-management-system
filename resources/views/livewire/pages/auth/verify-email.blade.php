<?php

use App\Livewire\Actions\Logout;
use App\Providers\RouteServiceProvider;

use App\Jobs\ProcessRegisteredUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header Section -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">
                {{ __('Verify Your Email') }}
            </h2>
            <p class="text-sm text-gray-600 max-w-sm mx-auto leading-relaxed">
                {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking the link we sent to you.') }}
            </p>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white shadow-xl rounded-lg p-8 border border-gray-100">

            <!-- Success Message -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-600 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-medium text-green-800">
                            {{ __('Verification email sent! Check your inbox.') }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Email Info -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="h-5 w-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-medium mb-1">{{ __('Email sent to:') }}</p>
                        <p class="text-blue-700">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-4">
                <!-- Primary Action -->
                <x-gold-button wire:click="sendVerification"
                    class="w-full justify-center py-3 px-4 text-sm font-medium rounded-lg transition-all duration-200 hover:shadow-lg focus:ring-4 focus:ring-opacity-50">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    {{ __('Resend Verification Email') }}
                </x-gold-button>

                <!-- Secondary Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <button wire:click="logout" type="button"
                        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 rounded-md px-2 py-1">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        {{ __('Sign Out') }}
                    </button>

                    <a href="mailto:{{ Auth::user()->email }}"
                        class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-md px-2 py-1">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ __('Open Email App') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Help Text -->
        <div class="text-center">
            <p class="text-xs text-gray-500 leading-relaxed">
                {{ __('Didn\'t receive the email? Check your spam folder or') }}
                <button wire:click="sendVerification"
                    class="text-blue-600 hover:text-blue-800 font-medium underline focus:outline-none">
                    {{ __('try again') }}
                </button>
            </p>
        </div>
    </div>
</div>
