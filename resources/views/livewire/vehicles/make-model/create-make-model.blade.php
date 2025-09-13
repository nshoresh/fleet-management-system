<div class="container mx-auto">
    <x-slot name="header">
        Create Vehicle Model
    </x-slot>

    <div class="px-6 py-4 mx-auto mt-6 overflow-hidden bg-white shadow-md max-w-12xl rounded-2xl">
        {{-- Success Message --}}
        @if (session('success'))
            <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded"
                role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if (session('error'))
            <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="save">
            <div class="mb-4">
                <label for="vehicle_make_id" class="block mb-2 text-sm font-bold text-gray-700">
                    Vehicle Make <span class="text-red-500">*</span>
                </label>
                <select wire:model.defer="vehicle_make_id" id="vehicle_make_id"
                    class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                    <option value="">Select Vehicle Make</option>
                    @foreach ($vehicleMakes as $make)
                        <option value="{{ $make->id }}">{{ $make->name }}</option>
                    @endforeach
                </select>

                @error('vehicle_make_id')
                    <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-bold text-gray-700">
                    Model Name <span class="text-red-500">*</span>
                </label>
                <x-gold-text-input type="text" wire:model.defer="name" id="name"
                    placeholder="Enter Model Name (e.g., Corolla, Mustang)"/>
                @error('name')
                    <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-4">
                <label for="year" class="block mb-2 text-sm font-bold text-gray-700">
                    Year of Manufacture
                </label>
                <x-gold-text-input type="number" wire:model="year" id="year" min="1886"
                    max="{{ date('Y') + 1 }}" placeholder="Enter Year (Optional)" />
                @error('year')
                    <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="body_type" class="block mb-2 text-sm font-bold text-gray-700">
                    Body Type
                </label>
                <select wire:model="body_type" id="body_type"
                    class='block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm'>
                    <option value="">Select Body Type (Optional)</option>
                    @foreach ($bodyTypeOptions as $key => $type)
                        <option value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>
                @error('body_type')
                    <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block mb-2 text-sm font-bold text-gray-700">
                    Description
                </label>
                <textarea wire:model="description" id="description" placeholder="Enter Model Description (Optional)" rows="4"
                    class='block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm'></textarea>
                @error('description')
                    <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <x-gold-button type="submit"
                    class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                    Create Vehicle Model
                </x-gold-button>
                <button type="button" wire:click="resetForm"
                    class="px-4 py-2 font-bold text-white bg-gray-500 rounded hover:bg-gray-700 focus:outline-none focus:shadow-outline">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>
