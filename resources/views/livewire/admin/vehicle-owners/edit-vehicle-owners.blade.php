<div>
    <div class="bg-white rounded-lg shadow">
        <div class="flex items-center justify-between px-4 py-5 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Vehicle Owner</h3>
            <div class="flex space-x-2">
                <a href="{{ route('admin.vehicle-owners.view', $vehicleOwner->uuid) }}" wire:navigate
                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 active:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25">
                    Back
                </a>

            </div>
        </div>
    </div>

    <div class="mt-5 overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                {{ $vehicleOwner->name ?? 'N/A' }}
            </h3>
        </div>
        <div class="p-6">
            <form wire:submit.prevent="updateVehicleOwner" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Owner Name</label>
                        <input type="text" id="name" wire:model="name"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                        @error('name')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="vehicle_owner_type_id" class="block text-sm font-medium text-gray-700">Owner
                            Type</label>
                        <select id="vehicle_owner_type_id" wire:model="vehicle_owner_type_id"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                            <option value="">Select Owner Type</option>
                            @foreach ($vehicleOwnerTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('vehicle_owner_type_id')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact
                            Number</label>
                        <input type="text" id="contact_number" wire:model="contact_number"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                        @error('contact_number')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" id="email" wire:model="email"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                        @error('email')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea id="address" wire:model="address" rows="3"
                        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"></textarea>
                    @error('address')
                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.vehicle-owners.view', $vehicleOwner->uuid) }}" wire:navigate
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <x-gold-button type="submit">
                        Update Vehicle Owner
                    </x-gold-button>
                </div>
            </form>
        </div>
    </div>
</div>
