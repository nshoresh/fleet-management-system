< <div class="bg-white border-b border-gray-200 ">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Vehicle Details</h1>
        <div>

            {{-- <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                            class="inline-flex items-center px-4 py-2 ml-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25">
                            Edit Vehicle
                        </a> --}}
        </div>
    </div>

    <!-- Vehicle Basic Info -->
    <div class="p-4 mb-6 rounded-lg bg-gray-50">
        <h2 class="mb-4 text-xl font-medium">Basic Information</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div>
                <p class="text-sm font-medium text-gray-500">License Plate</p>
                <p class="mt-1">{{ $vehicle->license_plate }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">VIN</p>
                <p class="mt-1">{{ $vehicle->vin }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Status</p>
                <p class="mt-1">
                    <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if ($vehicle->status === 'active') bg-green-100 text-green-800
                                    @elseif($vehicle->status === 'inactive') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($vehicle->status) }}
                    </span>
                </p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Make</p>
                <p class="mt-1">{{ $vehicle->make->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Model</p>
                <p class="mt-1">{{ $vehicle->makeModel->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Year</p>
                <p class="mt-1">{{ $vehicle->year }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Type</p>
                <p class="mt-1">{{ $vehicle->makeType->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Owner</p>
                <p class="mt-1">{{ $vehicle->makeOwner->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Color</p>
                <p class="mt-1">{{ $vehicle->color ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Vehicle Technical Info -->
    <div class="p-4 mb-6 rounded-lg bg-gray-50">
        <h2 class="mb-4 text-xl font-medium">Technical Information</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div>
                <p class="text-sm font-medium text-gray-500">Engine Type</p>
                <p class="mt-1">{{ $vehicle->engine_type ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Transmission</p>
                <p class="mt-1">{{ $vehicle->transmission_type ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Fuel Type</p>
                <p class="mt-1">{{ $vehicle->fuel_type ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Mileage</p>
                <p class="mt-1">{{ $vehicle->mileage ?? 'N/A' }} km</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Seating Capacity</p>
                <p class="mt-1">{{ $vehicle->seating_capacity ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Condition</p>
                <p class="mt-1">{{ $vehicle->vehicle_condition ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Engine Power</p>
                <p class="mt-1">{{ $vehicle->engine_power ?? 'N/A' }}
                    {{ $vehicle->engine_power ? 'hp' : '' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Torque</p>
                <p class="mt-1">{{ $vehicle->torque ?? 'N/A' }} {{ $vehicle->torque ? 'Nm' : '' }}</p>
            </div>
        </div>
    </div>

    <!-- Vehicle Additional Info -->
    <div class="p-4 mb-6 rounded-lg bg-gray-50">
        <h2 class="mb-4 text-xl font-medium">Additional Information</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div>
                <p class="text-sm font-medium text-gray-500">Registration Date</p>
                <p class="mt-1">
                    {{-- {{ $vehicle->registration_date ? $vehicle->registration_date->format('Y-m-d') : 'N/A' }} --}}
                </p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Insurance Status</p>
                <p class="mt-1">{{ $vehicle->insurance_status ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Last Service Date</p>
                <p class="mt-1">
                    {{-- {{ $vehicle->last_service_date ? $vehicle->last_service_date->format('Y-m-d') : 'N/A' }} --}}
                </p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Additional Features</p>
                <p class="mt-1">{{ $vehicle->additional_features ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Heavy Vehicle Specifications (only shown if applicable) -->
    @if ($vehicle->gross_vehicle_weight || $vehicle->payload_capacity || $vehicle->number_of_axles)
        <div class="p-4 mb-6 rounded-lg bg-gray-50">
            <h2 class="mb-4 text-xl font-medium">Heavy Vehicle Specifications</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <p class="text-sm font-medium text-gray-500">Gross Vehicle Weight</p>
                    <p class="mt-1">{{ $vehicle->gross_vehicle_weight ?? 'N/A' }}
                        {{ $vehicle->gross_vehicle_weight ? 'kg' : '' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Gross Trailer Weight</p>
                    <p class="mt-1">{{ $vehicle->gross_trailer_weight ?? 'N/A' }}
                        {{ $vehicle->gross_trailer_weight ? 'kg' : '' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Payload Capacity</p>
                    <p class="mt-1">{{ $vehicle->payload_capacity ?? 'N/A' }}
                        {{ $vehicle->payload_capacity ? 'kg' : '' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Tire Capacity</p>
                    <p class="mt-1">{{ $vehicle->tire_capacity ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Axle Configuration</p>
                    <p class="mt-1">{{ $vehicle->axle_configuration ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Number of Axles</p>
                    <p class="mt-1">{{ $vehicle->number_of_axles ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    @endif
    </div>
