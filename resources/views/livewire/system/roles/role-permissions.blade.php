<div>
    <div class="py-6">
        <div class="px-4 mx-auto max-w-12xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Role Permissions: {{ $role->name }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ $role->description }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('system.roles') }}"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition bg-gray-600 border border-transparent rounded-md hover:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-700">
                        Back to Roles
                    </a>
                </div>
            </div>

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

            <div class="mt-6 overflow-hidden bg-white shadow sm:rounded-md">
                <form wire:submit.prevent="updateRolePermissions">
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <input id="select-all" type="checkbox" wire:model.live="selectAll"
                                    class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="select-all" class="ml-2 text-sm font-medium text-gray-700">
                                    Select All Permissions
                                </label>
                            </div>
                            <x-gold-button type="submit"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-700">
                                Save Permissions
                            </x-gold-button>
                        </div>

                        <!-- Permissions Grid -->
                        <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                            @foreach ($all_permissions as $permission)
                                <div class="flex items-start p-2 border border-yellow-300 rounded-sm">
                                    <div class="flex items-center h-5">
                                        <input id="permission-{{ $permission->id }}" type="checkbox"
                                            value="{{ $permission->id }}" wire:model.live="selectedPermissions"
                                            class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-indigo-500"
                                            @if (in_array($permission->id, $role_permission_ids)) checked @endif>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="permission-{{ $permission->id }}" class="font-medium text-gray-700">
                                            {{ $permission->name }}
                                        </label>
                                        @if ($permission->description)
                                            <p class="text-gray-500">{{ $permission->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end p-4 bg-gray-50">
                        <x-gold-button type="submit"
                            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-700">
                            Save Permissions
                        </x-gold-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
