<div class="bg-gray-50 min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">License Renewal Applications</h1>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="w-full sm:w-1/3">
                        <div class="relative">
                            <input wire:model.debounce.300ms="search" type="text"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search application, owner, or vehicle...">
                            <span class="absolute left-3 top-2.5 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/4">
                        <div class="relative">
                            <select wire:model="statusFilter"
                                class="w-full py-2 pl-3 pr-10 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 appearance-none">
                                <option value="">All Statuses</option>
                                @foreach ($statusOptions as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                            <span class="absolute right-3 top-2.5 text-gray-400 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/4">
                        <div class="relative">
                            <select wire:model="dateFilter"
                                class="w-full py-2 pl-3 pr-10 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 appearance-none">
                                <option value="">All Dates</option>
                                @foreach ($dateFilterOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <span class="absolute right-3 top-2.5 text-gray-400 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="mt-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 relative"
                        x-data="{ show: true }" x-show="show">
                        <span>{{ session('message') }}</span>
                        <button @click="show = false" class="absolute top-4 right-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Application #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                License ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Owner</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Vehicle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                License Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Requested Period</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($applications as $application)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $application->application_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $application->license_id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $application->vehicleOwner->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $application->vehicle->plate_number ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $application->licenseType->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $application->requested_start_date->format('M d, Y') }} -
                                    {{ $application->requested_end_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if ($application->status == 'Approved') bg-green-100 text-green-800
                                        @elseif($application->status == 'Rejected') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ $application->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $application->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button wire:click="viewDetails({{ $application->id }})"
                                            class="p-1 rounded-full text-blue-600 hover:bg-blue-100"
                                            title="View Details">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        @if ($application->status == 'Pending')
                                            <button wire:click="approveApplication({{ $application->id }})"
                                                class="p-1 rounded-full text-green-600 hover:bg-green-100"
                                                title="Approve Application"
                                                onclick="return confirm('Are you sure you want to approve this application?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>

                                            <button type="button"
                                                class="p-1 rounded-full text-red-600 hover:bg-red-100"
                                                title="Reject Application" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $application->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>

                                            <!-- Reject Modal -->
                                            <div class="modal fade" id="rejectModal{{ $application->id }}"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content rounded-lg shadow-xl">
                                                        <div class="modal-header border-b p-4">
                                                            <h5 class="modal-title text-lg font-medium text-gray-900">
                                                                Reject Application</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <div class="mb-4">
                                                                <label for="rejectionReason{{ $application->id }}"
                                                                    class="block text-sm font-medium text-gray-700 mb-2">
                                                                    Rejection Reason
                                                                </label>
                                                                <textarea id="rejectionReason{{ $application->id }}"
                                                                    class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                                    rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="modal-footer bg-gray-50 px-4 py-3 flex justify-end gap-3 rounded-b-lg">
                                                            <button type="button"
                                                                class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                                                data-bs-dismiss="modal">
                                                                Cancel
                                                            </button>
                                                            <button type="button"
                                                                class="px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                                onclick="Livewire.emit('rejectApplication', {{ $application->id }}, document.getElementById('rejectionReason{{ $application->id }}').value);"
                                                                data-bs-dismiss="modal">
                                                                Reject
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-sm text-center text-gray-500">No renewal
                                    applications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $applications->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('rejectApplication', function(id, reason) {
                @this.rejectApplication(id, reason);
            });
        });
    </script>
</div>
