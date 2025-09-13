<div class="container px-8 py-8 mx-auto">
   <div class="overflow-hidden bg-white rounded-lg shadow-md">
    {{-- Vehicle Owner Header --}}
        <div class="p-2 bg-gray-100 rounded-t-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">
                        {{ $vehicleOwner->company_name ?? $vehicleOwner->name }} - Vehicle Plate: {{ $vehicle->license_plate }}
                    </h1>
                </div>
            </div>
        </div>
   </div>
</div>
