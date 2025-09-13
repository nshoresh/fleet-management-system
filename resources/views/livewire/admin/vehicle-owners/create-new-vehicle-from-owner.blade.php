<div>
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Add New Vehicle for {{ $owner->name }}</h3>

            @if ($success)
                <div class="p-4 mt-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    Vehicle added successfully!
                    <button wire:click="resetForm" class="ml-2 text-green-900 underline">Add Another</button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="p-4 mt-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="save" class="mt-4">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <!-- Vehicle Make -->
                    <div>
                        <label for="vehicle_make_id" class="block text-sm font-medium text-gray-700">Make</label>
                        <select wire:model.live.debounce.300ms="vehicle_make_id" id="vehicle_make_id"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Make</option>
                            @foreach ($vehicleMakes as $make)
                                <option value="{{ $make->id }}">{{ $make->name }}</option>
                            @endforeach
                        </select>
                        @error('vehicle_make_id')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Vehicle Model -->
                    <div>
                        <label for="vehicle_model_id" class="block text-sm font-medium text-gray-700">Model</label>
                        <select wire:model="vehicle_model_id" id="vehicle_model_id"
                            class="block w-full mt-1 border-gray-300 rounded-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            {{ !$vehicle_make_id ? 'disabled' : '' }}>
                            <option value="">Select Model</option>
                            @foreach ($vehicleModels as $model)
                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                            @endforeach
                        </select>
                        @error('vehicle_model_id')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Vehicle Type -->
                    <div>
                        <label for="vehicle_type_id" class="block text-sm font-medium text-gray-700">Vehicle Type</label>
                        <select wire:model.live.debounce.300ms="vehicle_type_id" id="vehicle_type_id"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Type</option>
                            @foreach ($vehicleTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('vehicle_type_id')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Year -->
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                        <input type="text" wire:model="year" id="year"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('year')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- VIN -->
                    <div>
                        <label for="vin" class="block text-sm font-medium text-gray-700">VIN</label>
                        <input type="text" wire:model.live.debounce.300ms="vin" id="vin"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('vin')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- License Plate -->
                    <div>
                        <label for="license_plate" class="block text-sm font-medium text-gray-700">License Plate</label>
                        <input type="text" wire:model.live.debounce.300ms="license_plate" id="license_plate"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('license_plate')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Color -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                        <input type="text" wire:model="color" id="color"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('color')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Engine Type -->
                    <div>
                        <label for="engine_type" class="block text-sm font-medium text-gray-700">Engine Type</label>
                        <input type="text" wire:model.live.debounce.300ms="engine_type" id="engine_type"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('engine_type')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Mileage -->
                    <div>
                        <label for="mileage" class="block text-sm font-medium text-gray-700">Mileage</label>
                        <input type="number" wire:model="mileage" id="mileage"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('mileage')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Registration Date -->
                    <div>
                        <label for="registration_date" class="block text-sm font-medium text-gray-700">Registration Date</label>
                        <input type="date" wire:model="registration_date" id="registration_date"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('registration_date')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select wire:model="status" id="status"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="sold">Sold</option>
                        </select>
                        @error('status')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <x-gold-button-sm type="button" wire:click="resetForm"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Reset
                    </x-gold-button-sm>
                    <x-gold-button type="submit"
                        class="inline-flex justify-center px-4 py-2 ml-3 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save Vehicle
                    </x-gold-button>
                </div>
            </form>
        </div>
    </div>
</div>
