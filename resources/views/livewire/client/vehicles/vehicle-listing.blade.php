<div class="py-6">
    <div>
        <div>
            <di>

                <div class="flex justify-between mb-2">
                    <h1 class="font-semibold ">Vehicle Management</h1>
                    <x-gold-button-link href="{{ route('app.vehicles_create') }}" wire:navigate>
                        <x-icons.plus-circle /> Add New Vehicle
                    </x-gold-button-link>
                </div>

                <!-- Filters Section -->
                <div class="p-4 mb-6 bg-gray-100 rounded-lg">
                    <div class="flex flex-col space-y-4 md:flex-row md:space-y-0">
                        <div class="pr-2 md:w-1/3">
                            <input wire:model.live.debounce.300ms="search" type="text"
                                placeholder="Search VIN, plate, color..."
                                class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <div class="flex justify-between gap-2 md:w-2/3">
                            <select wire:model="makeFilter"
                                class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Makes</option>
                                @foreach ($makes as $make)
                                    <option value="{{ $make->id }}">{{ $make->name }}</option>
                                @endforeach
                            </select>

                            <select wire:model="typeFilter"
                                class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Types</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>

                            <select wire:model="statusFilter"
                                class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Statuses</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            <select wire:model="yearFilter"
                                class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Years</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>

                            <button wire:click="resetFilters"
                                class="px-4 py-2 font-bold text-gray-800 bg-gray-300 rounded hover:bg-gray-400">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer"
                                    wire:click="sortBy('license_plate')">
                                    License Plate
                                    @if ($sortField === 'license_plate')
                                        @if ($sortDirection === 'asc')
                                            <span>↑</span>
                                        @else
                                            <span>↓</span>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer"
                                    wire:click="sortBy('vin')">
                                    VIN
                                    @if ($sortField === 'vin')
                                        @if ($sortDirection === 'asc')
                                            <span>↑</span>
                                        @else
                                            <span>↓</span>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Make & Model
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Vehicle Type
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Payload Capacity
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Year
                                </th>
                                {{-- <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Owner
                                </th> --}}
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer"
                                    wire:click="sortBy('status')">
                                    Status
                                    @if ($sortField === 'status')
                                        @if ($sortDirection === 'asc')
                                            <span>↑</span>
                                        @else
                                            <span>↓</span>
                                        @endif
                                    @endif
                                </th><!--
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Actions
                                </th>-->
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($vehicles as $vehicle)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->license_plate }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->vin }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $vehicle->make->name ?? 'N/A' }} {{ $vehicle->makeModel->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->makeType->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->payload_capacity ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->year }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if ($vehicle->status === 'active') bg-green-100 text-green-800
                                            @elseif($vehicle->status === 'inactive') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($vehicle->status) }}
                                        </span>
                                    </td><!--
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <a href="{{ route('app.vehicles_view', $vehicle->uuid) }}" wire:navigate
                                            class="mr-3 text-indigo-600 hover:text-indigo-900">View</a>
                                        <a href="{{ route('app.vehicles_edit', $vehicle->uuid) }}" wire:navigate
                                            class="mr-3 text-blue-600 hover:text-blue-900">Edit</a>
                                        <a href="{{ route('client.app.license_create', ['vehicleId' => $vehicle->id]) }}" class="btn btn-primary">
                                            License Application
                                        </a>
                                    </td>-->
                                    <td class="px-4 py-2 text-sm text-gray-500">
                                    <!--<livewire:client.vehicles.view-vehicle :id="$vehicle->id" lazy />-->
                                        <div class="relative text-left" x-data="{ open: false }">
                                            <x-gold-button-sm x-on:click="open = !open">
                                                <x-icons.three-dots />
                                            </x-gold-button-sm>
                                            <div x-show="open" x-cloak @click.away="open = false"
                                                class="absolute right-0 z-30 w-40 bg-white border border-gray-300 divide-y divide-gray-200 rounded-md shadow-lg">
                                                <a href="{{ route('app.vehicles_view', $vehicle->uuid) }}" wire:navigate
                                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-100">View</a>

                                                <a href="{{ route('app.vehicles_edit', $vehicle->uuid) }}" wire:navigate
                                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Edit</a>

                                                    <button wire:click="confirmDelete({{ $vehicle->id }})"
                                                        class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100">
                                                        Delete
                                                    </button>

                                                <!--<a href="{{ route('app.vehicle_download_pdf', $vehicle->uuid) }}" wire:navigate
                                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Download PDF</a>-->

                                                @if (!$vehicle->license)
                                                    <a href="{{ route('client.app.license_create', ['vehicleId' => $vehicle->id]) }}"
                                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                                    License Application
                                                    </a>
                                                @else
                                                    <span class="block px-4 py-2 text-gray-400 cursor-not-allowed">
                                                        License Already Exists
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                        No vehicles found.
                                        <a href="{{ route('app.vehicles_create') }}" wire:navigate
                                            class="text-indigo-600 hover:text-indigo-900">Add a new vehicle</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <select wire:model.live.debounce.300ms="perPage"
                                class="mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="10">10 per page</option>
                                <option value="25">25 per page</option>
                                <option value="50">50 per page</option>
                                <option value="100">100 per page</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            {{ $vehicles->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div><!-- Add New Vehicle Button -->
            </di>
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
                Are you sure you want to delete this vehicle? This action cannot be undone.
            </p>

            <div class="flex justify-end gap-3">
                <button @click="open = false"
                    wire:click="$set('showDeleteModal', false)"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
                <button wire:click="deleteVehicle"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Confirm Delete
                </button>
            </div>
        </div>
    </div>
</div>
