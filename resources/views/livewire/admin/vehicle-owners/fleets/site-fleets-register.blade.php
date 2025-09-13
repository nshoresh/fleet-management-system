<div>
    <h2 class="mb-4 text-xl font-semibold"> New Vehicle Registration Form </h2>
    @if (session()->has('success'))
        <div class="p-3 mb-4 text-green-800 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="p-3 mb-4 text-red-800 bg-red-100 rounded">
            {{ session('error') }}
        </div>
    @endif
    <form wire:submit.prevent="createVehicle" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Make</label>
                <select wire:model.live.debounce.300ms="vehicle_make_id"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                    <option value="">Select Make</option>
                    @foreach ($VehicleMakes as $VehicleMake)
                        <option value="{{ $VehicleMake->id }}">
                            {{ $VehicleMake->name }}
                        </option>
                    @endforeach
                </select>
                @error('vehicle_make_id')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Model</label>
                <select wire:model.live.debounce.300ms="vehicle_model_id"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
                    @if (empty($vehicle_make_id)) disabled @endif>
                    <option value="">Select Model</option>
                    @foreach ($availableModels as $model)
                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                    @endforeach
                </select>
                @error('vehicle_model_id')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Year</label>
                <input type="number" wire:model.defer="year"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('year')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">VIN</label>
                <input type="text" wire:model.defer="vin"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('vin')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Color</label>
                <input type="text" wire:model.defer="color"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('color')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">License Plate</label>
                <input type="text" wire:model.defer="plate_number"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('plate_number')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Gross Vehicle Weight (kg)</label>
                <input type="text" wire:model.defer="gross_vehicle_weight"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('gross_vehicle_weight"')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Vehicle Tare Weight (kg)</label>
                <input type="text" wire:model.defer="vehicle_tare_weight"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('vehicle_tare_weight')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Gross Trailer Weight (kg)</label>
                <input type="text" wire:model.defer="gross_trailer_weight"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('gross_trailer_weight"')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Vehicle Tare Weight (kg)</label>
                <input type="text" wire:model.defer="trailer_tare_weight"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('trailer_tare_weight')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Engine Type</label>
                <input type="text" wire:model.defer="engine_type"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('engine_type')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Mileage</label>
                <input type="number" wire:model.defer="mileage"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('mileage')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
               <label class="block text-sm font-medium">Vehicle Classification</label>
                <select wire:model.defer="vehicle_classification_id"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                    <option value="">Select Vehicle Classification</option>
                    @foreach ($vehicleClassifications as $vehicleClassification)
                        <option value="{{ $vehicleClassification->id }}">{{ $vehicleClassification->classification_name }}</option>
                    @endforeach
                </select>
                @error('vehicle_classification_id')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        
            <div>
                <label class="block text-sm font-medium">Vehicle Type</label>
                <select wire:model.defer="vehicle_type_id"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                    <option value="">Select Type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('vehicle_type_id')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <x-gold-button type="submit">Register Vehicle</x-gold-button>
    </form>
</div>
