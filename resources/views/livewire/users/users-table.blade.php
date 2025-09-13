<div>
    <div class="mb-4 flex flex-wrap items-center gap-4">
        <!-- search Input-->
        <div class="flex-1 min-w-[250px]">
            <div class="relative w-full md:w-96">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5"
                    placeholder="Search by name or email...">
            </div>
        </div>
        <div>
            <label for="role_filter" class="text-sm font-medium text-gray-700"></label>
            <select wire:model.live.debounce.300ms="role_filter" id="role_filter"
                class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                <option value="">All Roles</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status_filter" class="text-sm font-medium text-gray-700"></label>
            <select wire:model.live.debounce.300ms="status_filter" id="status_filter"
                class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                <option value="">All Statuses</option>
                @foreach ($account_statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->status }}</option>
                @endforeach
            </select>
        </div>
        <!-- Livewire Loading Spinner Component -->

        <div wire:loading class="flex-col items-center justify-center overflow-hidden opacity-75 ">
            <x-loading-indicator />
        </div>
        <!-- Create New User Button -->
        <x-gold-button x-on:click="$dispatch('open-modal', 'user-registration-modal')">
            <x-icons.plus-circle /> New User
        </x-gold-button>
    </div>
    <!-- Flash Message -->
        @if(session()->has('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-500"
                x-data="{ show: true, timeLeft: 5 }"
                x-init="
                    setTimeout(() => { show = false }, 5000);
                    setInterval(() => { if (timeLeft > 0) timeLeft-- }, 1000);
                "
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:leave="transition ease-in duration-200"
                >
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                    <button 
                    @click="show = false"
                    type="button" class="text-green-500 hover:text-green-700 focus:outline-none">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show"
                class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded shadow-lg z-50 max-w-sm"
                role="alert">
                <div class="flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button @click="show = false" class="ml-4 text-red-700 hover:text-green-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    <!-- Table -->
    <div class="p-4 overflow-y-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-yellow-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        #
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">
                        Name
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">
                        Email
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">
                        Role
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">
                        User Type
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">
                        Account Status
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">
                        Created At
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 overflow-auto">
                @foreach ($filteredUsers as $user)
                    <tr class="py-7 px-7">
                        <td class="px-6 py-2 ">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $user->role->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $user->user_type->type_name ?? 'N/A' }}
                        </td>
                        {{--  --}}
                        <td
                            class="flex justify-between gap-2 px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            <span class="flex items-left">
                                <!-- Status badge with appropriate color -->
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mr-2
                                    @if ($user->account_status->status == 'Active') bg-green-100 text-green-800
                                    @elseif($user->account_status->status == 'Inactive') bg-red-100 text-red-800
                                    @elseif($user->account_status->status == 'Pending') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $user->account_status->status }}
                                </span>
                                <x-gold-button-sm
                                    wire:click="$set('selectedUserId', {{ $user->id }})"
                                    type="button" x-data="{}"
                                    x-on:click="$dispatch('open-modal', 'update-status-modal')">
                                    <x-icons.pencil-square />
                                </x-gold-button-sm>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <div class="relative text-left" x-data="{ open: false }">
                                <x-gold-button-sm x-on:click="open = !open">
                                    <x-icons.three-dots />
                                </x-gold-button-sm>
                                <div x-show="open" x-cloak @click.away="open = false"
                                    class="absolute right-0 z-50 w-40 bg-white border border-gray-300 divide-y divide-gray-200 rounded-md shadow-lg">
                                    <a href="{{ route('users.view', $user->id) }}" wire:navigate
                                        class="block px-4 py-2 text-gray-800 hover:bg-gray-100">View</a>
                                    <a href="{{ route('users.edit', $user->id) }}" wire:navigate
                                        class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Edit</a>
                                    <button wire:click="confirmDelete({{ $user->id }})"
                                        class="block w-full px-4 py-2 text-left text-red-600 hover:bg-red-100">
                                        Delete
                                    </button>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination Links -->
    </div>
    <div class="px-6 py-3">
        {{ $filteredUsers->links('vendor.pagination.tailwind') }} <!-- Pagination links rendered by Livewire -->
    </div>
    <!-- Account Status Update Modal -->
    <x-modal maxWidth="md" name="update-status-modal" :show="false" focusable>
        <form wire:submit.prevent="updateUserStatus" class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Update Account Status
            </h2>

            <div class="mt-6">
                <x-input-label for="account_status_id" value="Select New Status" />
                <select id="accountStatusId" wire:model.live.debounce.300ms="accountStatusId"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-sm shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Select Status</option>
                    @foreach ($account_statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->id }}: {{ $status->status }} </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('accountStatusId')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="status_note" value="Status Change Note (Optional)" />
                <x-gold-text-input id="status_note" wire:model="statusNote" class="block w-full mt-1 rounded-sm"
                    type="text" placeholder="Add a note about this status change" />
                <x-input-error :messages="$errors->get('statusNote')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-6">
                <x-gold-button-sm x-on:click="$dispatch('close')" class="mr-3">
                    Cancel
                </x-gold-button-sm>

                <x-gold-button type="submit" wire:loading.attr="disabled"
                    class="px-4 py-2 text-lg font-semibold text-white bg-indigo-600 rounded-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span wire:loading.remove wire:target="updateUserStatus">Update Status</span>
                    <span wire:loading wire:target="updateUserStatus">Updating...</span>
                </x-gold-button>
            </div>
        </form>
    </x-modal>

    <x-modal maxWidth="2xl" name="user-registration-modal" :show="false" focusable>
        {{-- @livewire('users.registration-form') --}}
        <livewire:users.registration-form />
    </x-modal>
    {{-- Delete Confirmation Modal --}}
        @if($confirmDeletion)
            <div wire:ignore.self class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="p-6 bg-white rounded-lg shadow-lg w-96">
                    <h2 class="text-lg font-semibold">Confirm Deletion</h2>
                    <p class="mt-2 text-gray-600">Are you sure you want to delete this user? This action cannot be undone.</p>
                    <div class="flex justify-end mt-4 space-x-2">
                        <button wire:click="cancelDelete"
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                Cancel
                        </button>
                        <button wire:click="delete"
                            class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
                                Delete
                        </button>
                    </div>
                </div>
            </div>
        @endif

    <style>
        /* Custom Scrollbar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 8px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 8px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</div>
