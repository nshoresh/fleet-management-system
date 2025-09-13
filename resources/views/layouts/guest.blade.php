<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary Meta Tags -->
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="{{ config('app.description', 'A modern web application built with Laravel') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Minimal Custom Styles -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>

    <!-- LivewireStyles -->
    @livewireStyles
</head>

<body class="min-h-screen antialiased bg-gradient-to-br from-slate-50 via-white to-slate-100">
    <!-- Background Pattern -->
    <div class="fixed inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))] -z-10">
    </div>
    <div class="relative flex flex-col min-h-screen">
        <main class="relative flex items-center justify-center flex-1">
            <div class="w-full px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mx-auto max-w-12xl">
                    <div class="p-8 transition-all duration-300">
                        {{ $slot }}
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-8 mx-auto mt-20 max-w-12xl md:grid-cols-3">
                    <div class="text-center group">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 mb-4 transition-transform rounded-xl bg-gradient-to-br from-amber-400 to-yellow-500 group-hover:scale-110">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-slate-900">Lightning Fast</h3>
                        <p class="text-slate-600">Built for speed and performance with modern technologies.</p>
                    </div>

                    <div class="text-center group">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 mb-4 transition-transform rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 group-hover:scale-110">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-slate-900">Secure & Reliable</h3>
                        <p class="text-slate-600">Enterprise-grade security with 99.9% uptime guarantee.</p>
                    </div>

                    <div class="text-center group">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 mb-4 transition-transform rounded-xl bg-gradient-to-br from-emerald-400 to-green-500 group-hover:scale-110">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-slate-900">User Friendly</h3>
                        <p class="text-slate-600">Intuitive design that puts user experience first.</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Professional Footer -->
        <footer class="relative text-white bg-slate-900">
            <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-4">

                    <!-- Brand Column -->
                    <div class="col-span-1 md:col-span-2">
                        <h3
                            class="mb-4 text-2xl font-bold text-transparent bg-gradient-to-r from-amber-400 to-yellow-400 bg-clip-text">
                            {{ config('app.name', 'Laravel') }}
                        </h3>
                        <p class="max-w-md mb-6 text-slate-400">
                            Building the future of web applications with cutting-edge technology and exceptional user
                            experiences.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="transition-colors text-slate-400 hover:text-amber-400">
                                <span class="sr-only">Twitter</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                            <a href="#" class="transition-colors text-slate-400 hover:text-amber-400">
                                <span class="sr-only">GitHub</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="mb-4 text-lg font-semibold">Quick Links</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('login') }}"
                                    class="transition-colors text-slate-400 hover:text-amber-400">Login</a></li>
                            <li><a href="#"
                                    class="transition-colors text-slate-400 hover:text-amber-400">Register</a></li>
                            <li><a href="#"
                                    class="transition-colors text-slate-400 hover:text-amber-400">Dashboard</a></li>
                            <li><a href="#"
                                    class="transition-colors text-slate-400 hover:text-amber-400">Profile</a></li>
                        </ul>
                    </div>

                    <!-- Legal -->
                    <div>
                        <h4 class="mb-4 text-lg font-semibold">Legal</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="transition-colors text-slate-400 hover:text-amber-400">Terms
                                    of Service</a></li>
                            <li><a href="#" class="transition-colors text-slate-400 hover:text-amber-400">Privacy
                                    Policy</a>
                            </li>
                            <li><a href="#" class="transition-colors text-slate-400 hover:text-amber-400">Cookie
                                    Policy</a></li>
                            <li><a href="#"
                                    class="transition-colors text-slate-400 hover:text-amber-400">Support</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="pt-8 mt-12 border-t border-slate-800">
                    <div class="flex flex-col items-center justify-between md:flex-row">
                        <p class="text-sm text-slate-400">
                            &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                        </p>
                        <p class="mt-2 text-sm text-slate-500 md:mt-0">
                            Crafted with ❤️ and modern technology
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    @livewireScripts

    <!-- Enhanced Toast Notifications -->
    <div x-data="{ notifications: [] }"
        @notify.window="notifications.push({...($event.detail), id: Date.now()}); setTimeout(() => { notifications.shift() }, 4000)"
        class="fixed z-50 w-full max-w-sm space-y-3 top-4 right-4">

        <template x-for="notification in notifications" :key="notification.id">
            <div x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-full"
                class="p-4 border shadow-lg bg-white/90 backdrop-blur-md rounded-xl border-slate-200">

                <div class="flex items-start space-x-3">
                    <!-- Icon -->
                    <div class="flex-shrink-0 mt-0.5">
                        <div class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
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
</body>

</html>
