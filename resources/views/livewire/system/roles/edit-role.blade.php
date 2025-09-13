<div class="p-6 mx-auto bg-white rounded-lg shadow-md max-w-12xl">
    <h2 class="mb-4 text-2xl font-semibold">Edit Role</h2>

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-4 right-4 px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded shadow-lg z-50 max-w-sm"
            role="alert">
            <div class="flex items-center justify-between">
                <span class="block">{{ session('message') }}</span>
                <button @click="show = false" class="ml-4 text-green-700 hover:text-green-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="updateRole">
        <!-- Role Name -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Role Name</label>
            <input type="text" wire:model="name"
                class="w-full px-3 py-2 border rounded-lg focus:outline-yellow-500 focus:ring-2 focus:ring-yellow-500">
            @error('name')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Role Slug -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Slug</label>
            <input type="text" wire:model="slug" disabled
                class="w-full px-3 py-2 border rounded-lg focus:outline-yellow-500 focus:ring-2 focus:ring-yellow-500">
            @error('slug')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea wire:model="description"
                class="w-full px-3 py-2 border rounded-lg focus:outline-yellow-500 focus:ring-2 focus:ring-yellow-500"></textarea>
            @error('description')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Is Active -->
        <div class="flex items-center mb-4">
            <input type="checkbox" wire:model="is_active" class="mr-2"
                class='w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500'>
            <label class="text-sm font-medium text-gray-600 ">Active</label>
        </div>

        <!-- Permissions Multi-Select -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Permissions</label>
            <div class="flex flex-wrap gap-4 p-3 border rounded-lg">
                @foreach ($allPermissions as $permission)
                    <label class="flex items-center p-2 space-x-2 border border-yellow-300 rounded-sm">
                        <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission->id }}"
                            class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                        <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('selectedPermissions')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex justify-between">
            <x-gold-button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Update
                Role</x-gold-button>
            <a href="{{ route('system.roles') }}"
                class="px-4 py-2 text-white bg-gray-500 rounded-lg hover:bg-gray-600">Cancel</a>
        </div>
    </form>
</div>
