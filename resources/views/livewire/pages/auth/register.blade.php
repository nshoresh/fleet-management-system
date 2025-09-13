<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Jobs\ProcessRegisteredUser; // You'll need to create this job
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $passwordStrength = '';
    public bool $showPassword = false;
    public bool $showPasswordConfirmation = false;

    /**
     * Calculate password strength and return appropriate color and message
     */
    public function calculatePasswordStrength(): array
    {
        if (empty($this->password)) {
            return [
                'color' => 'bg-gray-200',
                'width' => '0%',
                'text' => '',
                'textColor' => 'text-gray-500',
            ];
        }

        $length = strlen($this->password);
        $hasUppercase = preg_match('/[A-Z]/', $this->password);
        $hasLowercase = preg_match('/[a-z]/', $this->password);
        $hasDigits = preg_match('/\d/', $this->password);
        $hasSpecialChars = preg_match('/[^A-Za-z0-9]/', $this->password);

        $strength = 0;
        $strength += $length >= 8 ? 25 : round(($length / 8) * 25);
        $strength += $hasUppercase ? 25 : 0;
        $strength += $hasLowercase ? 25 : 0;
        $strength += $hasDigits || $hasSpecialChars ? 25 : 0;

        return match (true) {
            $strength < 25 => [
                'color' => 'bg-gradient-to-r from-red-500 to-red-600',
                'width' => '25%',
                'text' => 'Weak password',
                'textColor' => 'text-red-600',
            ],
            $strength < 50 => [
                'color' => 'bg-gradient-to-r from-orange-500 to-orange-600',
                'width' => '50%',
                'text' => 'Fair password',
                'textColor' => 'text-orange-600',
            ],
            $strength < 75 => [
                'color' => 'bg-gradient-to-r from-yellow-500 to-yellow-600',
                'width' => '75%',
                'text' => 'Good password',
                'textColor' => 'text-yellow-600',
            ],
            default => [
                'color' => 'bg-gradient-to-r from-green-500 to-green-600',
                'width' => '100%',
                'text' => 'Strong password',
                'textColor' => 'text-green-600',
            ],
        };
    }

    public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    public function togglePasswordConfirmation(): void
    {
        $this->showPasswordConfirmation = !$this->showPasswordConfirmation;
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role_id'] = 4;
        $validated['user_type_id'] = 2;
        $validated['account_status_id'] = 2;

        // Create the user
        $user = User::create($validated);

        // Dispatch the registered event processing to a queue job
        ProcessRegisteredUser::dispatch($user)->onQueue('sendMail');

        // Login the user immediately
        Auth::login($user);
        $this->redirect(RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div class="relative flex items-center justify-center min-h-screen px-4 py-12 overflow-hidden sm:px-6 lg:px-8">
    <!-- Subtle background pattern -->


    <div class="relative z-10 w-full max-w-3xl space-y-8">
        <!-- Header Section -->
        <div class="text-center">
            <div class="flex justify-center mb-8">
                <div class="relative">

                    <div class="w-20 h-20">
                        <x-application-logo-lg />
                    </div>
                </div>
            </div>
            <div class="space-y-3">
                <h1
                    class="text-4xl font-bold tracking-tight text-transparent bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 bg-clip-text">
                    Create Account
                </h1>
                <p class="text-base font-medium text-gray-600">Join us and start your journey today</p>
            </div>
        </div>

        <!-- Loading State -->


        <!-- Main Form Card -->
        <div class="relative group">
            <!-- Card glow effect -->
            <div
                class="absolute -inset-0.5 bg-gradient-to-r from-yellow-600 to-purple-600 rounded-3xl blur opacity-25 group-hover:opacity-40 transition duration-1000">
            </div>

            <div
                class="relative overflow-hidden shadow-2xl bg-white/80 backdrop-blur-xl rounded-3xl ring-1 ring-gray-200/50">
                <div class="px-10 py-12">
                    <form wire:submit="register" class="space-y-8">
                        <!-- Name -->
                        <div class="space-y-3">
                            <x-input-label for="name" :value="__('Full Name')"
                                class="text-sm font-semibold tracking-wide text-gray-800" />
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 z-10 flex items-center pl-5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 transition-all duration-300 group-focus-within:text-yellow-600"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <x-gold-text-input wire:model="name" id="name"
                                    class="block w-full py-4 pr-5 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70"
                                    type="text" name="name" required autofocus autocomplete="name"
                                    placeholder="Enter your full name" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm font-medium text-red-600" />
                        </div>

                        <!-- Email Address -->
                        <div class="space-y-3">
                            <x-input-label for="email" :value="__('Email Address')"
                                class="text-sm font-semibold tracking-wide text-gray-800" />
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 z-10 flex items-center pl-5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 transition-all duration-300 group-focus-within:text-yellow-600"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <x-gold-text-input wire:model.live.debounce.300ms="email" id="email"
                                    class="block w-full py-4 pr-5 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70"
                                    type="email" name="email" required autocomplete="username"
                                    placeholder="Enter your email address" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm font-medium text-red-600" />
                        </div>

                        <div class="space-y-3">
                            <x-input-label for="phone" :value="__('Phone Number')"
                                class="text-sm font-semibold tracking-wide text-gray-800" />
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 z-10 flex items-center pl-5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 transition-all duration-300 group-focus-within:text-yellow-600"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <x-gold-text-input wire:model.live.debounce.300ms="phone" id="phone"
                                    class="block w-full py-4 pr-5 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70"
                                    type="text" name="phone" required autocomplete="phone"
                                    placeholder="Enter your Phone number" />
                            </div>
                            <x-input-error :messages="$errors->get('phone')" class="mt-2 text-sm font-medium text-red-600" />
                        </div>

                        <!-- Password -->
                        <div class="space-y-3">
                            <x-input-label for="password" :value="__('Password')"
                                class="text-sm font-semibold tracking-wide text-gray-800" />
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 z-10 flex items-center pl-5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 transition-all duration-300 group-focus-within:text-yellow-600"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <x-gold-text-input wire:model.live="password" id="password" :type="$showPassword ? 'text' : 'password'"
                                    name="password"
                                    class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70"
                                    required autocomplete="new-password" placeholder="Create a strong password" />
                                <div class="absolute inset-y-0 right-0 z-10 flex items-center pr-5">
                                    <button type="button" wire:click="togglePassword"
                                        class="p-2 text-gray-400 transition-all duration-300 hover:text-yellow-600 focus:outline-none focus:text-yellow-600 rounded-xl hover:bg-yellow-100/70 focus:bg-yellow-50 focus:ring-2 focus:ring-yellow-500/20"
                                        aria-label="Toggle password visibility">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            @if ($showPassword)
                                                <path fill-rule="evenodd"
                                                    d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                                    clip-rule="evenodd" />
                                                <path
                                                    d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                            @else
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            @endif
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Enhanced Password Strength Indicator -->
                            @php
                                $strength = $this->calculatePasswordStrength();
                            @endphp
                            @if ($this->password)
                                <div class="mt-3 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-medium text-gray-600">Password strength</span>
                                        <span
                                            class="text-xs font-semibold {{ $strength['textColor'] }}">{{ $strength['text'] }}</span>
                                    </div>
                                    <div class="w-full h-2 overflow-hidden bg-gray-200 rounded-full">
                                        <div class="h-full rounded-full transition-all duration-500 ease-out {{ $strength['color'] }}"
                                            style="width: {{ $strength['width'] }}"></div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-500">
                                        <div class="flex items-center space-x-1">
                                            <div
                                                class="w-2 h-2 rounded-full {{ strlen($this->password) >= 8 ? 'bg-green-500' : 'bg-gray-300' }}">
                                            </div>
                                            <span>8+ characters</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <div
                                                class="w-2 h-2 rounded-full {{ preg_match('/[A-Z]/', $this->password) ? 'bg-green-500' : 'bg-gray-300' }}">
                                            </div>
                                            <span>Uppercase</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <div
                                                class="w-2 h-2 rounded-full {{ preg_match('/[a-z]/', $this->password) ? 'bg-green-500' : 'bg-gray-300' }}">
                                            </div>
                                            <span>Lowercase</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <div
                                                class="w-2 h-2 rounded-full {{ preg_match('/[\d\W]/', $this->password) ? 'bg-green-500' : 'bg-gray-300' }}">
                                            </div>
                                            <span>Number/Symbol</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm font-medium text-red-600" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-3">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                                class="text-sm font-semibold tracking-wide text-gray-800" />
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 z-10 flex items-center pl-5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 transition-all duration-300 group-focus-within:text-yellow-600"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <x-gold-text-input wire:model="password_confirmation" id="password_confirmation"
                                    :type="$showPasswordConfirmation ? 'text' : 'password'" name="password_confirmation"
                                    class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70"
                                    required autocomplete="new-password" placeholder="Confirm your password" />
                                <div class="absolute inset-y-0 right-0 z-10 flex items-center pr-5">
                                    <button type="button" wire:click="togglePasswordConfirmation"
                                        class="p-2 text-gray-400 transition-all duration-300 hover:text-gray-600 focus:outline-none focus:text-yellow-600 rounded-xl hover:bg-yellow-100/70 focus:bg-yellow-50 focus:ring-2 focus:ring-yellow-500/20"
                                        aria-label="Toggle password confirmation visibility">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            @if ($showPasswordConfirmation)
                                                <path fill-rule="evenodd"
                                                    d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                                    clip-rule="evenodd" />
                                                <path
                                                    d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                            @else
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            @endif
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm font-medium text-red-600" />
                        </div>

                        <!-- Register Button -->
                        <div class="pt-6">
                            <button type="submit"
                                class="group relative w-full flex justify-center py-4 px-6 border border-transparent text-base font-semibold rounded-2xl text-white bg-gradient-to-r from-yellow-600 via-yellow-700 to-orange-700 hover:from-yellow-500 hover:via-yellow-800 hover:to-orange-800 focus:outline-none focus:ring-4 focus:ring-yellow-500/30 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 active:translate-y-0 hover:scale-[1.02] active:scale-[0.98]"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-75 cursor-not-allowed transform-none">
                                <span wire:loading.remove class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 transition-opacity opacity-80 group-hover:opacity-100"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                    {{ __('Create Account') }}
                                </span>
                                <span wire:loading class="flex items-center">
                                    <div
                                        class="w-5 h-5 mr-3 border-2 rounded-full border-white/30 border-t-white animate-spin">
                                    </div>
                                    <span>{{ __('Creating Account...') }}</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <p class="text-base text-gray-600">
                {{ __('Already have an account?') }}
                <a href="{{ route('login') }}" wire:navigate
                    class="inline-block px-3 py-2 ml-1 font-semibold text-yellow-600 transition-all duration-200 hover:text-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500/20 focus:ring-offset-2 rounded-xl hover:bg-yellow-50">
                    {{ __('Sign in instead') }}
                </a>
            </p>
        </div>
    </div>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        .bg-grid-pattern {
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
    </style>
</div>
