<div>
    <h2 class="mb-4 text-xl font-semibold">Edit Vehicle Classification</h2>

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

    <form wire:submit.prevent="updateVehicleClassification" class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium">Classification Name</label>
                <input type="text" wire:model="classification_name"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('classification_name')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium">Minimum Weight (kg)</label>
                <input type="number" step="any" wire:model="min_weight"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('min_weight')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium">Maximum Weight (kg)</label>
                <input type="number" step="any" wire:model="max_weight"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('max_weight')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium">RDC Fee (K)</label>
                <input type="number" step="any" wire:model="rdc_fee"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('rdc_fee')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium">Description</label>
                <textarea wire:model="description"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">{{ $description }}</textarea>
                @error('description')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex items-center">
            <div class="ml-2 flex items-center space-x-2">
                <input id="is_active" type="checkbox" wire:model="is_active"
                    class="h-4 w-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500"
                    {{ $is_active ? 'checked' : '' }} />
                <label for="is_active" class="text-sm">Active</label>
            </div>
        </div>


        <div class="flex justify-end space-x-4"><!--
            <button type="button" @click="$dispatch('close-edit-modal')"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                Cancel
            </button>-->
            <button type="submit" wire:loading.attr="disabled"
                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                <span wire:loading.remove>Update</span>
                <span wire:loading>
                    <svg class="w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        </div>
    </form>
</div>
