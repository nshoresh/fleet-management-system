<div>
    <x-slot name='header'>
    <div class="px-4 py-2 bg-yellow-100">
        <h2 class="text-xl font-semibold">
            {{ __('List of Transport Routes in PNG') }}
        </h2>
    </div>
    </x-slot>
    <div x-data="{ openDelete: false, makeId: null, showAddMakeModal: false }">
        <!-- Header, search and filters -->
        <div class="flex flex-col items-start justify-between gap-4 mb-4 sm:flex-row sm:items-cent">
            <div class="flex-1 min-w-[250px]">
                <label for="search" class="block text-sm font-medium text-gray-700"></label>
                <input wire:model.live.debounce.300ms="search" type="text" id="search"
                    class="block mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Search Owners...">
            </div>
            <div wire:loading class="flex-col items-center justify-center overflow-hidden opacity-75 ">
                <x-loading-indicator />
            </div>
            <div class="w-full sm:w-auto">
                <select wire:model.live="routeTypeFilter"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Route Types</option>
                    @foreach ($routeTypes as $routeType)
                        <option value="{{ $routeType->id }}">{{ $routeType->route_type_name }}</option>
                    @endforeach
                </select>
            </div>
            <x-gold-button wire:click="create"
                class="w-full px-4 py-2 font-semibold text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto">
                <div class="flex items-center">
                    <x-icons.plus-circle />
                    Add Route
                </div>
            </x-gold-button>
        </div>

        <!-- Flash Message -->
        @if (session()->has('message'))
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
                            <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
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
        <div class="p-4 overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-yellow-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">#
                        </th>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer"
                            wire:click="sortBy('route_name')">
                            Route Name
                            @if ($sortField === 'route_name')
                                <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                            @endif
                        </th>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer"
                            wire:click="sortBy('routeType')">
                            Route Type
                            @if ($sortField === 'routeType')
                                <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                            @endif
                        </th>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">
                            Created At
                        </th>
                        <th scope="col" 
                            class="relative px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($routes as $route)
                        <tr>
                            <td class="px-4 py-2 ">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $route->route_name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">
                                    {{ $route->routeType->route_type_name ?? '—' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $route->created_at ? $route->created_at->format('M d, Y') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <div class="relative text-left" x-data="{ open: false }">
                                    <x-gold-button-sm x-on:click="open = !open">
                                        <svg class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </x-gold-button-sm>
                                    <div x-show="open" x-cloak @click.away="open = false"
                                        class="absolute right-0 z-30 w-40 bg-white border border-gray-300 divide-y divide-gray-200 rounded-md shadow-lg">
                                    <a href="" wire:navigate
                                            wire:click="edit({{ $route->id }})"
                                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                            <!-- Details -->
                                        </a>
                                        <button wire:click="edit({{ $route->id }})"
                                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                            Edit
                                        </button>
                                        <button wire:click="confirmRouteDeletion({{ $route->id }})"
                                            class="block px-4 py-2 text-red-600 hover:bg-gray-100">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                No routes found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $routes->links('vendor.pagination.tailwind') }}
        </div>

        <!-- Create/Edit Modal -->
        @if ($showModal)
            <div class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div
                        class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                {{ $editMode ? 'Edit Route' : 'Create Route' }}
                            </h3>
                            <div class="mt-4">
                                <form wire:submit.prevent="save">
                                    <div class="mb-4">
                                        <label for="route_name" class="block text-sm font-medium text-gray-700">Route Name</label>
                                        <input type="text" id="route_name" wire:model="route_name"
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                                        @error('route_name')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </di>
                                    <div class="mb-4">
                                        <label for="route_type_id"
                                            class="block text-sm font-medium text-gray-700">Route Type</label>
                                        <select id="route_type_id" wire:model="route_type_id"
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">Select Route Type</option>
                                            @foreach ($routeTypes as $routeType)
                                                <option value="{{ $routeType->id }}">{{ $routeType->route_type_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('route_type_id')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                        <x-gold-button type="submit"
                                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
                                            {{ $editMode ? 'Update' : 'Create' }}
                                        </x-gold-button>
                                        <button type="button" wire:click="resetForm"
                                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Delete Confirmation Modal -->
        @if ($confirmingRouteDeletion)
            <div class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
                aria-modal="true">
                <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div
                        class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                        Delete Route
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Are you sure you want to delete this route? This action cannot be undone.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" wire:click="deleteRoute"
                                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Delete
                            </button>
                            <button type="button" wire:click="$set('confirmingRouteDeletion', false)"
                                class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- JavaScript for Event Listeners -->
        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('route-saved', (event) => {
                    // You could use a toast notification library here
                    alert(event.message);
                });

                Livewire.on('route-deleted', (event) => {
                    // You could use a toast notification library here
                    alert(event.message);
                });
            });
        </script>
    </div>
</div>
