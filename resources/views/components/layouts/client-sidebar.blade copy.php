<!-- Sidebar Component -->
<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        // Redirect to the home page after logout
        $this->redirect('/', navigate: true);
    }
}; ?>


<aside x-data="{
    sidebarWidth: localStorage.getItem('sidebarWidth') || '16rem',
    isCollapsed: false,
    userManagementOpen: JSON.parse(localStorage.getItem('userManagementOpen')) || false,
    settingsOpen: JSON.parse(localStorage.getItem('settingsOpen')) || false,
    chargesManagementOpen: JSON.parse(localStorage.getItem('chargesManagementOpen')) || false,
    vehicleManagementOpen: JSON.parse(localStorage.getItem('vehicleManagementOpen')) || false,
    licenseManagementOpen: JSON.parse(localStorage.getItem('licenseManagementOpen')) || false,
    adminMenuOpen: JSON.parse(localStorage.getItem('adminMenuOpen')) || false,
    startResizing(e) {
        document.addEventListener('mousemove', this.resize);
        document.addEventListener('mouseup', this.stopResizing);
    },
    resize(e) {
        let newWidth = `${Math.max(200, e.clientX)}px`; // Min width: 200px
        this.sidebarWidth = newWidth;
        localStorage.setItem('sidebarWidth', newWidth);
    },
    stopResizing() {
        document.removeEventListener('mousemove', this.resize);
        document.removeEventListener('mouseup', this.stopResizing);
    },
    toggleMenu(menu) {
        this[menu] = !this[menu];
        localStorage.setItem(menu, JSON.stringify(this[menu]));
    }
}"
    class="fixed inset-y-0 left-0 z-30 flex flex-col bg-white border-r shadow-lg sidebar-transition"
    :class="{
        'w-35': sidebarOpen,
        'w-20': !sidebarOpen,
        '-translate-x-full': isMobile && !sidebarOpen
    }">

    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-4 border-b">
        <div class="flex items-center px-4 py-6 space-x-3" :class="{ 'justify-center': !sidebarOpen }">
            <div class="flex-shrink-0">
                <x-application-logo />
            </div>
            <x-sidebar-link href="{{ route('dashboard') }}" wire:navigate class="text-xl font-semibold transition-opacity duration-300"
                x-show="sidebarOpen" x-transition:enter="transition-opacity ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                PNG <span class="text-yellow-500">RF</span>
            </x-sidebar-link>
        </div>

        <!-- Toggle Button -->
        <button @click="sidebarOpen = !sidebarOpen"
            class="p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-100"
            :class="{ 'hidden': isMobile }">
            <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    :d="sidebarOpen ? 'M11 19l-7-7 7-7M21 19l-7-7 7-7' : 'M13 19l7-7-7-7M3 19l7-7-7-7'" />
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <ul class="flex-grow overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200">

        <li>
            <button @click="toggleMenu('userManagementOpen')"
                class="flex w-full px-2 py-2 text-sm font-medium transition-colors rounded-lg hover:bg-gray-100">
                <svg class="w-[23px] h-[23px] text-gray-800  " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                        clip-rule="evenodd" />
                </svg>

                <span class="ml-3 transition-opacity duration-300" x-show="sidebarOpen"
                    x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    Users
                </span>

                <svg class="flex-1 w-4 h-4 ml-2 transform" :class="{ 'rotate-180': userManagementOpen }" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="userManagementOpen" x-collapse class="ml-6 space-y-1">
                <a href="{{ route('app.users') }}" wire:navigate
                    class="block px-2 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
                    User List
                </a>
                <a href="{{ route('app.users_create') }}" wire:navigate
                    class="block px-2 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
                    New User
                </a>
            </div>
        </li>

        <li>
            <!-- Settings Submenu -->
            <div>
                <button @click="toggleMenu('licenseManagementOpen')"
                    class="flex items-center w-full px-2 py-2 text-sm font-medium transition-colors rounded-lg hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
                        <path
                            d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5m0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78zM5.048 3.967l-.087.065zm-.431.355A4.98 4.98 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8zm.344 7.646.087.065z" />
                    </svg>
                    <span class="ml-3 transition-opacity duration-300" x-show="sidebarOpen"
                        x-transition:enter="transition-opacity ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        Licensing
                    </span>
                    <svg class="flex-1 w-4 h-4 ml-2 transform" :class="{ 'rotate-180': licenseManagementOpen }"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="licenseManagementOpen" class="ml-6 space-y-1">
                    <a href="{{ route('license') }}" wire:navigate
                        class="block px-2 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
                        License List
                    </a>
                    <a href="{{ route('admin.license-types') }}" wire:navigate
                        class="block px-2 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
                        License Type
                    </a>
                    <a href="{{ route('admin.license-purpose') }}" wire:navigate
                        class="block px-2 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
                        License Purpose
                    </a>
                    <a href="{{ route('license.create') }}" wire:navigate
                        class="block px-2 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
                        New License
                    </a>
                </div>
            </div>
        </li>



        <li>
            <!-- Settings Submenu -->
            <div>
                <button @click="toggleMenu('chargesManagementOpen')"
                    class="flex items-center w-full px-2 py-2 text-sm font-medium transition-colors rounded-lg hover:bg-gray-100">
                    <svg class="w-[23px] h-[23px] text-gray-800  aria-hidden=" true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z"
                            clip-rule="evenodd" />
                    </svg>

                    <span class="ml-3 transition-opacity duration-300" x-show="sidebarOpen"
                        x-transition:enter="transition-opacity ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        Charge
                    </span>
                    <svg class="flex-1 w-4 h-4 ml-2 transform" :class="{ 'rotate-180': chargesManagementOpen }"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="chargesManagementOpen" class="ml-6 space-y-1">
                    <a href="{{ route('settings') }}" wire:navigate
                        class="block px-2 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
                        General Settings
                    </a>
                    <a href="{{ route('settings') }}" wire:navigate
                        class="block px-2 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
                        Advanced Settings
                    </a>
                </div>
            </div>
        </li>
        <li>
            <!-- Settings Submenu -->
            <div>
                <button @click="toggleMenu('vehicleManagementOpen')"
                    class="flex items-center w-full px-2 py-2 text-sm font-medium transition-colors rounded-lg hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-truck-front-fill" viewBox="0 0 16 16">
                        <path
                            d="M3.5 0A2.5 2.5 0 0 0 1 2.5v9c0 .818.393 1.544 1 2v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5V14h6v1.5a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2c.607-.456 1-1.182 1-2v-9A2.5 2.5 0 0 0 12.5 0zM3 3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3.9c0 .625-.562 1.092-1.17.994C10.925 7.747 9.208 7.5 8 7.5s-2.925.247-3.83.394A1.008 1.008 0 0 1 3 6.9zm1 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2m8 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2m-5-2h2a1 1 0 1 1 0 2H7a1 1 0 1 1 0-2" />
                    </svg>
                    <span class="ml-3 transition-opacity duration-300" x-show="sidebarOpen"
                        x-transition:enter="transition-opacity ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        Vehicles
                    </span>
                    <svg class="flex-1 w-4 h-4 ml-2 transform" :class="{ 'rotate-180': vehicleManagementOpen }"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="vehicleManagementOpen" class="ml-6 space-y-1">
                    <a href="{{ route('app.vehicles_list') }}" wire:navigate
                        class="block px-2 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
                        Vehicle List
                    </a>
                    <a href="{{ route('app.vehicles_create') }}" wire:navigate
                        class="block px-2 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">
                        Vehicle Registration
                    </a>
                </div>
            </div>
        </li>
        <!-- Settings -->
    </ul>
    <div class="relative" x-data="{
        userMenuOpen: JSON.parse(localStorage.getItem('userMenuOpen')) || false,
    }">
        <button class="flex items-center p-4 cursor-pointer" @click="userMenuOpen = !userMenuOpen">
            <img class="w-8 h-8 rounded-full"
                src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . Auth::user()->name }}"
                alt="User avatar">
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
            <!-- Dropdown arrow indicator -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2 text-gray-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <form method="POST" action="{{ route('logout') }}" class="block w-full">
            @csrf
            <button type="submit" class="w-full px-4 py-2 ml-4 text-sm text-left text-red-600 hover:bg-gray-100">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </div>
            </button>
        </form>
    </div>
    <!-- Popover Menu -->
</aside>
<!-- Mobile Toggle Button -->
<div class="fixed z-50 block md:hidden bottom-4 right-4" x-show="isMobile">
    <button @click="sidebarOpen = !sidebarOpen"
        class="p-2 text-white bg-blue-600 rounded-full shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                :d="sidebarOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
        </svg>
    </button>
</div>
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
<style>
    /* Custom Scrollbar */
    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 8px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 8px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
