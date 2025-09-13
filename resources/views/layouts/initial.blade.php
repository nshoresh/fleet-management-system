<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary Meta Tags -->
    <title>{{ config('app.name', 'Laravel') }} - Business Setup</title>
    <meta name="description" content="Complete your business profile and get started in minutes">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .step-indicator {
            transition: all 0.3s ease;
        }

        .step-active {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            transform: scale(1.1);
        }

        .step-completed {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .step-inactive {
            background: #e2e8f0;
        }
    </style>

    @livewireStyles
</head>

<body class="min-h-screen antialiased bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <!-- Animated Background Pattern -->
    <div class="fixed inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.4))] -z-10">
    </div>

    <!-- Floating Elements -->
    <div
        class="fixed w-32 h-32 bg-blue-200 rounded-full top-20 left-10 mix-blend-multiply filter blur-xl opacity-30 animate-pulse">
    </div>
    <div
        class="fixed w-40 h-40 bg-purple-200 rounded-full bottom-20 right-10 mix-blend-multiply filter blur-xl opacity-30 animate-pulse animation-delay-2000">
    </div>

    <!-- Page Container -->
    <div class="relative flex flex-col min-h-screen">

        <!-- Header with Progress -->
        <header class="relative border-b shadow-sm bg-white/80 backdrop-blur-md border-slate-200/50">
            <div class="px-4 mx-auto max-w-12xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">

                        <h1 class="text-xl font-bold text-slate-900">{{ config('app.name', 'Laravel') }}</h1>
                    </div>

                    <!-- Progress Steps -->

                    <div>
                        <h1>
                            Vehicle Owners Onboarding
                        </h1>
                    </div>
                    <!-- Help Button -->
                    <div>
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium transition-colors rounded-lg text-slate-600 hover:bg-slate-100">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Need Help?
                        </button>
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium transition-colors rounded-lg text-slate-600 hover:bg-slate-100">
                            logout
                        </button>
                    </div>


                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="relative flex-1 py-8">
            <div class="px-4 mx-auto max-w-12xl sm:px-6 lg:px-8">
                <!-- Welcome Message -->
                <!-- Main Onboarding Card -->
                <div class="p-8">
                    {{ $slot }}
                </div>
                <!-- Benefits Section -->
                <div class="grid grid-cols-1 gap-6 mt-12 md:grid-cols-3">
                    <div
                        class="p-6 transition-all duration-300 border bg-white/50 backdrop-blur-sm rounded-xl border-slate-200/50 hover:shadow-lg">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 mb-4 rounded-xl bg-gradient-to-br from-green-400 to-emerald-500">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-slate-900">Quick Setup</h3>
                        <p class="text-slate-600">Get your business online in under 10 minutes with our streamlined
                            process.</p>
                    </div>

                    <div
                        class="p-6 transition-all duration-300 border bg-white/50 backdrop-blur-sm rounded-xl border-slate-200/50 hover:shadow-lg">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 mb-4 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-slate-900">Secure & Private</h3>
                        <p class="text-slate-600">Your data is protected with enterprise-grade security and encryption.
                        </p>
                    </div>

                    <div
                        class="p-6 transition-all duration-300 border bg-white/50 backdrop-blur-sm rounded-xl border-slate-200/50 hover:shadow-lg">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 mb-4 rounded-xl bg-gradient-to-br from-purple-400 to-pink-500">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-slate-900">Growth Ready</h3>
                        <p class="text-slate-600">Built to scale with your business from startup to enterprise level.
                        </p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="relative text-white bg-slate-900">
            <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex flex-col items-center justify-between space-y-4 md:flex-row md:space-y-0">
                    <div class="text-center md:text-left">
                        <p class="text-sm text-slate-400">
                            &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                        </p>
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="#" class="text-sm transition-colors text-slate-400 hover:text-white">Privacy
                            Policy</a>
                        <a href="#" class="text-sm transition-colors text-slate-400 hover:text-white">Terms of
                            Service</a>
                        <a href="#" class="text-sm transition-colors text-slate-400 hover:text-white">Support</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @livewireScripts

    <!-- Enhanced Toast Notifications for Onboarding -->
    <div x-data="{ notifications: [] }"
        @notify.window="notifications.push({...($event.detail), id: Date.now()}); setTimeout(() => { notifications.shift() }, 5000)"
        class="fixed z-50 w-full max-w-sm space-y-3 top-4 right-4">

        <template x-for="notification in notifications" :key="notification.id">
            <div x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-full"
                class="p-4 border shadow-lg bg-white/95 backdrop-blur-md rounded-xl border-slate-200">

                <div class="flex items-start space-x-3">
                    <!-- Dynamic Icon Based on Type -->
                    <div class="flex-shrink-0 mt-0.5">
                        <div class="flex items-center justify-center w-6 h-6 rounded-full"
                            :class="notification.type === 'success' ? 'bg-emerald-100' : notification.type === 'warning' ?
                                'bg-amber-100' : 'bg-blue-100'">
                            <svg class="w-4 h-4"
                                :class="notification.type === 'success' ? 'text-emerald-600' : notification
                                    .type === 'warning' ? 'text-amber-600' : 'text-blue-600'"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path x-show="notification.type === 'success'" stroke-linecap="round"
                                    stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                <path x-show="notification.type === 'warning'" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                <path x-show="notification.type === 'info'" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <p x-text="notification.message" class="text-sm font-medium text-slate-900"></p>
                        <p x-show="notification.description" x-text="notification.description"
                            class="mt-1 text-xs text-slate-600"></p>
                    </div>

                    <!-- Close Button -->
                    <div class="flex-shrink-0">
                        <button @click="notifications = notifications.filter(n => n.id !== notification.id)"
                            class="p-1 transition-colors rounded-md text-slate-400 hover:text-slate-600">
                            <span class="sr-only">Close</span>
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Onboarding Helper Script -->
    <script>
        // Progress step management
        window.updateProgress = function(currentStep) {
            const steps = document.querySelectorAll('.step-indicator');
            steps.forEach((step, index) => {
                const stepNumber = index + 1;
                if (stepNumber < currentStep) {
                    step.className =
                        'step-indicator step-completed w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-semibold';
                } else if (stepNumber === currentStep) {
                    step.className =
                        'step-indicator step-active w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-semibold';
                } else {
                    step.className =
                        'step-indicator step-inactive w-8 h-8 rounded-full flex items-center justify-center text-slate-600 text-sm font-semibold';
                }
            });
        };

        // Welcome notification
        setTimeout(() => {
            window.dispatchEvent(new CustomEvent('notify', {
                detail: {
                    type: 'info',
                    message: 'Welcome! Let\'s get you set up.',
                    description: 'Complete each step to unlock all features.'
                }
            }));
        }, 1000);
    </script>
</body>

</html>
