<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Improved layout styles -->
    <style>

        /* Sidebar styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 40;
            transition: all 0.3s ease-in-out;
        }

        /* Layout structure */
        .app-container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Main content area */
        .main-content {
            flex: 1;
            min-width: 0;
            /* Prevents flex items from overflowing */
            transition: margin-left 0.3s ease-in-out;
            min-height: 100vh;
            overflow-y: auto;
        }

        /* Nested dropdown animations */
        [x-collapse] {
            transition-property: height;
            transition-duration: 0.3s;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        /* For mobile: prevent background scrolling when sidebar is open */
        body.sidebar-open {
            overflow: hidden;
        }

        /* Mobile sidebar overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 30;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Common transition for all animated elements */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
    </style>
</head>
<body class="font-sans antialiased" :class="{ 'sidebar-open': sidebarOpen && isMobile }">  

    <div class="bg-gray-100 app-container flex h-screen overflow-hidden" x-data="{
        sidebarOpen: false,
        sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
        isMobile: window.innerWidth < 768,

        init() {
            this.$watch('sidebarCollapsed', (val) => {
                localStorage.setItem('sidebarCollapsed', val);
            });

            window.addEventListener('resize', () => {
                this.isMobile = window.innerWidth < 768;
                if (!this.isMobile && this.sidebarOpen) {
                    this.sidebarOpen = false;
                }
            });
        }
    }">
        <!-- Sidebar Overlay (only visible on mobile) -->
        <div class="sidebar-overlay" :class="{ 'active': sidebarOpen && isMobile }" @click="sidebarOpen = false">
        </div>

        <!-- Sidebar Component -->
        <aside class="bg-white shadow sidebar"
            :class="{
                'w-64': !sidebarCollapsed && !isMobile,
                'w-20': sidebarCollapsed && !isMobile,
                'w-64 transform -translate-x-full': !sidebarOpen && isMobile,
                'w-64 transform translate-x-0': sidebarOpen && isMobile
            }">
            @if (auth()->user()->isAdmin() || auth()->user()->isSystemUser())
                @include('components.sidebar')
            @else
                @include('components.layouts.client-sidebar')
            @endif
        </aside>

        <!-- Main Content -->
        <main class="main-content"
            :class="{
                'ml-64': !sidebarCollapsed && !isMobile,
                'ml-20': sidebarCollapsed && !isMobile,
                'ml-0': isMobile
            }">
            <div class="relative">
            <!-- Sticky Header for MIS Name -->
            <x-header />
                <!-- Mobile menu button (only visible on mobile) -->
                <button x-show="isMobile" @click="sidebarOpen = !sidebarOpen" type="button"
                    class="fixed z-50 inline-flex items-center justify-center p-2 text-gray-400 rounded-md top-4 left-4 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" x-bind:class="{ 'hidden': sidebarOpen, 'block': !sidebarOpen }"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="w-6 h-6" x-bind:class="{ 'block': sidebarOpen, 'hidden': !sidebarOpen }"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Optional Global Search / $header content -->
                @if (isset($header))
                    <div class="px-4 py-6 mx-auto sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                @endif

                <!-- Page Content -->
                <div class="py-6">
                    <div class="px-4 mx-auto max-w-12xl sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
