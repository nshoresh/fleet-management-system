{{-- resources/views/livewire/system/roles/create-role.blade.php --}}

<div>
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
    <div class="max-w-2xl py-6 mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">
                        {{ $isEdit ? 'Edit Role' : 'Create New Role' }}
                    </h1>
                </div>

                <form wire:submit.prevent="save">
                    <!-- Role Name -->
                    <div class="mb-4">
                        <label for="role.name" class="block text-sm font-medium text-gray-700">
                            Role Name <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="text" id="role.name" wire:model.blur="role.name"
                                wire:change="updatedRoleName"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('role.name') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                placeholder="Enter role name" required />
                            @error('role.name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Role Slug -->
                    <div class="mb-4">
                        <label for="role.slug" class="block text-sm font-medium text-gray-700">
                            Slug
                        </label>
                        <div class="mt-1">
                            <input type="text" id="role.slug" wire:model="role.slug"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('role.slug') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                placeholder="Enter role slug or leave empty for auto-generation" />
                            @error('role.slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            Will be automatically generated from the name if left blank.
                        </p>
                    </div>

                    <!-- Role Description -->
                    <div class="mb-4">
                        <label for="role.description" class="block text-sm font-medium text-gray-700">
                            Description
                        </label>
                        <div class="mt-1">
                            <textarea id="role.description" wire:model="role.description" rows="4"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('role.description') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                placeholder="Enter role description (optional)"></textarea>
                            @error('role.description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Is Active -->
                    <div class="mb-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="role.is_active" type="checkbox" wire:model="role.is_active"
                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="role.is_active" class="font-medium text-gray-700">Active Status</label>
                                <p class="text-gray-500">Enable this to make the role active in the system</p>
                                @error('role.is_active')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('system.roles') }}" wire:navigate
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <x-gold-button-link type="submit"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ $isEdit ? 'Update Role' : 'Create Role' }}
                        </x-gold-button-link>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Flash Message -->

</div>
