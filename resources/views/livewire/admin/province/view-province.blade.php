<div class="container p-4 mx-auto">
    <h2 class="text-xl font-semibold">Province: {{ $province->name }}</h2>
    <button wire:click="openModal" class="flex px-4 py-2 mt-4 text-white bg-indigo-500 rounded"><svg
            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle"
            viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
        </svg> <span>Add District</span>
    </button>

    <div class="mt-4">
        <h3 class="text-lg font-medium">Districts</h3>
        <ul class="ml-6 list-disc">
            @foreach ($districts as $district)
                <li>{{ $district->name }}</li>
            @endforeach
        </ul>
    </div>


    @if ($isModalOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="w-1/3 p-6 bg-white rounded shadow-lg">
                <h3 class="mb-4 text-lg font-semibold">Add New District</h3>
                <input type="text" wire:model="name" placeholder="District Name" class="w-full p-2 border rounded">
                @error('name')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror

                <div class="flex justify-end mt-4 space-x-2">
                    <button wire:click="closeModal" class="px-4 py-2 text-white bg-gray-500 rounded">Cancel</button>
                    <button wire:click="createDistrict" class="px-4 py-2 text-white bg-blue-500 rounded">Save</button>
                </div>
            </div>
        </div>
    @endif
</div>
