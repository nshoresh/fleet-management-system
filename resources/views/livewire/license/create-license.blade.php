<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="px-4 py-3 mb-6 rounded-t-lg bg-gradient-to-r from-gray-100 via-gray-300 to-gray-600 shadow">
        <h2 class="text-xl font-semibold text-gray-900">
            {{ __('Create New License') }}
        </h2>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
            <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
        </div>
    @endif

    <!-- Form -->
    <div class="p-6 bg-white rounded-lg shadow">
        <form wire:submit.prevent="store" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Vehicle Owner -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Owner</label>
                <select wire:model="vehicle_owners_id" 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                    <option value="">Select Owner</option>
                    @foreach ($vehicleOwners as $owner)
                        <option value="{{ $owner->id }}" @if($vehicle_owners_id == $owner->id) selected @endif>
                            {{ $owner->name }}
                        </option>
                    @endforeach
                </select>
                @error('vehicle_owners_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Vehicle -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle</label>
                <select wire:model="vehicle_id" 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                    <option value="">Select Vehicle</option>
                    @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" @if($vehicle_id == $vehicle->id) selected @endif>
                            {{ $vehicle->makeType->name }} - {{ $vehicle->license_plate }}
                        </option>
                    @endforeach
                </select>
                @error('vehicle_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Registration Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Registration Number</label>
                <x-gold-text-input type="text" wire:model="registration_number" placeholder="Enter registration number" />
                @error('registration_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- License Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">License Type</label>
                <select wire:model="license_type_id" 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                    <option value="">Select Type</option>
                    @foreach ($licenseTypes as $type)
                        <option value="{{ $type->id }}" @if($license_type_id == $type->id) selected @endif>
                            {{ $type->type_name }}
                        </option>
                    @endforeach
                </select>
                @error('license_type_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Purpose -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Purpose</label>
                <select wire:model="license_purpose_id" 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                    <option value="">Select Purpose</option>
                    @foreach ($licensePurposes as $purpose)
                        <option value="{{ $purpose->id }}" @if($license_purpose_id == $purpose->id) selected @endif>
                            {{ $purpose->purpose_name }}
                        </option>
                    @endforeach
                </select>
                @error('license_purpose_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Route -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Route</label>
                <select wire:model="route_id" 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                    <option value="">Select Route</option>
                    @foreach ($routes as $route)
                        <option value="{{ $route->id }}" @if($route_id == $route->id) selected @endif>
                            {{ $route->route_name }}
                        </option>
                    @endforeach
                </select>
                @error('route_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Start Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <x-gold-text-input type="date" wire:model="license_start_date" />
                @error('license_start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- End Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <x-gold-text-input type="date" wire:model="license_end_date" />
                @error('license_end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model="license_status" 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                    <option value="Active">Active</option>
                    <option value="Expired">Expired</option>
                </select>
                @error('license_status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- License Application -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Application</label>
                <select wire:model="license_application_id" 
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                    <option value="">Select Application</option>
                    @foreach ($applications as $app)
                        <option value="{{ $app->id }}" @if($license_application_id == $app->id) selected @endif>
                            #{{ $app->id }} - {{ $app->created_at->toDateString() }}
                        </option>
                    @endforeach
                </select>
                @error('license_application_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <div class="col-span-1 md:col-span-2 lg:col-span-3 pt-6 text-right">
                <x-gold-button type="submit">
                    Create License
                </x-gold-button>
            </div>
        </form>
    </div>
</div>
