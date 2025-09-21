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

<div x-data="{
    usersOpen: localStorage.getItem('usersOpen') === 'true',
    settingsOpen: localStorage.getItem('settingsOpen') === 'true',
    cdrOpen: localStorage.getItem('cdrOpen') === 'true',
    systemOpen: localStorage.getItem('systemOpen') === 'true',
    licenseManagement: localStorage.getItem('licenseManagement') === 'true',
    systemSecurityOpen: localStorage.getItem('systemSecurityOpen') === 'true',
    vehicleManagementOpen: localStorage.getItem('vehicleManagementOpen') === 'true',
    userMenuOpen: false,

    watchDropdownState(stateName) {
        this.$watch(stateName, value => {
            localStorage.setItem(stateName, value);
        });
    }
}" x-init="watchDropdownState('usersOpen');
watchDropdownState('settingsOpen');
watchDropdownState('cdrOpen');
watchDropdownState('systemOpen');
watchDropdownState('licenseManagement');
watchDropdownState('vehicleManagementOpen');
watchDropdownState('systemSecurityOpen');" class="flex flex-col h-full">
    <!-- Header -->
    <div class="sticky top-0 z-10 flex items-center justify-between h-20 px-4 bg-white border-b">
        <span x-show="!sidebarCollapsed || isMobile"
            class="text-lg font-bold text-yellow-600 transition-opacity duration-300">{{ config('app.name') }}</span>
        <div class="flex-shrink-0">
            <x-application-logo />
        </div>
        <!-- Collapse/Expand Button (Desktop only) -->
        <button @click="sidebarCollapsed = !sidebarCollapsed"
            class="hidden p-1 text-gray-500 rounded-md hover:bg-gray-100 focus:outline-none lg:block">
            <svg x-show="!sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
            <svg x-show="sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
            </svg>
        </button>
    </div>

    <!-- Navigation (Scrollable) -->
    <nav class="flex-1 py-4 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 bg-gray-800">
        <div class="px-3 space-y-1">
            <!-- Dashboard Link -->
            <a href="{{ route('dashboard') }}" wire:navigate
                class="flex items-center w-full px-3 py-2 text-gray-300 rounded-md hover:bg-yellow-50 hover:text-yellow-700 group">
                <svg class="w-5 h-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span x-show="!sidebarCollapsed || isMobile"
                    class="ml-3 transition-opacity duration-300">Dashboard</span>
            </a>

            <!-- Users -->
            <div class="py-1">
                <button @click="usersOpen = !sidebarCollapsed && !usersOpen"
                    class="flex items-center w-full px-3 py-2 text-gray-300 transition duration-150 rounded-md hover:bg-yellow-50 hover:text-yellow-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-yellow-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>

                    <span x-show="!sidebarCollapsed || isMobile"
                        class="ml-3 transition-opacity duration-300">Users</span>
                    <svg x-show="!sidebarCollapsed || isMobile" :class="{ 'rotate-90': usersOpen }"
                        class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <div x-show="(!sidebarCollapsed || isMobile) && usersOpen" x-collapse class="mt-1 space-y-1">
                    <x-sidebar-link route="app.users" wire:navigate class="text-yellow-600">
                        User List
                    </x-sidebar-link>
                    <x-sidebar-link route="app.users_create" wire:navigate class="text-yellow-600">
                        New User
                    </x-sidebar-link>
                </div>
            </div>

            {{-- Vehicles --}}
            <div class="py-1">
                <button @click="vehicleManagementOpen = !sidebarCollapsed && !vehicleManagementOpen"
                    class="flex items-center w-full px-3 py-2 text-gray-300 transition duration-150 rounded-md hover:bg-blue-50 hover:text-yellow-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-yellow-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                    <span x-show="!sidebarCollapsed || isMobile"
                        class="ml-3 transition-opacity duration-300">Vehicles</span>
                    <svg x-show="!sidebarCollapsed || isMobile" :class="{ 'rotate-90': vehicleManagementOpen }"
                        class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <div x-show="(!sidebarCollapsed || isMobile) && vehicleManagementOpen" x-collapse
                    class="mt-1 space-y-1">
                    <x-sidebar-link route="app.vehicles_list" wire:navigate class="text-yellow-600">
                        Vehicle List
                    </x-sidebar-link>
                    <x-sidebar-link route="app.vehicles_create" wire:navigate class="text-yellow-600">
                        Vehicle Registration
                    </x-sidebar-link>

                </div>
            </div>

            <!-- Licensing -->
            <div class="py-1">
                <button @click="licenseManagement = !sidebarCollapsed && !licenseManagement"
                    class="flex items-center w-full px-3 py-2 text-gray-300 transition duration-150 rounded-md hover:bg-yellow-50 hover:text-yellow-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-yellow-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>

                    <span x-show="!sidebarCollapsed || isMobile"
                        class="ml-3 transition-opacity duration-300">Licensing</span>
                    <svg x-show="!sidebarCollapsed || isMobile" :class="{ 'rotate-90': licenseManagement }"
                        class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <div x-show="(!sidebarCollapsed || isMobile) && licenseManagement" x-collapse class="mt-1 space-y-1">
                    <x-sidebar-link route="client.app.license_list" wire:navigate class="text-yellow-600">
                        License List
                    </x-sidebar-link>
                    <x-sidebar-link route="client.app.license_type" wire:navigate class="text-yellow-600">
                        License Type
                    </x-sidebar-link>
                    <x-sidebar-link route="client.app.license_purpose" wire:navigate class="text-yellow-600"> 
                        License Purpose
                    </x-sidebar-link>
                    <x-sidebar-link route="client.app.license_create" wire:navigate class="text-yellow-600">
                        New License
                    </x-sidebar-link>
                    {{-- admin.license.renewals.applications --}}
                </div>
            </div>
        </div>
    </nav>

    <!-- User Profile Section (Fixed to bottom) -->
    <div class="sticky bottom-0 mt-auto bg-white border-t border-gray-200">
        <div class="p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}"
                        class="object-cover w-10 h-10 border-2 border-gray-200 rounded-full">
                </div>
                <div x-show="!sidebarCollapsed || isMobile" class="ml-3 overflow-hidden">
                    <p class="text-sm font-medium text-gray-700 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
                <div x-show="!sidebarCollapsed || isMobile" class="ml-auto">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="userMenuOpen = !userMenuOpen"
                            class="p-1 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                </path>
                            </svg>
                        </button>
                        <!-- User dropdown menu -->
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute right-0 z-50 w-48 py-1 mb-2 bg-white rounded-md shadow-2xl bottom-full">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                wire:navigate>
                                Your Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                wire:navigate>
                                Account Settings
                            </a>
                            <div class="my-1 border-t border-gray-200"></div>
                            <form method="POST" action="{{ route('logout') }}" class="block w-full">
                                @csrf
                                <button type="submit"
                                    class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 ">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer (only visible when sidebar is expanded) -->
    <div x-show="!sidebarCollapsed && !isMobile" class="px-4 py-2 text-center border-t border-gray-200">
        <span class="text-xs text-gray-400">© 2025 {{ config('app.name') }}</span>
    </div>
</div>

<!-- Mobile Toggle Button (Fixed Position) -->
<button x-show="isMobile" @click="sidebarOpen = !sidebarOpen">
    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            :d="sidebarOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
    </svg>
</button>
