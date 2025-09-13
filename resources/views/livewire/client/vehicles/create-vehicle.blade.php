<div>
    <x-slot name='header'>
        <div class="px-4 py-2 bg-gradient-to-r from-yellow-200 to-yellow-100">
            <h2 class="text-xl text-center font-semibold fill-orange-400">
                {{ __(' Vehicle Registration') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-6 mx-auto max-w-12xl sm:px-6 lg:px-8">
        <div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                @if (session()->has('error'))
                    <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($successMessage)
                    <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded"
                        role="alert">
                        <span class="block sm:inline">{{ $successMessage }}</span>
                    </div>
                @endif

                <form wire:submit.prevent="saveVehicle">
                    <div class="overflow-hidden shadow rounded-2xl sm:rounded-2xl">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <h1 class="mb-4 font-medium text-yellow-700">Basic Information</h1>
                                <div class="p-4 grid grid-cols-6 bg-yellow-50 gap-6">

                                    <!-- Vehicle Type Dropdown -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="vehicle_type_id" class="block text-sm font-medium text-gray-700">1. Vehicle Type</label>
                                        <select id="vehicle_type_id" wire:model.live="vehicle_type_id"
                                            class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                            <option value="">Select Type</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <!-- VIN -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <div class="flex items-center justify-between">
                                            <label for="vin"
                                                class="block text-sm font-medium text-gray-700">5. VIN</label>
                                            <div class="flex items-center">
                                                <input id="generateVin" type="checkbox" wire:model="generateVin"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="generateVin" class="ml-2 text-sm text-gray-600">Auto
                                                    Generate</label>
                                            </div>
                                        </div>
                                        <x-gold-text-input type="text" id="vin" wire:model="vin" />
                                        @error('vin')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <!-- Chassis Number -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="chassis_number" class="block text-sm font-medium text-gray-700">9. Chassis
                                            Number</label>
                                        <x-gold-text-input type="text" id="chassis_number" wire:model="chassis_number" />
                                        @error('chassis_number')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <!-- Vehicle Make -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="vehicle_make_id"
                                            class="block text-sm font-medium text-gray-700">2. Make</label>
                                        <select id="vehicle_make_id" wire:model.live.debounce.300ms="vehicle_make_id"
                                            class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                            <option value="">Select Make</option>
                                            @foreach ($makes as $make)
                                                <option value="{{ $make->id }}">{{ $make->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('vehicle_make_id')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                   
                                    <!-- Engine Number -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="engine_number" class="block text-sm font-medium text-gray-700">6. Engine
                                            Number</label>
                                        <x-gold-text-input type="text" id="engine_number" wire:model="engine_number" />
                                        @error('engine_number')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                     <!-- Year -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="year" class="block text-sm font-medium text-gray-700">10. Year</label>
                                        <select 
                                            id="year" 
                                            wire:model="year" 
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm"
                                        >
                                            <option value="">Select Year</option>
                                            @foreach($years as $y)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                            @endforeach
                                        </select>
                                        @error('year')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Vehicle Model -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="vehicle_model_id"
                                            class="block text-sm font-medium text-gray-700">3. Model</label>
                                        <select id="vehicle_model_id" wire:model="vehicle_model_id"
                                            class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm"
                                            {{ !$vehicle_make_id ? 'disabled' : '' }}>
                                            <option value="">Select Model</option>
                                            @foreach ($models as $model)
                                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('vehicle_model_id')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Color -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="color" class="block text-sm font-medium text-gray-700">7. Color</label>
                                        <x-gold-text-input type="text" id="color" wire:model="color" />
                                        @error('color')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="status" class="block text-sm font-medium text-gray-700">11. Status</label>
                                        <select id="status" wire:model="status"
                                            class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                            @foreach ($statusOptions as $option)
                                                <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Vehicle Classification -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="vehicle_classification_id" class="block text-sm font-medium text-gray-700">4. Vehicle
                                            Classification</label>
                                        <select id="vehicle_classification_id" wire:model="vehicle_classification_id"
                                            class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                            <option value="">Select Vehicle Classification</option>
                                            @foreach ($vehicle_classifications as $vehicle_classification)
                                                <option value="{{ $vehicle_classification->id }}">{{ $vehicle_classification->classification_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('vehicle_classification_id')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- License Plate -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="license_plate" class="block text-sm font-medium text-gray-700">8. License
                                            Plate</label>
                                        <x-gold-text-input type="text" id="license_plate" wire:model="license_plate" />
                                        @error('license_plate')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            <h1 class="mt-8 mb-4 font-medium text-yellow-700">Vehicle Details</h1>
                                <div class="p-4 grid grid-cols-6 bg-yellow-50 gap-6">
                                    <!-- Engine Type -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="engine_type" class="block text-sm font-medium text-gray-700">12. Engine
                                            Type</label>
                                        <x-gold-text-input type="text" id="engine_type" wire:model="engine_type" />
                                        @error('engine_type')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Mileage -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="mileage"
                                            class="block text-sm font-medium text-gray-700">15. Mileage</label>
                                        <x-gold-text-input type="number" id="mileage" wire:model="mileage" />
                                        @error('mileage')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                     <!-- Last Service Date -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="last_service_date"
                                            class="block text-sm font-medium text-gray-700">18. Last Service Date</label>
                                        <x-gold-text-input type="date" id="last_service_date"
                                            wire:model="last_service_date" />
                                        @error('last_service_date')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Fuel Type -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="fuel_type" class="block text-sm font-medium text-gray-700">13. Fuel
                                            Type</label>
                                        <select id="fuel_type" wire:model="fuel_type"
                                            class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                            <option value="">Select Fuel Type</option>
                                            @foreach ($fuelOptions as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                        @error('fuel_type')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Vehicle Condition -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="vehicle_condition"
                                            class="block text-sm font-medium text-gray-700">16. Vehicle Condition</label>
                                        <select id="vehicle_condition" wire:model="vehicle_condition"
                                            class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                            <option value="">Select Condition</option>
                                            @foreach ($conditionOptions as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                        @error('vehicle_condition')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Seating Capacity -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="seating_capacity"
                                            class="block text-sm font-medium text-gray-700">19. Seating Capacity</label>
                                        <x-gold-text-input type="number" id="seating_capacity"
                                            wire:model="seating_capacity" />
                                        @error('seating_capacity')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Transmission Type -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="transmission_type"
                                            class="block text-sm font-medium text-gray-700">14. Transmission Type</label>
                                        <select id="transmission_type" wire:model="transmission_type"
                                            class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                            <option value="">Select Transmission</option>
                                            @foreach ($transmissionOptions as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                        @error('transmission_type')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Registration Date -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="registration_date"
                                            class="block text-sm font-medium text-gray-700">17. Registration Date</label>
                                        <x-gold-text-input type="date" id="registration_date"
                                            wire:model="registration_date" />
                                        @error('registration_date')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Insurance Status -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="insurance_status"
                                            class="block text-sm font-medium text-gray-700">20. Insurance Status</label>
                                        <select id="insurance_status" wire:model="insurance_status"
                                            class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                            <option value="">Select Status</option>
                                            @foreach ($insuranceOptions as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                        @error('insurance_status')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Additional Features -->
                                    <div class="col-span-6">
                                        <label for="additional_features"
                                            class="block text-sm font-medium text-gray-700">21. Additional Features</label>
                                        <textarea id="additional_features" wire:model="additional_features" rows="3"
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                        @error('additional_features')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- @if ($showHeavyVehicleFields) --}}
                            <h1 class="mt-8 mb-4 font-medium text-yellow-700">Heavy Vehicle Specifications</h1>
                                <div class="p-4 grid grid-cols-6 bg-yellow-50 gap-6">
                                    <!-- Vehicle Weight Fields (shown when showVehicleFields is true) -->
                                    @if($showVehicleFields)
                                        <div class="col-span-6 sm:col-span-2">
                                            <label for="gross_vehicle_weight" class="block text-sm font-medium text-gray-700">Gross Vehicle Weight (kg)</label>
                                            <x-gold-text-input type="number" step="0.01" id="gross_vehicle_weight" wire:model="gross_vehicle_weight" />
                                        </div>

                                        <div class="col-span-6 sm:col-span-2">
                                            <label for="vehicle_tare_weight" class="block text-sm font-medium text-gray-700">Vehicle Tare Weight (kg)</label>
                                            <x-gold-text-input type="number" step="0.01" id="vehicle_tare_weight" wire:model="vehicle_tare_weight" />
                                        </div>
                                    @endif

                                    <!-- Trailer Weight Fields (shown when showTrailerFields is true) -->
                                    @if($showTrailerFields)
                                        <div class="col-span-6 sm:col-span-2">
                                            <label for="gross_trailer_weight" class="block text-sm font-medium text-gray-700">Gross Trailer Weight (kg)</label>
                                            <x-gold-text-input type="number" step="0.01" id="gross_trailer_weight" wire:model="gross_trailer_weight" />
                                        </div>

                                        <div class="col-span-6 sm:col-span-2">
                                            <label for="trailer_tare_weight" class="block text-sm font-medium text-gray-700">Trailer Tare Weight (kg)</label>
                                            <x-gold-text-input type="number" step="0.01" id="trailer_tare_weight" wire:model="trailer_tare_weight" />
                                        </div>
                                    @endif
                                    <!-- Tire Capacity -->
                                    <!-- Tire Capacity -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="tire_capacity" class="block text-sm font-medium text-gray-700">Tire
                                            Capacity (kg)</label>
                                        <x-gold-text-input type="number" step="0.01" id="tire_capacity"
                                            wire:model="tire_capacity" />
                                        @error('tire_capacity')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Axle Configuration -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="axle_configuration"
                                            class="block text-sm font-medium text-gray-700">Axle Configuration</label>
                                        <select id="axle_configuration" wire:model="axle_configuration"
                                            class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">Select Configuration</option>
                                            @foreach ($axleOptions as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                        @error('axle_configuration')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Number of Axles -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="number_of_axles"
                                            class="block text-sm font-medium text-gray-700">Number of Axles</label>
                                        <x-gold-text-input type="number" id="number_of_axles"
                                            wire:model="number_of_axles" />
                                        @error('number_of_axles')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Engine Power -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="engine_power" class="block text-sm font-medium text-gray-700">Engine
                                            Power (HP)</label>
                                        <x-gold-text-input type="number" step="0.01" id="engine_power"
                                            wire:model="engine_power" />
                                        @error('engine_power')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Torque -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="torque" class="block text-sm font-medium text-gray-700">Torque
                                            (Nm)</label>
                                        <x-gold-text-input type="number" step="0.01" id="torque"
                                            wire:model="torque" />
                                        @error('torque')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            {{-- @endif --}}
                        </div>
                        <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                            <button type="button"
                                class="inline-flex justify-center px-4 py-2 mr-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                            <x-gold-button type="submit"
                                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Vehicle
                            </x-gold-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
