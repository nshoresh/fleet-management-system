
<div>
    <x-slot name='header'>
        <div class="px-4 py-2 bg-yellow-100">
            <h2 class="text-xl font-semibold">
                {{ __('Vehicle Makes') }}
            </h2>
        </div>
    </x-slot>
    <div class="bg-white shadow rounded-2xl">


    <div>

        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="fixed z-50 max-w-sm px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded shadow-lg top-4 right-4"
                role="alert">
                <div class="flex items-center justify-between">
                    <span class="block">{{ session('message') }}</span>
                    <button @click="show = false" class="ml-4 text-green-700 hover:text-green-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
        <!-- Header with search and filters -->
        <div class="p-4 border-b border-gray-200 sm:p-6 ">
            <div class="flex flex-col justify-between gap-4 md:flex-row">
                <h2 class="text-lg font-medium text-gray-900 ">
                    Users Management
                </h2>
                <div>
                    <x-gold-button wire:click="createUser"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <x-icons.plus-circle />
                        Add User
                    </x-gold-button>
                </div>
            </div>

            <div class="flex flex-col justify-between gap-4 mt-4 md:flex-row">
                <!-- Search -->
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search users..."
                        class="block w-full py-2 pl-10 pr-4 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>

                <!-- Filters -->
                <div class="flex flex-col gap-2 sm:flex-row">
                    <select wire:model.live="filters.role"
                        class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">All Roles</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="filters.status"
                        class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">All Status</option>
                        @foreach ($acount_status as $status)
                            <option value="{{ $status->status }}">{{ $status->status }}</option>
                        @endforeach

                    </select>

                    <select wire:model.live="perPage"
                        class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>

                    <button wire:click="resetFilters"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5 mr-2 -ml-1 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 ">
                <thead class="bg-yellow-50">
                    <tr>
                        <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">#
                        </th>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase dark:text-gray-300">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('name')">
                                Name
                                @if ($sortField === 'name')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if ($sortDirection === 'asc')
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        @else
                                            <path fill-rule="evenodd"
                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                                clip-rule="evenodd" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase ">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('email')">
                                Email
                                @if ($sortField === 'email')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if ($sortDirection === 'asc')
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        @else
                                            <path fill-rule="evenodd"
                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                                clip-rule="evenodd" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase ">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('role')">
                                Role
                                @if ($sortField === 'role')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if ($sortDirection === 'asc')
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        @else
                                            <path fill-rule="evenodd"
                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                                clip-rule="evenodd" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase ">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('is_active')">
                                Status
                                @if ($sortField === 'is_active')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if ($sortDirection === 'asc')
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        @else
                                            <path fill-rule="evenodd"
                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                                clip-rule="evenodd" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase ">
                            <div class="flex items-center cursor-pointer" wire:click="sortBy('created_at')">
                                Created At
                                @if ($sortField === 'created_at')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if ($sortDirection === 'asc')
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        @else
                                            <path fill-rule="evenodd"
                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                                clip-rule="evenodd" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-right text-yellow-700 uppercase ">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 ">
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id }}">
                            <td class="px-4 py-2 ">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10">
                                        <div
                                            class="flex items-center justify-center w-10 h-10 bg-gray-200 rounded-full ">
                                            <span
                                                class="text-lg font-medium text-gray-600 ">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 ">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 ">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $user->role->name === 'admin'
                                        ? 'bg-red-100 text-red-800  '
                                        : ($user->role->name === 'manager'
                                            ? 'bg-blue-100 text-blue-800 '
                                            : 'bg-green-100 text-green-800 ') }}">
                                    {{ ucfirst($user->role->name) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click="toggleUserStatus({{ $user->id }})"
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $user->is_active ? 'bg-green-100 text-green-800 ' : 'bg-gray-100 text-gray-800 ' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap ">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <div class="flex justify-end space-x-2">
                                    <button wire:click="editUser({{ $user->id }})"
                                        class="text-indigo-600 hover:text-indigo-900 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </button>
                                    <button wire:click="deleteConfirm({{ $user->id }})"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap ">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-6 bg-white border-t border-gray-200 sm:px-6">
            {{-- {{ $users->links() }} --}}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->


    <!-- User Create/Edit Modal -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-cloak class="fixed inset-0 z-10 overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div
            class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 mx-auto text-center sm:block sm:p-0 max-w-7xl md:max-w-7xl">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75"
                aria-hidden="true"></div>

            <span class="hidden text-2xl sm:inline-block sm:align-middle sm:h-screen"
                aria-hidden="true">&#8203;</span>
            <div x-show="show" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full md:max-w-4xl lg:max-w-5xl">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start ">
                        <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <div class="flex justify-between">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 " id="modal-title">
                                    {{ $userId ? 'Edit User' : 'Create User' }}
                                </h3>
                                <button wire:click="cancelCreateUser">
                                    <x-icons.x-plain />
                                </button>
                            </div>
                            <hr />
                            <div>
                                <livewire:client.users.client-user-registration-modal :id="$vehicleOwner->id" wire:lazy />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--  Edit  user Modal --}}
    <div x-data="{ show: @entangle('showEditModal') }" x-show="show" x-cloak class="fixed inset-0 z-10 overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div
            class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 mx-auto text-center sm:block sm:p-0 max-w-7xl md:max-w-7xl">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75"
                aria-hidden="true"></div>

            <span class="hidden text-2xl sm:inline-block sm:align-middle sm:h-screen"
                aria-hidden="true">&#8203;</span>
            <div x-show="show" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full md:max-w-4xl lg:max-w-5xl">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <div class="flex justify-between">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 " id="modal-title">
                                    Edit User
                                </h3>
                                <button wire:click="cancelEditUser" class="text-2xl ">
                                    <x-icons.x-plain class="text-2xl text-gray-500 " />
                                </button>
                            </div>
                            <hr />
                            @if ($userId)
                                <livewire:client.users.update-user-modal :id="$userId" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
