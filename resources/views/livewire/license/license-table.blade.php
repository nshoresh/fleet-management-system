<div class="px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">License Management</h1>
        <x-gold-button-link href="{{ route('license.create') }}" wire:navigate
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i> Add New License
        </x-gold-button-link>
    </div>

    <!-- Filters -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-2">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        
        <!-- Search Input -->
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
            <input type="text" id="search" wire:model="search" placeholder="Search by name or ID"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 text-sm" />
        </div>

        <!-- License Type -->
        <div>
            <label for="licenseType" class="block text-sm font-medium text-gray-700">License Type</label>
            <select id="licenseType" wire:model="licenseType"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 text-sm">
                <option value="">All</option>
                @foreach($licenseTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- License Purpose -->
        <div>
            <label for="licensePurpose" class="block text-sm font-medium text-gray-700">License Purpose</label>
            <select id="licensePurpose" wire:model="licensePurpose"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 text-sm">
                <option value="">All</option>
                @foreach($licensePurposes as $purpose)
                    <option value="{{ $purpose->id }}">{{ $purpose->purpose_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" wire:model="status"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 text-sm">
                <option value="">All</option>
                <option value="active">Active</option>
                <option value="expired">Expired</option>
            </select>
        </div>

        <!-- Start Date -->
        <div>
            <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date</label>
            <input type="date" id="startDate" wire:model="startDate"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 text-sm" />
        </div>

        <!-- End Date -->
        <div>
            <label for="endDate" class="block text-sm font-medium text-gray-700">End Date</label>
            <input type="date" id="endDate" wire:model="endDate"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 text-sm" />
        </div>
    </div>

    <!-- Clear All Filters Button -->
    <div class="mt-4">
        <button wire:click="clearFilters"
            class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md border border-gray-300 shadow-sm">
            Clear All Filters
        </button>
    </div>
</div>


    <!-- Table -->
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-sm font-medium text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Reg. No</th>
                    <th class="px-4 py-3 text-left">Owner</th>
                    <th class="px-4 py-3 text-left">Vehicle</th>
                    <th class="px-4 py-3 text-left">Type</th>
                    <th class="px-4 py-3 text-left">Purpose</th>
                    <th class="px-4 py-3 text-left">Start</th>
                    <th class="px-4 py-3 text-left">End</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-800">
                @forelse($licenses as $license)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $license->id }}</td>
                        <td class="px-4 py-2">{{ $license->registration_number }}</td>
                        <td class="px-4 py-2">{{ $license->vehicleOwner->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $license->vehicle->plate_number ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $license->licenseType->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $license->licensePurpose->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($license->license_start_date)->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($license->license_end_date)->format('d M Y') }}</td>
                        <td class="px-4 py-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $license->license_status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $license->license_status }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center space-x-2">
                            <button wire:click="viewLicense({{ $license->id }})"
                                    class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button wire:click="editLicense({{ $license->id }})"
                                    class="text-yellow-500 hover:text-yellow-700">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button wire:click="confirmDelete({{ $license->id }})"
                                    class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-gray-500 py-4">No licenses found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $licenses->links() }}
        </div>
    </div>
</div>
