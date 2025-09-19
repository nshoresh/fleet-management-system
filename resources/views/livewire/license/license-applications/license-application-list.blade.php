<div>
    <x-slot name='header'>
        <div class="px-4 py-2 bg-yellow-100">
            <h2 class="text-xl font-semibold">
                {{ __('List of License Applications') }}
            </h2>
        </div>
    </x-slot>

    <!-- Filters -->
    <div class="flex flex-wrap items-center gap-4 mb-4">
        <!-- Search -->
        <div class="flex-1 min-w-[250px]">
            <input wire:model.live.debounce.300ms="search" 
                type="text" 
                placeholder="Search by App #, User or Status..."
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <!-- Per Page -->
        <div>
            <select wire:model.live.debounce.300ms="perPage"
                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                <option value="5">5 per page</option>
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
            </select>
        </div>

        <!-- Status Filter -->
        <div>
            <select wire:model.live.debounce.300ms="statusFilter"
                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                <option value="">All Statuses</option>
                <option value="Pending">Pending</option>
                <option value="Under Review">Under Review</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
                <option value="Expired">Expired</option>
            </select>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="p-4 bg-green-50 border-l-4 border-green-500">
            <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 bg-red-100 border-l-4 border-red-500">
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Table -->
    <div class="p-4 overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-yellow-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">App #</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">User</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">License Type</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">Status</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">Submitted</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">Expiry</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-center text-yellow-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($applications as $application)
                    <tr class="border-b">
                        <td class="px-6 py-4">{{ $application->application_number }}</td>
                        <td class="px-6 py-4">{{ $application->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $application->licenseType->type_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                @switch($application->status)
                                    @case('Approved') bg-green-100 text-green-800 @break
                                    @case('Rejected') bg-red-100 text-red-800 @break
                                    @case('Pending') bg-yellow-100 text-yellow-800 @break
                                    @case('Under Review') bg-blue-100 text-blue-800 @break
                                    @case('Expired') bg-gray-100 text-gray-800 @break
                                    @default bg-gray-50 text-gray-600
                                @endswitch">
                                {{ $application->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $application->submission_date->format('Y-m-d') }}</td>
                        <td class="px-6 py-4">{{ $application->expiry_date?->format('Y-m-d') ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="relative inline-block text-left" x-data="{ open: false }">
                                <x-gold-button-sm type="button" 
                                    class="inline-flex justify-center w-full px-2 py-1 text-sm font-medium text-gray-700 focus:outline-none"
                                    @click="open = !open">
                                    <x-icons.three-dots />
                                </x-gold-button-sm>
                                <div x-show="open" x-cloak @click.away="open = false"
                                    class="absolute right-0 z-10 w-40 mt-2 bg-gray-100 border border-gray-300 divide-y divide-gray-200 rounded-md shadow-lg">

                                    <a href="{{ route('admin.license.applications.review', $application->id) }}" 
                                        class="flex justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Review <x-icons.eye-open />
                                    </a>
                                    <a href="{{ route('license.create', ['applicationId' => $application->id]) }}" wire:navigate
                                        class="flex justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Create License <x-icons.plus-circle />
                                    </a>
                                    <a href="{{ route('license.edit', $application->id) }}" 
                                        class="flex justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Edit <x-icons.gear />
                                    </a>
                                    <a href="#" wire:click="confirmDelete({{ $application->id }})"
                                        class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No applications found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $applications->links('vendor.pagination.tailwind') }}
    </div>

    <!-- Delete Modal -->
    @if ($showDeleteModal)
        @include('components.delete-confirmation-modal', ['action' => 'deleteApplication'])
    @endif
</div>
