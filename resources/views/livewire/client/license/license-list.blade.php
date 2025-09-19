<div class="py-8">
    <div class="mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">

            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between px-6 py-4 gap-3 border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-800">License Applications</h1>
                <x-gold-button-link href="{{ route('client.app.license_create') }}" wire:navigate>
                    <x-icons.plus-circle class="w-5 h-5 mr-1" /> Add New License
                </x-gold-button-link>
            </div>

            <!-- Filters -->
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row gap-4 lg:items-center">
                    <input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Search application # or purpose..."
                        class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

                    <select wire:model="statusFilter"
                        class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">All Statuses</option>
                        <option value="Approved">Approved</option>
                        <option value="Pending">Pending</option>
                        <option value="Rejected">Rejected</option>
                    </select>

                    <button wire:click="resetFilters"
                        class="px-4 py-2 font-medium text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                        Reset
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto overflow-y-auto max-h-[65vh]">
                <table class="min-w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600 sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-3 cursor-pointer" wire:click="sortBy('application_number')">
                                Application #
                                @if ($sortField === 'application_number')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </th>
                            <th class="px-6 py-3">License Type</th>
                            <th class="px-6 py-3">Purpose</th>
                            <th class="px-6 py-3 cursor-pointer" wire:click="sortBy('submission_date')">
                                Submission Date
                                @if ($sortField === 'submission_date')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </th>
                            <th class="px-6 py-3">Expiry Date</th>
                            <th class="px-6 py-3 cursor-pointer" wire:click="sortBy('status')">
                                Status
                                @if ($sortField === 'status')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($licenseApplications as $application)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $application->application_number }}
                                </td>
                                <td class="px-6 py-4">{{ $application->licenseType->type_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $application->purpose ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $application->submission_date }}</td>
                                <td class="px-6 py-4">{{ $application->expiry_date ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $application->status === 'Approved' ? 'bg-green-100 text-green-700' : ($application->status === 'Pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ ucfirst($application->status ?? 'Pending') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="relative" x-data="{ open: false }">
                                        <x-gold-button-sm x-on:click="open = !open">
                                            <x-icons.three-dots />
                                        </x-gold-button-sm>
                                        <div x-show="open" x-cloak @click.away="open = false"
                                            class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-30">
                                            <a href="{{ route('app.license_view', $application->id) }}" wire:navigate
                                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">View</a>
                                            <a href="{{ route('app.license_edit', $application->id) }}" wire:navigate
                                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Edit</a>
                                            <button wire:click="confirmDelete({{ $application->id }})"
                                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    <p class="mb-2">No license applications found.</p>
                                    <a href="{{ route('client.app.license_create') }}" wire:navigate
                                        class="inline-block text-indigo-600 hover:text-indigo-900 font-medium">
                                        + Create a new license
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3 bg-gray-50 border-t border-gray-200">
                <div>
                    <select wire:model.live.debounce.300ms="perPage"
                        class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>
                <div>
                    {{ $licenseApplications->links('vendor.pagination.tailwind') }}
                </div>
            </div>

        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ open: @entangle('showDeleteModal') }"
        x-show="open"
        x-cloak
        class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">

        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Confirm Delete
            </h2>
            <p class="text-gray-600 mb-6">
                Are you sure you want to delete this license application? This action cannot be undone.
            </p>

            <div class="flex justify-end gap-3">
                <button @click="open = false"
                    wire:click="$set('showDeleteModal', false)"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
                <button wire:click="deleteLicense"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Confirm Delete
                </button>
            </div>
        </div>
    </div>
</div>
