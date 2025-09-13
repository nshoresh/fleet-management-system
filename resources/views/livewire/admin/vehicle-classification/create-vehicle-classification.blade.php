<div>
    <h2 class="mb-4 text-xl font-semibold"> New Vehicle Classification </h2>
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
    <form wire:submit.prevent="createVehicleClassification" class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium">Classification Name</label>
                <input type="text" wire:model.defer="classification_name"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('classification_name')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium">Minimum Weight (kg)</label>
                <input type="number" step="any" wire:model.defer="min_weight"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('min_weight')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium">Maximum Weight (kg)</label>
                <input type="number" step="any" wire:model.defer="max_weight"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('max_weight')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium">RDC Fee (K)</label>
                <input type="number" step="any" wire:model.defer="rdc_fee"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                @error('rdc_fee')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium">Description</label>
                <textarea wire:model.defer="description"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                </textarea>
                @error('description')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="flex items-center">
            <div class="ml-2">
                <input wire:model.defer="is_active" type="checkbox" />
                <span class="ml-2 text-sm">Active</span>
            </div>
        </div>
        <x-gold-button type="submit">Register Vehicle Classification</x-gold-button>
    </form>
</div>
