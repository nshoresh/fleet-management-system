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
    // State management with localStorage
    reportsOpen: localStorage.getItem('reportsOpen') === 'true',
    settingsOpen: localStorage.getItem('settingsOpen') === 'true',
    cdrOpen: localStorage.getItem('cdrOpen') === 'true',
    systemOpen: localStorage.getItem('systemOpen') === 'true',
    licenseManagement: localStorage.getItem('licenseManagement') === 'true',
    systemSecurityOpen: localStorage.getItem('systemSecurityOpen') === 'true',
    clientManagementOpen: localStorage.getItem('clientManagementOpen') === 'true', // S.O.N Add this line
    userMenuOpen: false,
    //sidebarCollapsed: false,
    //isMobile: window.innerWidth < 1024,

    // Watch window resize for mobile detection
    init() {
        window.addEventListener('resize', () => {
            this.isMobile = window.innerWidth < 1024;
        });

        // Initialize all dropdown watchers
        this.watchDropdownState('reportsOpen');
        this.watchDropdownState('settingsOpen');
        this.watchDropdownState('cdrOpen');
        this.watchDropdownState('systemOpen');
        this.watchDropdownState('licenseManagement');
        this.watchDropdownState('systemSecurityOpen');
        this.watchDropdownState('clientManagementOpen'); // S.O.N Add this line
    },

    // Persist dropdown state to localStorage
    watchDropdownState(stateName) {
        this.$watch(stateName, value => {
            localStorage.setItem(stateName, value);
        });
    },

    // Toggle dropdown with proper collapsed state handling
    toggleDropdown(dropdownName) {
        if (this.sidebarCollapsed && !this.isMobile) {
            // When sidebar is collapsed (desktop), open the dropdown
            this[dropdownName] = true;
        } else {
            // Normal toggle behavior
            this[dropdownName] = !this[dropdownName];
        }
    }
}" class="flex flex-col h-full">
    <!-- Header -->
    <div class="sticky top-0 z-10 flex items-center justify-between h-16 px-4 border-b bg-gray-50">
        <span x-show="!sidebarCollapsed || isMobile"
            class="px-4 text-lg font-bold text-yellow-600 transition-opacity duration-300">{{ config('app.name') }}</span>
        <div class="flex-shrink-0">
            <x-application-logo />
        </div>
        <!-- Collapse/Expand Button (Desktop only) -->
        <button @click="sidebarCollapsed = !sidebarCollapsed"
            class="hidden p-1 text-gray-500 rounded-md hover:bg-gray-100 focus:outline-none lg:block">
            <svg x-show="!sidebarCollapsed" class="w-10 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="5"
                    d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
            <svg x-show="sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
            </svg>
        </button>
    </div>

    <!-- Navigation (Scrollable) -->
    <nav class="flex-1 py-4 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
        <div class="py-1 space-y-1">
            <!-- Dashboard Link -->
            <x-sidebar-link route="dashboard" wire:navigate
                class="flex items-center w-full px-3 py-2 text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 group">
                <svg class="w-5 h-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span x-show="!sidebarCollapsed || isMobile"
                    class="ml-3 transition-opacity duration-300">Dashboard
                </span>
            </x-sidebar-link>

            <!-- Reports -->
            <div class="py-1">
                <button @click="toggleDropdown('reportsOpen')"
                    class="flex items-center w-full px-3 py-2 text-gray-700 transition duration-150 rounded-md hover:bg-yellow-50 hover:text-yellow-700 group">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span x-show="!sidebarCollapsed || isMobile"
                        class="ml-3 transition-opacity duration-300">Reports
                    </span>
                    <svg x-show="!sidebarCollapsed || isMobile" :class="{ 'rotate-90': reportsOpen }"
                        class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <div x-show="(!sidebarCollapsed || isMobile) && reportsOpen" x-collapse class="mt-1 space-y-1">
                    <!-- Report items would go here -->
                </div>
            </div>

            <!-- Licensing -->
            <div class="py-1">
                <button @click="toggleDropdown('licenseManagement')"
                    class="flex items-center w-full px-3 py-2 text-gray-700 transition duration-150 rounded-md hover:bg-yellow-50 hover:text-yellow-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="w-5 h-5 text-yellow-600" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5M12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5M1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8m9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5m1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5" />
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
                    <x-sidebar-link route="license" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        License List
                    </x-sidebar-link>
                    <x-sidebar-link route="admin.license-types" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        License Type
                    </x-sidebar-link>
                    <x-sidebar-link route="admin.license-purpose" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        License Purpose
                    </x-sidebar-link>
                    <x-sidebar-link route="license.create" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        New License
                    </x-sidebar-link>
                    <x-sidebar-link route="admin.license.applications" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        License Applications
                    </x-sidebar-link>
                    <x-sidebar-link route="admin.license.renewals.applications" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        Renewal Applications
                    </x-sidebar-link>
                </div>
            </div>

            <!-- Client Management -->
            <div class="py-1">
                <button @click="toggleDropdown('clientManagementOpen')"
                    class="flex items-center w-full px-3 py-2 text-gray-700 transition duration-150 rounded-md hover:bg-yellow-50 hover:text-yellow-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="w-5 h-5 text-yellow-600" viewBox="0 0 16 16">
                        <path
                            d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                        <path
                            d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                        <path
                            d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                    </svg>
                    <span x-show="!sidebarCollapsed || isMobile" class="ml-3 transition-opacity duration-300">Client
                        Management</span>
                    <svg x-show="!sidebarCollapsed || isMobile" :class="{ 'rotate-90': clientManagementOpen }"
                        class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <div x-show="(!sidebarCollapsed || isMobile) && clientManagementOpen" x-collapse
                    class="mt-1 space-y-1">
                    <x-sidebar-link route="admin.vehicle-owners" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        Vehicle Owners
                    </x-sidebar-link>
                </div>
            </div>

            <!-- Vehicle Management -->
            <div class="py-1">
                <button @click="toggleDropdown('settingsOpen')"
                    class="flex items-center w-full px-3 py-2 text-gray-700 transition duration-150 rounded-md hover:bg-yellow-50 hover:text-yellow-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="w-5 h-5 text-yellow-600" viewBox="0 0 16 16">
                        <path
                            d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
                    </svg>
                    <span x-show="!sidebarCollapsed || isMobile"
                        class="ml-3 transition-opacity duration-300">Management</span>
                    <svg x-show="!sidebarCollapsed || isMobile" :class="{ 'rotate-90': settingsOpen }"
                        class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <div x-show="(!sidebarCollapsed || isMobile) && settingsOpen" x-collapse class="mt-1 space-y-1">
                    <x-sidebar-link route="admin.vehicle-classifications" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        Vehicle Classification
                    </x-sidebar-link>
                    <x-sidebar-link route="admin.vehicle-routes.index" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        Vehicle Routes
                    </x-sidebar-link>
                    <x-sidebar-link route="vehicles.vehicle-types" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        Vehicle Types
                    </x-sidebar-link>
                    <x-sidebar-link route="vehicles.owner-types" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        Vehicle Owner Type
                    </x-sidebar-link>
                    <x-sidebar-link route="vehicles.makes" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        Vehicle Make
                    </x-sidebar-link>
                    <x-sidebar-link route="vehicles.make-model" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        Vehicle Make Model
                    </x-sidebar-link>
                </div>
            </div>

            <!-- System -->
            <div class="py-1">
                <button @click="toggleDropdown('systemOpen')"
                    class="flex items-center w-full px-3 py-2 text-gray-700 transition duration-150 rounded-md hover:bg-yellow-50 hover:text-yellow-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="w-5 h-5 text-yellow-600" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5M12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5M1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8m9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5m1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5" />
                    </svg>
                    <span x-show="!sidebarCollapsed || isMobile" class="ml-3 transition-opacity duration-300">System
                        Variables</span>
                    <svg x-show="!sidebarCollapsed || isMobile" :class="{ 'rotate-90': systemOpen }"
                        class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <div x-show="(!sidebarCollapsed || isMobile) && systemOpen" x-collapse class="mt-1 space-y-1">
                    <x-sidebar-link route="users" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        User List
                    </x-sidebar-link>
                    <x-sidebar-link route="users.create" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        New User
                    </x-sidebar-link>
                    <x-sidebar-link route="system.user-types" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        User Types
                    </x-sidebar-link>
                    <x-sidebar-link route="system.regions" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        Regions
                    </x-sidebar-link>
                    <x-sidebar-link route="system.provinces" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        Province
                    </x-sidebar-link>
                    <x-sidebar-link route="system.district" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        District
                    </x-sidebar-link>
                    <hr />
                    <x-sidebar-link route="pulse" wire:navigate>
                        System Metrics
                    </x-sidebar-link>
                </div>
            </div>

            <!-- System Security -->
            <div class="py-1">
                <button @click="toggleDropdown('systemSecurityOpen')"
                    class="flex items-center w-full px-3 py-2 text-gray-700 transition duration-150 rounded-md hover:bg-yellow-50 hover:text-yellow-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600" width="16"
                        height="16" fill="currentColor" class="bi bi-shield" viewBox="0 0 16 16">
                        <path
                            d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56" />
                    </svg>
                    <span x-show="!sidebarCollapsed || isMobile" class="ml-3 transition-opacity duration-300">System
                        Security</span>
                    <svg x-show="!sidebarCollapsed || isMobile" :class="{ 'rotate-90': systemSecurityOpen }"
                        class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <div x-show="(!sidebarCollapsed || isMobile) && systemSecurityOpen" x-collapse class="mt-1 space-y-1">
                    <x-sidebar-link route="system.roles" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        Roles Management
                    </x-sidebar-link>
                    <x-sidebar-link route="system.permissions" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        Permissions Management
                    </x-sidebar-link>
                    <x-sidebar-link route="settings" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        Account Status
                    </x-sidebar-link>
                    <x-sidebar-link route="settings" wire:navigate
                        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
                        Password and Security
                    </x-sidebar-link>
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
                            class="absolute right-0 z-50 w-48 py-1 mb-2 bg-white rounded-md shadow-lg bottom-full">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                wire:navigate>
                                Your Profile
                            </a>
                            <a href="#" wire:navigate>
                                Account Settings
                            </a>
                            <div class="my-1 border-t border-gray-200"></div>
                            <form method="POST" action="{{ route('logout') }}" class="block w-full">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2 ml-4 text-sm text-left text-red-600 hover:bg-gray-100">
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
<button x-show="isMobile" @click="sidebarOpen = !sidebarOpen"
    class="fixed z-40 p-2 text-white bg-blue-600 rounded-full shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 lg:hidden bottom-4 right-4">
    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            :d="sidebarOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
    </svg>
</button>
