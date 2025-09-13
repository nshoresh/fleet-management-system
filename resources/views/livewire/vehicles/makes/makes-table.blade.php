<div>
    <x-slot name='header'>
        <div class="px-4 py-2 bg-white">
            <h2 class="text-xl font-semibold">
                {{ __('Vehicle Makes') }}
            </h2>
        </div>
    </x-slot>
    <div x-data="{ openDelete: false, makeId: null, showAddMakeModal: false }">
        <!-- Advanced Filters Section -->
        <div x-data="{ showFilters: false }" class="w-full md:w-auto">
            <div class="mb-4 flex flex-wrap items-center gap-4">
                <!-- Search Input -->
                <div class="flex-1 min-w-[250px]">
                    <label for="search" class="block text-sm font-medium text-gray-700"></label>
                    <input wire:model.live.debounce.300ms="search" type="text" id="search"
                        class="block mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Search vehicle make...">
                </div>
                <div wire:loading class="flex items-center justify-center">
                    <x-loading-indicator />
                </div>
                <div>
                    <label for="perPage" class="block text-sm font-medium text-gray-700"></label>
                    <select wire:model.live="perPage" id="perPage"
                        class="px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>   
                </div>
                <!-- Search & Filters -->
                <div> 
                    <x-gold-button-sm @click="showFilters = !showFilters"
                        class="flex items-center px-3 py-2 text-sm border rounded hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        Filters
                        <span class="ml-1 px-2 py-0.5 text-xs bg-blue-100 text-blue-800 rounded-full"
                            x-show="$wire.dateFrom || $wire.dateTo || $wire.status">
                            Active
                        </span>
                    </x-gold-button-sm>
                </div>
                <!-- Add New Button (Aligned Right) -->
                <div>
                    <x-gold-button x-on:click="$dispatch('open-modal', 'makes-registration-modal')"
                        class="inline-flex items-center px-2 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <x-icons.plus-circle /> New Make
                    </x-gold-button>
                </div>
            </div>

            <!-- Advanced Filters Panel -->
            <div x-show="showFilters" x-transition class="p-4 mt-4 border rounded bg-gray-50">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
                    <!-- Date From -->
                    <div class="flex flex-col">
                        <label for="dateFrom" class="text-sm font-medium text-gray-700">From Date</label>
                        <x-gold-text-input type="date" id="dateFrom" wire:model.live="dateFrom" />
                    </div>
                    <!-- Date To -->
                    <div class="flex flex-col">
                        <label for="dateTo" class="text-sm font-medium text-gray-700">To Date</label>
                        <x-gold-text-input type="date" id="dateTo" wire:model.live="dateTo" />
                    </div>
                    <!-- Status Filter -->
                    <div class="flex flex-col">
                        <label for="status" class="text-sm font-medium text-gray-700">Status</label>
                        <select id="status" wire:model.live="status"
                            class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                            <option value="">All Statuses</option>
                            @foreach ($statuses as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    <div class="flex-grow">
                        <x-gold-button x-on:click="$dispatch('open-modal', 'makes-registration-modal')"
                            class="inline-flex items-center px-2 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <x-heroicon-s-plus-circle class="w-5 h-5 mr-2"/> New Make
                        </x-gold-button>
                    </div>

                    <!-- Country Filter -->
                    <div class="flex flex-col">
                        <label for="country" class="text-sm font-medium text-gray-700">Country</label>
                        <select id="country" wire:model.live="country"
                            class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                            <option value="">All Countries</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col mt-6">
                        <x-gold-button-sm wire:click="resetFilters"
                            class="px-4 py-2 text-sm text-gray-700 bg-white border rounded hover:bg-gray-50">
                            Reset Filters
                        </x-gold-button-sm>
                    </div>
                </div>
                <!-- Reset Filters Button -->
            </div>
        </div>
        <!-- Flash message -->
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

        <!-- Table -->
        <div class="p-4 overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-yellow-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer"
                            wire:click="sortBy('id')">
                            ID
                            @if ($sortField === 'id')
                                <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                            @endif
                        </th>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer"
                            wire:click="sortBy('name')">
                            Name
                            @if ($sortField === 'name')
                                <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                            @endif
                        </th>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">
                            Description
                        </th>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer"
                            wire:click="sortBy('created_at')">
                            Created At
                            @if ($sortField === 'created_at')
                                <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                            @endif
                        </th>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer"
                            wire:click="sortBy('country')">
                            Country
                            @if ($sortField === 'country')
                                <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                            @endif
                        </th>
                        <!-- Status column if you have it -->
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer"
                            wire:click="sortBy('status')">
                            Status
                            @if ($sortField === 'status')
                                <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                            @endif
                        </th>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-right text-yellow-700 uppercase">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($makes as $make)
                        <tr class="px-6 text-left border">
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $make->id }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                {{ $make->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ Str::limit($make->description, 50) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $make->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $make->country }}
                            </td>
                            <!-- Status column display if you have it -->
                            <td class="px-6 py-4 text-sm whitespace-nowrap">
                                @if (isset($make->status))
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full {{ $make->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($make->status) }}
                                    </span>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <x-action-dropdown>
                                    <x-slot name="trigger">
                                        <x-gold-button-sm class="text-indigo-600 hover:text-indigo-900">
                                            <x-icons.three-dots />
                                        </x-gold-button-sm>
                                    </x-slot>
                                    <a href="{{ route('vehicles.makes.view', $make) }}" wire:navigate
                                        class="block px-4 py-2 text-gray-800 hover:bg-gray-100">View</a>
                                    <a href="{{ route('vehicles.makes.edit', $make->id) }}" wire:navigate
                                        class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Edit</a>
                                    <button @click="openDelete= true; makeId = {{ $make->id }}"
                                        class="block px-4 py-2 text-red-600 hover:text-red-900">
                                        Delete
                                    </button>
                                </x-action-dropdown>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-sm text-center text-gray-500">
                                No vehicle makes found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $makes->links('vendor.pagination.tailwind') }}
        </div>
        <!-- Delete Confirmation Modal -->
        <div x-show="openDelete" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-transition>
            <div class="p-6 bg-white rounded-lg shadow-lg w-96">
                <h3 class="text-lg font-semibold">Confirm Deletion</h3>
                <p class="mt-2 text-gray-600">Are you sure you want to delete this make? This action cannot be undone.
                </p>
                <div class="flex justify-end mt-4 space-x-2">
                    <button @click="openDelete = false"
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                    <button @click="$wire.call('deleteMake', makeId); openDelete = false"
                        class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>
        <x-modal maxWidth="2xl" name="makes-registration-modal" :show="false" focusable>
            @livewire('vehicles.makes.makes-registration-form-modal')
        </x-modal>
    </div>
</div>

