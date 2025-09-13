<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $isLoading = false;
    public bool $showPassword = false;
    public bool $showPasswordConfirmation = false;

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->isLoading = true;

        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset($this->only('email', 'password', 'password_confirmation', 'token'), function ($user) {
            $user
                ->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])
                ->save();

            event(new PasswordReset($user));
        });

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            $this->isLoading = false;
            return;
        }

        Session::flash('status', __($status));
        $this->redirectRoute('login', navigate: true);
    }

    public function togglePasswordVisibility($field)
    {
        if ($field === 'password') {
            $this->showPassword = !$this->showPassword;
        } else {
            $this->showPasswordConfirmation = !$this->showPasswordConfirmation;
        }
    }
}; ?>

<div
    class="flex items-center justify-center min-h-screen px-4 py-12 bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50 sm:px-6 lg:px-8">
    <div class="w-full max-w-4xl space-y-8">
        <!-- Header Section -->
        <div class="text-center">
            <div
                class="flex items-center justify-center w-16 h-16 mx-auto shadow-lg bg-gradient-to-r from-yellow-500 to-amber-600 rounded-2xl">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                {{ __('Set New Password') }}
            </h2>
            <p class="max-w-sm mx-auto mt-2 text-sm leading-relaxed text-gray-600">
                {{ __('Create a strong, secure password for your account.') }}
            </p>
        </div>

        <!-- Main Card -->
        <div class="p-8 space-y-6 bg-white border border-yellow-100 shadow-xl rounded-3xl">
            <form wire:submit="resetPassword" class="space-y-6">
                <!-- Email Field (Read-only) -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-gray-700">
                        {{ __('Email Address') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                </path>
                            </svg>
                        </div>
                        <input wire:model="email" id="email" type="email" name="email" required autofocus
                            readonly
                            class="block w-full py-4 pl-12 pr-4 text-base text-gray-700 border-2 border-yellow-300 opacity-75 cursor-not-allowed bg-gray-50 rounded-2xl">
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

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-gray-700">
                        {{ __('New Password') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <x-gold-text-input wire:model="password" id="password"
                            type="{{ $showPassword ? 'text' : 'password' }}" name="password" required
                            placeholder="Enter your new password"
                            class="block w-full pl-12 pr-12 py-4 text-base text-gray-900 placeholder-gray-400 bg-gray-50 border-2 border-yellow-300 rounded-2xl transition-all duration-300 focus:border-yellow-500 focus:bg-white focus:ring-4 focus:ring-yellow-500/20 hover:border-yellow-400 hover:bg-white/70 @error('password') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                            <button type="button" wire:click="togglePasswordVisibility('password')"
                                class="absolute inset-y-0 right-0 flex items-center pr-4">
                                @if ($showPassword)
                                    <svg class="w-5 h-5 text-gray-400 transition-colors hover:text-amber-500"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                        </path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-400 transition-colors hover:text-amber-500"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                @endif
                            </button>
                    </div>
                    @error('password')
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

                <!-- Confirm Password Field -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                        {{ __('Confirm New Password') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <input wire:model="password_confirmation" id="password_confirmation"
                            type="{{ $showPasswordConfirmation ? 'text' : 'password' }}" name="password_confirmation"
                            required placeholder="Confirm your new password"
                            class="block w-full pl-12 pr-12 py-4 text-base text-gray-900 placeholder-gray-400 bg-gray-50 border-2 border-yellow-300 rounded-2xl transition-all duration-300 focus:border-yellow-500 focus:bg-white focus:ring-4 focus:ring-yellow-500/20 hover:border-yellow-400 hover:bg-white/70 @error('password_confirmation') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror">
                        <button type="button" wire:click="togglePasswordVisibility('password_confirmation')"
                            class="absolute inset-y-0 right-0 flex items-center pr-4">
                            @if ($showPasswordConfirmation)
                                <svg class="w-5 h-5 text-gray-400 transition-colors hover:text-amber-500"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                    </path>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-400 transition-colors hover:text-amber-500"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            @endif
                        </button>
                    </div>
                    @error('password_confirmation')
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

                <!-- Password Requirements -->
                <div class="p-4 border bg-amber-50 border-amber-200 rounded-xl">
                    <h4 class="flex items-center mb-2 text-sm font-semibold text-amber-800">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ __('Password Requirements') }}
                    </h4>
                    <ul class="space-y-1 text-xs text-amber-700">
                        <li class="flex items-center">
                            <span class="w-1 h-1 mr-2 rounded-full bg-amber-500"></span>
                            {{ __('At least 8 characters long') }}
                        </li>
                        <li class="flex items-center">
                            <span class="w-1 h-1 mr-2 rounded-full bg-amber-500"></span>
                            {{ __('Contains uppercase and lowercase letters') }}
                        </li>
                        <li class="flex items-center">
                            <span class="w-1 h-1 mr-2 rounded-full bg-amber-500"></span>
                            {{ __('Includes at least one number') }}
                        </li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full flex items-center justify-center px-6 py-4 text-base font-semibold text-white bg-gradient-to-r from-yellow-500 to-amber-600 rounded-2xl shadow-lg hover:from-yellow-600 hover:to-amber-700 focus:outline-none focus:ring-4 focus:ring-yellow-500/30 transform transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                    <span wire:loading.remove>
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('Reset Password') }}
                    </span>
                    <span wire:loading class="flex items-center">
                        <svg class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        {{ __('Resetting Password...') }}
                    </span>
                </button>
            </form>

            <!-- Footer Links -->
            <div class="pt-4 text-center border-t border-gray-100">
                <p class="text-sm text-gray-600">
                    {{ __('Remember your password?') }}
                    <a href="{{ route('login') }}"
                        class="font-semibold transition-colors duration-200 text-amber-600 hover:text-amber-500">
                        {{ __('Sign in here') }}
                    </a>
                </p>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="text-center">
            <p class="max-w-sm mx-auto text-xs leading-relaxed text-gray-500">
                {{ __('Your password will be encrypted and stored securely. This reset link will expire after use.') }}
            </p>
        </div>
    </div>
</div>
