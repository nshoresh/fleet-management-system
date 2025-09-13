<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;
    public bool $showPassword = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        try {
            $this->form->authenticate();
            Session::regenerate();
            $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
        } catch (\Exception $e) {
            $this->addError('form.email', __('These credentials do not match our records.'));
        }
    }

    public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }
}; ?>


<div>
    <div>

        <div class="relative max-w-2xl mx-auto space-y-8">
            <!-- Header Section -->
            <div class="text-center">
                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <div
                            class="absolute inset-0 opacity-25 bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl blur-lg animate-pulse">
                        </div>

                    </div>
                    <div class="flex items-center justify-center w-20 h-20 mx-auto bg-white shadow-lg rounded-2xl">
                        <x-application-logo-lg />
                    </div>
                </div>
                <div class="space-y-3">
                    <h1
                        class="text-4xl font-bold tracking-tight text-transparent bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 bg-clip-text">
                        Welcome back
                    </h1>
                    <p class="text-base font-medium text-gray-600">Sign in to continue to your account</p>
                </div>
            </div>
            <!-- Main Form Card -->
            <div class="relative group">
                <!-- Card glow effect -->
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-gray-600 to-gray-800 rounded-3xl blur opacity-25 group-hover:opacity-40 transition duration-1000">
                </div>

                <div
                    class="relative overflow-hidden shadow-2xl bg-white/80 backdrop-blur-xl rounded-3xl ring-1 ring-gray-200/50">
                    <div class="px-10 py-12">
                        <x-auth-session-status class="mb-8" :status="session('status')" />
                        <form wire:submit="login" class="space-y-8">
                            <!-- Email Address -->
                            <div class="space-y-3">
                                <x-input-label for="email" :value="__('Email address')"
                                    class="text-sm font-semibold tracking-wide text-gray-800" />
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 left-0 z-10 flex items-center pl-5 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 transition-all duration-300 group-focus-within:text-yellow-600"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                    </div>
                                    <x-gold-text-input wire:model="form.email" id="email"
                                        class="block w-full py-4 pr-5 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70"
                                        type="email" name="email" required autofocus autocomplete="username"
                                        placeholder="Enter your email address" />
                                </div>
                                <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-sm font-medium text-red-600" />
                            </div>

                            <!-- Password -->
                            <div class="space-y-3">
                                <x-input-label for="password" :value="__('Password')"
                                    class="text-sm font-semibold tracking-wide text-gray-800" />
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 left-0 z-10 flex items-center pl-5 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 transition-all duration-300 group-focus-within:text-yellow-600"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <x-gold-text-input wire:model="form.password" id="password" :type="$showPassword ? 'text' : 'password'"
                                        name="password"
                                        class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70"
                                        required autocomplete="current-password" placeholder="Enter your password" />
                                    <div class="absolute inset-y-0 right-0 z-10 flex items-center pr-5">
                                        <button type="button" wire:click="togglePassword"
                                            class="p-2 text-gray-400 transition-all duration-300 hover:text-gray-600 focus:outline-none focus:text-blue-600 rounded-xl hover:bg-gray-100/70 focus:bg-blue-50 focus:ring-2 focus:ring-blue-500/20"
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
                                <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-sm font-medium text-red-600" />
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between pt-2">
                                <label for="remember" class="flex items-center cursor-pointer group">
                                    <input wire:model="form.remember" id="remember" type="checkbox"
                                        class="w-5 h-5 text-yellow-600 transition-all duration-200 bg-white border-2 border-yellow-300 rounded-lg focus:ring-yellow-500 focus:ring-2 focus:ring-offset-2 hover:border-yellow-400"
                                        name="remember">
                                    <span
                                        class="ml-3 text-sm font-medium text-gray-700 transition-colors group-hover:text-gray-900">
                                        {{ __('Remember me for 30 days') }}
                                    </span>
                                </label>

                                @if (Route::has('password.request'))
                                    <x-gold-link
                                        class="px-3 py-2 text-sm font-semibold text-blue-600 transition-all duration-200 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:ring-offset-2 rounded-xl hover:bg-blue-50"
                                        href="{{ route('password.request') }}" wire:navigate>
                                        {{ __('Forgot password?') }}
                                    </x-gold-link>
                                @endif
                            </div>

                            <!-- Login Button -->
                            <div class="pt-6">
                                <x-gold-button type="submit"
                                    class="group relative w-full flex justify-center py-4 px-6 border border-transparent text-base font-semibold rounded-2xl text-white bg-gradient-to-r from-yellow-600 via-yellow-700 to-orange-700 hover:from-yellow-700 hover:via-yellow-800 hover:to-orange-800 focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 active:translate-y-0 hover:scale-[1.02] active:scale-[0.98]"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-75 cursor-not-allowed transform-none">
                                    <span wire:loading.remove class="flex items-center">
                                        <svg class="w-5 h-5 mr-3 transition-opacity opacity-80 group-hover:opacity-100"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                        {{ __('Sign in to your account') }}
                                    </span>
                                    <span wire:loading class="flex items-center">
                                        <div
                                            class="w-5 h-5 mr-3 border-2 rounded-full border-white/30 border-t-white animate-spin">
                                        </div>
                                        <span>{{ __('Signing in...') }}</span>
                                    </span>
                                </x-gold-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Register Link -->
            @if (Route::has('register'))
                <div class="text-center">
                    <p class="text-base text-gray-600">
                        {{ __("Don't have an account?") }}
                        <x-gold-link href="{{ route('register') }}"
                            class="inline-block px-3 py-2 ml-1 font-semibold text-blue-600 transition-all duration-200 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:ring-offset-2 rounded-xl hover:bg-blue-50"
                            wire:navigate>
                            {{ __('Create one now') }}
                        </x-gold-link>
                    </p>
                </div>
            @endif
        </div>
    </div>
