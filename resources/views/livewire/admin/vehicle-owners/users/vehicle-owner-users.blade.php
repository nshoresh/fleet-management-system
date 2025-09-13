<div>
    {{-- Vehicle Owner Header --}}
    <x-slot name='header'>
        <div class="px-4 py-2 bg-white">
            <h2 class="text-xl font-semibold">
                {{ $vehicleOwner->company_name ?? $vehicleOwner->business_name ?? $vehicleOwner->name }}
            </h2>
        </div>
    </x-slot>
    <div x-data="{
    showModal: false,
    openModal() {
        this.showModal = true;
    },
    closeModal() {
        this.showModal = false;
    }
}">
        <div x-data="{ showFilters: false }" class="w-full md:w-auto">
            <div class="mb-4 flex flex-wrap items-center gap-4">
                <!-- Search Input -->
                <div class="flex-1 min-w-[250px]">
                    <label for="search" class="block text-sm font-medium text-gray-700"></label>
                    <input wire:model.live.debounce.300ms="search" type="text" id="search"
                        class="block mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Search fleet...">
                </div>
                <div wire:loading class="flex items-center justify-center">
                    <x-loading-indicator />
                </div>
                <!-- Filters (hidden by default, visible on button click) -->
                <div>
                    <label for="perPage" class="block text-sm font-medium text-gray-700"></label>
                    <select wire:model.live="perPage" id="perPage"
                        class="block mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="10">10 Per Page</option>
                        <option value="25">25 Per Page</option>
                        <option value="50">50 Per Page</option>
                        <option value="100">100 Per Page</option>
                    </select>
                </div>
                <!-- Show Filters Button -->
                <div>
                    <button @click="showFilters = !showFilters"
                        class="flex px-4 py-2 text-sm text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">
                        <x-icons.filter-icon />
                        <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
                    </button>
                </div>
                <!-- Button to open the modal -->
                <div class="flex">
                    <x-gold-button @click="openModal">
                        <x-icons.plus-circle/> Add New user
                    </x-gold-button>
                </div>
            </div>

           <!-- Flash Message -->
            @if(session()->has('success'))
                <div class="p-4 bg-green-50 border-l-4 border-green-500"
                    x-data="{ show: true, timeLeft: 5 }"
                    x-init="
                        setTimeout(() => { show = false }, 5000);
                        setInterval(() => { if (timeLeft > 0) timeLeft-- }, 1000);
                    "
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:leave="transition ease-in duration-200"
                    >
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                        <button 
                        @click="show = false"
                        type="button" class="text-green-500 hover:text-green-700 focus:outline-none">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div x-data="{ show: true }" x-show="show"
                    class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded shadow-lg z-50 max-w-sm"
                    role="alert">
                    <div class="flex items-center justify-between">
                        <span>{{ session('error') }}</span>
                        <button @click="show = false" class="ml-4 text-red-700 hover:text-green-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
            <!-- Table -->
            <div class="p-4 overflow-y-auto bg-white rounded-lg shadow">
                @if ($users && $users->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-yellow-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer hover:text-gray-700">ID</th>
                                <th scope="col"
                                    class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer hover:text-gray-700">Name</th>
                                <th scope="col"
                                    class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer hover:text-gray-700">Email</th>
                                <th scope="col"
                                    class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer hover:text-gray-700">Role</th>
                                <th scope="col"
                                    class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer hover:text-gray-700">Account Status</th>
                                <th scope="col"
                                    class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer hover:text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-6 text-sm text-gray-500">{{ $user->id }}</td>
                                    <td class="px-6 py-6 text-sm text-gray-500">{{ $user->name }}</td>
                                    <td class="px-6 py-6 text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="px-6 py-6 text-sm text-gray-500">{{ $user->role->name }}</td>
                                    <td class="px-6 py-6 text-sm text-gray-500">
                                        <span
                                            class='@if ($user->account_status->status == 'Active') bg-green-100 text-green-800 @elseif ($user->account_status->status == 'Inactive') bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif inline-flex items-center px-2 py-1 text-xs font-medium rounded-full'>
                                            {{ $user->account_status->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-6 text-sm text-gray-500">
                                        <x-action-dropdown>
                                            <x-slot name="trigger">
                                                <x-gold-button-sm class="text-indigo-600 hover:text-indigo-900">
                                                    <x-icons.three-dots />
                                                </x-gold-button-sm>
                                            </x-slot>
                                            <button wire:click="#" class="block w-full px-4 py-2 text-left text-gray-800 hover:bg-gray-100">
                                                View
                                            </button>
                                            <button wire:click="#" class="block w-full px-4 py-2 text-left text-gray-800 hover:bg-gray-100">
                                                Edit
                                            </button>
                                            <button wire:click="confirmDelete({{ $user->id }})" class="block w-full px-4 py-2 text-left text-red-600 hover:bg-red-100">
                                                Delete
                                            </button>
                                        </x-action-dropdown>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="p-3 mt-4">
                           {{-- {{ $users->links('vendor.pagination.tailwind') }}--}}
                    </div>  
                @else
                    <h1 class="text-2xl">No Users Available</h1>
                @endif
            </div>

            {{-- Delete Confirmation Modal --}}
            @if($confirmDeletion)
                <div wire:ignore.self class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="p-6 bg-white rounded-lg shadow-lg w-96">
                        <h2 class="text-lg font-semibold">Confirm Deletion</h2>
                        <p class="mt-2 text-gray-600">Are you sure you want to delete this user? This action cannot be undone.</p>
                        <div class="flex justify-end mt-4 space-x-2">
                            <button wire:click="cancelDelete"
                                class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                    Cancel
                            </button>
                            <button wire:click="delete"
                                class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
                                    Delete
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Add User Modal -->
            <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                <!-- Backdrop -->
                <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>

                <!-- Modal Positioning -->
                <div class="flex items-center min-h-screen px-4 pt-4 pb-20 sm:p-0">

                    <!-- Modal Panel -->
                    <div class="relative w-full max-w-2xl mx-auto bg-white rounded-lg shadow-2xl overflow-hidden transform transition-all sm:my-8"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                        <!-- Modal Header with Close Button -->
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900">Add Vehicle Owner User</h3>
                            <button @click="closeModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Content -->
                        <div class="p-6">
                            <livewire:admin.vehicle-owners.users.vehicle-owner-users-create :vehicle-owner-id="$vehicleOwner->id"
                                :key="'fleet-register-' . $vehicleOwner->id" />
                        </div>
                    </div>
                </div>
            </div>

            @push('styles')
                <style>
                    [x-cloak] {
                        display: none !important;
                    }

                    /* Optional: Add some basic styling for better readability */
                    table th,
                    table td {
                        vertical-align: middle;
                    }

                    table th {
                        background-color: #f9f9f9;
                    }

                    table td {
                        background-color: #fff;
                    }

                    table tr:nth-child(even) td {
                        background-color: #f9f9f9;
                    }
                </style>
            @endpush
        </div>
    </div>
</div>
