<div class="p-4">
    <div class="flex justify-between mb-4">
        <input
            type="text"
            wire:model.debounce.500ms="search"
            placeholder="Search by Application Number or Status"
            class="border rounded px-4 py-2 w-1/2"
        >

        <select wire:model="statusFilter" class="border rounded px-4 py-2">
            <option value="">All Statuses</option>
            <option value="Pending">Pending</option>
            <option value="Under Review">Under Review</option>
            <option value="Approved">Approved</option>
            <option value="Rejected">Rejected</option>
            <option value="Expired">Expired</option>
        </select>
    </div>

    <table class="w-full table-auto border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">Application #</th>
                <th class="px-4 py-2 text-left">User</th>
                <th class="px-4 py-2 text-left">License Type</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Submitted On</th>
                <th class="px-4 py-2 text-left">Expiry</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $application)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $application->application_number }}</td>
                    <td class="px-4 py-2">{{ $application->user->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $application->licenseType->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded text-sm {{ 
                            match($application->status) {
                                'Approved' => 'bg-green-200 text-green-800',
                                'Rejected' => 'bg-red-200 text-red-800',
                                'Pending' => 'bg-yellow-200 text-yellow-800',
                                'Under Review' => 'bg-blue-200 text-blue-800',
                                'Expired' => 'bg-gray-200 text-gray-800',
                                default => '',
                            }
                        }}">
                            {{ $application->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ $application->submission_date->format('Y-m-d') }}</td>
                    <td class="px-4 py-2">{{ $application->expiry_date?->format('Y-m-d') ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-2 text-center text-gray-500">No applications found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $applications->links() }}
    </div>
</div>
