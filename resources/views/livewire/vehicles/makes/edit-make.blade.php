<div>
    <div class="bg-white rounded-lg shadow">
        <div class="flex items-center justify-between px-4 py-5 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Vehicle Make</h3>
            <div class="flex space-x-2">
                <a href="{{ route('vehicles.makes.view', $make->id) }}" wire:navigate
                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 active:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25">
                    Back
                </a>

            </div>
        </div>
    </div>

    <div class="mt-5 overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                {{ $make->name ?? 'N/A' }}
            </h3>
        </div>

        <div class="p-6">
            <form wire:submit.prevent="updateVehicleMake" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-1">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Make Name</label>
                        <input type="text" id="name" wire:model="name"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                        @error('name')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700">Country of origin</label>
                        <input type="text" id="country" wire:model="country"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                        @error('country')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <input type="description" id="description" wire:model="description"
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                        @error('description')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('vehicles.makes.view', $make->id) }}" wire:navigate
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <x-gold-button type="submit">
                        Update Vehicle Make
                    </x-gold-button>
                </div>
            </form>
        </div>
    </div>
</div>
