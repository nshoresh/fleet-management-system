<div>
    {{-- Vehicle Owner Header --}}
    <x-slot name='header'>
        <div class="px-4 py-2 bg-white">
            <h2 class="text-xl font-semibold">
                {{ $vehicleOwner->company_name ?? $vehicleOwner->business_name }}
            </h2>
        </div>
    </x-slot>
    <div x-data="{showModal: false,openModal() {this.showModal = true;},closeModal() {this.showModal = false;}}">
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
                {{-- Add New Vehicle Button --}}
                <div>
                    <x-gold-button @click="openModal">
                        <x-heroicon-s-plus-circle class="w-5 h-5" /> Add New Vehicle
                    </x-gold-button>
                </div>
            </div>

            <!-- Filters (hidden by default, visible on button click) -->

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

            {{-- Vehicles Table --}}
            <div class="p-4 overflow-x-auto bg-white rounded-lg shadow">
                @if ($vehicles && $vehicles->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-yellow-50">
                            <tr>
                                <th 
                                scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                #</th>
                                <th 
                                scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                VIN</th>
                                <th 
                                scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                License Plate</th>
                                <th 
                                scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                 Type</th>
                                <th 
                                scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                Owner</th>
                                <th 
                                scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                Make(ID)</th>
                                <th 
                                scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                Model(ID)</th>
                                <!--
                                <th class="px-4 py-2 text-sm font-medium text-left text-gray-900">Gross Vehicle Weight</th>
                                <th class="px-4 py-2 text-sm font-medium text-left text-gray-900">Vehicle Tare Weight</th>-->
                                <th scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                    Payload Capacity</th>
                                <!--<th class="px-4 py-2 text-sm font-medium text-left text-gray-900">Vehicle Classification</th>-->
                                <th scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                    Registration Date</th>
                                <th scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                    Status</th>
                                <th scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                    More</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($vehicles as $vehicle)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $vehicle->vin }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $vehicle->license_plate }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $vehicle->engine_type }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $vehicle->vehicleOwner->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $vehicle->make->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $vehicle->makeModel->name }}</td>
                                    <!--
                                    <td class="px-4 py-2 text-sm text-gray-500">{{ $vehicle->gross_vehicle_weight }} kg</td>
                                    <td class="px-4 py-2 text-sm text-gray-500">{{ $vehicle->vehicle_tare_weight }} kg</td>-->
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $vehicle->payload_capacity }} kg</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $vehicle->created_at }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $vehicle->status }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <div class="relative text-left" x-data="{ open: false }">
                                            <x-gold-button-sm x-on:click="open = !open">
                                                <x-icons.three-dots />
                                            </x-gold-button-sm>
                                            <div x-show="open" x-cloak @click.away="open = false"
                                                class="absolute right-0 z-30 w-40 bg-white border border-gray-300 divide-y divide-gray-200 rounded-md shadow-lg">
                                                <a href="#"
                                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-100">More
                                                    Details</a>

                                                <a href="#"
                                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-100">License
                                                    Information</a>

                                                <a href="#"
                                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Charges</a>

                                                <a
                                                    href="{{ route('admin.vehicle-owners.documents', [
                                                        'ownerId' => $vehicleOwner->id,
                                                        'vehicleId' => $vehicle->id,
                                                    ]) }}">
                                                    View Documents
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <div class="p-3 mt-4">
                        {{ $vehicles->links('vendor.pagination.tailwind') }}
                    </div>
                @else
                    <h1 class="text-2xl">No fleets Available</h1>
                @endif
            </div>

            {{-- Modal Component --}}
            <div x-show="showModal" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none">
                <div @click.outside="closeModal()" class="relative w-full max-w-2xl mx-4 my-8 md:mx-auto">
                    <div class="bg-white rounded-lg shadow-xl">
                        <div class="p-6">
                            <livewire:admin.vehicle-owners.fleets.site-fleets-register :vehicle-owner-id="$vehicleOwner->id"
                                :key="'fleet-register-' . $vehicleOwner->id" />
                        </div>
                    </div>
                </div>
            </div>
            {{-- Overlay --}}
            <div x-show="showModal" x-cloak class="fixed inset-0 z-40 bg-black opacity-25"></div>

            {{-- Vehicles Section --}}
            <div class="p-6">
                @if ($vehicles && $vehicles->count() > 0)
                    {{-- Existing vehicles table code --}}
                @else
                    {{-- Existing empty state code --}}
                @endif
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

