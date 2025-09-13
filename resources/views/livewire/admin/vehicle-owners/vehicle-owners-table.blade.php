<div>
    <x-slot name='header'>
        <div class="px-4 py-2 bg-yellow-100">
            <h2 class="text-xl font-semibold">
                {{ __('List of Vehicle Owners') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex flex-wrap items-center gap-4 mb-4">
        <div class="flex-1 min-w-[250px]">
            <label for="search" class="block text-sm font-medium text-gray-700"></label>
            <input wire:model.live.debounce.300ms="search" type="text" id="search"
                class="block mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Search Owners...">
        </div>
        <div wire:loading class="flex-col items-center justify-center overflow-hidden opacity-75 ">
            <x-loading-indicator />
        </div>
        <div>
            <select wire:model.live.debounce.300ms="perPage"
                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm ">
                <option value="5">5 per page</option>
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
            </select>
        </div>
        <div class="flex items-center gap-4">
            <select wire:model.live.debounce.300ms="ownerTypeFilter"
                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                <option value="">All Owner Types</option>
                @foreach ($ownerTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <x-gold-button wire:click="openAddModal"
            class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <div class="flex items-center">
                <x-icons.plus-circle />
                Add Vehicle Owner
            </div>
        </x-gold-button>
    </div>

        <!-- Flash Message -->
    @if (session()->has('message'))
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
                        <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
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
    <div class="p-4 overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-yellow-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        #</th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        <div class="flex cursor-pointer" wire:click="sortBy('name')">
                            Owners Name
                            @if ($sortField === 'name')
                                <span class="ml-1">
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                </span>
                            @endif
                        </div>
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        Business Name
                    </th>

                    {{-- <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Contact</th> --}}
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        Address
                    </th>

                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        <div class="flex cursor-pointer" wire:click="sortBy('vehicle_owner_type_id')">
                            Owner Type
                            @if ($sortField === 'vehicle_owner_type_id')
                                <span class="ml-1">
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                </span>
                            @endif
                        </div>
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        Vehicles</th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vehicleOwners as $index => $owner)
                    <tr class="px-6 text-left border">
                        <td class="px-6 py-6 ">{{ $loop->iteration }}</td>
                        <td class="px-6 py-6 ">{{ $owner->name }}</td>
                        <td class="px-6 py-6 ">{{ $owner->business_name }}</td>
                        {{-- <td class="px-4 py-2 ">{{ $owner->email }}</td>
                        <td class="px-4 py-2 ">{{ $owner->contact_number }}</td> --}}
                        <td class="px-6 py-6 ">{{ $owner->address }}</td>
                        <td class="px-6 py-6 ">
                            @switch($owner->vehicle_owner_type->name ?? 'N/A')
                                @case('Individual')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Individual
                                    </span>
                                @break

                                @case('Company')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Company
                                    </span>
                                @break

                                @case('Government')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Government
                                    </span>
                                @break

                                @default
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $owner->vehicle_owner_type->name }}
                                    </span>
                            @endswitch
                            {{-- <a href="{{ route('admin.vehicle-owners.view', $owner->uuid) }}" wire:navigate
                                class="flex justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Detials
                                <x-icons.eye-open /></a> --}}

                        </td>

                        <td class="px-4 py-2 font-semibold text-center">
                            {{ $owner->vehicles->count() }}
                        </td>
                        <td class="px-4 py-2 text-center">
                            <div class="relative inline-block text-left" x-data="{ open: false }">
                                <x-gold-button-sm type="button"
                                    class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 focus:outline-none"
                                    @click="open = !open">
                                    <x-icons.three-dots />
                                </x-gold-button-sm>
                                <div x-show="open" x-cloak @click.away="open = false"
                                    class="absolute right-0 z-10 w-40 mt-2 bg-gray-100 border border-gray-300 divide-y divide-gray-200 rounded-md shadow-lg">

                                    <a href="{{ route('admin.vehicle-owners.view', $owner->uuid) }}" wire:navigate
                                        class="flex justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Detials
                                        <x-icons.eye-open /></a>
                                    <a href="{{ route('admin.vehicle-owners.manage', $owner->uuid) }}" wire:navigate
                                        class="flex justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Manage
                                        <x-icons.gear /></a>

                                    {{-- <a href="{{ route('admin.vehicle-owners.view', $owner->uuid) }}" wire:navigate
                                    class="flex justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">More
                                    Details
                                    <x-icons.infor-circle /></a> --}}
                                    <a href="{{ route('admin.vehicle-owners.edit', $owner->uuid) }}" wire:navigate
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>

                                    {{-- <a href="{{ route('admin.vehicle-owners.manage', $owner->id) }}" wire:navigate
                                        class="flex justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Manage
                                        <x-icons.gear /></a> --}}

                                    {{-- <a href="{{ route('admin.vehicle-owners.view', $owner->uuid) }}" wire:navigate
                                        class="flex justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">More
                                        Details
                                        <x-icons.infor-circle /></a> --}}
                                    {{-- <a href="{{ route('admin.vehicle-owners.edit', $owner->id) }}" wire:navigate
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a> --}}

                                    <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
                                        wire:click="confirmDelete({{ $owner->id }})">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $vehicleOwners->links('vendor.pagination.tailwind') }}
    </div>

    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
                <!-- Modal panel -->
                <div
                    class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                <!-- Warning icon -->
                                <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                    Delete Confirmation
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete this record? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="deleteOwner" type="button"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                        <button wire:click="cancelDelete" type="button"
                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Add Vehicle Owner Modal -->
    @if ($showAddModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

                <!-- Modal panel -->
                <div
                    class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="px-4 pt-5 pb-4 bg-white sm:p-6">
                        <div class="flex items-start justify-between">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                Add New Vehicle Owner
                            </h3>
                            <button wire:click="closeAddModal" class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Close</span>
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="mt-4">
                            <form wire:submit.prevent="saveOwner">
                                <div class="space-y-4">
                                    <!-- Name Field -->
                                    <div>
                                        <label for="name"
                                            class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" id="name" wire:model="newOwner.name"
                                            class="block w-full mt-1 border-gray-300 rounded-sm shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                                        @error('newOwner.name')
                                            <span class="text-sm text-red-600">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Email Field -->
                                    <div>
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" id="email" wire:model="newOwner.email"
                                            class="block w-full mt-1 border-gray-300 rounded-sm shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                                        @error('newOwner.email')
                                            <span class="text-sm text-red-600">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Contact Number Field -->
                                    <div>
                                        <label for="contact_number"
                                            class="block text-sm font-medium text-gray-700">Contact Number</label>
                                        <input type="text" id="contact_number"
                                            wire:model="newOwner.contact_number"
                                            class="block w-full mt-1 border-gray-300 rounded-sm shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                                        @error('newOwner.contact_number')
                                            <span class="text-sm text-red-600">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Address Field -->
                                    <div>
                                        <label for="address"
                                            class="block text-sm font-medium text-gray-700">Address</label>
                                        <textarea id="address" wire:model="newOwner.address"
                                            class="block w-full mt-1 border-gray-300 rounded-sm shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
                                            rows="3"></textarea>
                                        @error('newOwner.address')
                                            <span class="text-sm text-red-600">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Owner Type Field -->
                                    <div>
                                        <label for="vehicle_owner_type_id"
                                            class="block text-sm font-medium text-gray-700">Owner Type</label>
                                        <x-select-input id="vehicle_owner_type_id" name="vehicle_owner_type_id"
                                            wire:model="newOwner.vehicle_owner_type_id"
                                            class="block w-full mt-1 border-gray-300 rounded-sm shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                                            <option value="">Select Owner Type</option>
                                            @foreach ($ownerTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </x-select-input>
                                        @error('newOwner.vehicle_owner_type_id')
                                            <span class="text-sm text-red-600">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                                    <x-gold-button type="submit"
                                        class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-yellow-600 border border-transparent rounded-md shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Save
                                    </x-gold-button>
                                    <button type="button" wire:click="closeAddModal"
                                        class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
