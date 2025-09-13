<div>
    @if ($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

                <!-- Modal panel -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                    Edit Vehicle Owner Details
                                </h3>

                                <div class="mt-4">
                                    <form wire:submit.prevent="updateVehicleOwner" class="space-y-4">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Owner
                                                Name</label>
                                            <input type="text" id="name" wire:model="name"
                                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                placeholder="Enter owner name">
                                            @error('name')
                                                <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="vehicle_owner_type_id"
                                                class="block text-sm font-medium text-gray-700">Owner Type</label>
                                            <select id="vehicle_owner_type_id" wire:model="vehicle_owner_type_id"
                                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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
                                            <label for="contact_number"
                                                class="block text-sm font-medium text-gray-700">Contact Number</label>
                                            <input type="text" id="contact_number" wire:model="contact_number"
                                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                placeholder="Enter contact number">
                                            @error('contact_number')
                                                <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email
                                                Address</label>
                                            <input type="email" id="email" wire:model="email"
                                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                placeholder="Enter email address">
                                            @error('email')
                                                <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="address"
                                                class="block text-sm font-medium text-gray-700">Address</label>
                                            <textarea id="address" wire:model="address" rows="3"
                                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                placeholder="Enter address"></textarea>
                                            @error('address')
                                                <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="updateVehicleOwner"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Update
                        </button>
                        <button type="button" wire:click="closeModal"
                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
