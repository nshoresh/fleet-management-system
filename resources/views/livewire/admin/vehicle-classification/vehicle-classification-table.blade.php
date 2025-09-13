<div>
    {{-- Header --}}
    <x-slot name='header'>
    <div class="px-4 py-2 bg-yellow-100">
        <h2 class="text-xl font-semibold">
            {{ __('Vehicle Classifications') }}
        </h2>
    </div>
    </x-slot>
    <div x-data="{ showFilters: false, showDeleteModal: false, modelToDelete: null }">
        <div x-data="{ showFilters: false }" class="w-full md:w-auto">
            <div class="mb-4 flex flex-wrap items-center gap-4">
                <!-- Search Input -->
                <div class="flex-1 min-w-[250px]">
                    <label for="search" class="block text-sm font-medium text-gray-700"></label>
                    <input wire:model.live.debounce.300ms="search" type="text" id="search"
                        class="block mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Search classification...">
                </div>
                <div wire:loading class="flex items-center justify-center">
                    <x-loading-indicator />
                </div>
                <!-- Filters (hidden by default, visible on button click) -->
                <div>
                    <label for="perPage" class="block text-sm font-medium text-gray-700"></label>
                    <select wire:model.live="perPage" id="perPage"
                        class="block mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="10">10 Per Page</option>
                        <option value="25">25 Per Page</option>
                        <option value="50">50 Per Page</option>
                        <option value="100">100 Per Page</option>
                    </select>
                </div>
                <!-- Show Filters Button -->
                <div>
                    <button @click="showFilters = !showFilters"
                        class="flex px-4 py-2 text-sm text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">
                        <x-icons.filter-icon />
                        <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
                    </button>
                </div>
                {{-- Add New Button --}}
                <div>
                    <x-gold-button wire:click="openAddModal">
                        <x-heroicon-s-plus-circle class="w-5 h-5"/> New Vehicle Classification
                    </x-gold-button>
                </div>
            </div>
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

        {{-- Table --}}
        <div div class="p-4 overflow-x-auto bg-white rounded-lg shadow">
            @if ($vehicleClassifications && $vehicleClassifications->count() > 0)
            <div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-yellow-50">
                        <tr>
                            <th scope="col"
                            class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                            #
                            </th>

                            <th scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                Vehicle Classification
                            </th>
                            <th scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer"">
                                Weight Range (kg)
                            </th>
                            <th scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                Max Weight (kg)
                            </th>
                            <th scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                Min Weight (kg)
                            </th>
                            <th scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                RDC Fee (PGK)
                            </th>
                            <th scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                Description
                            </th>
                            <th scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                         @forelse ($vehicleClassifications as $vehicleClassification)
                         <tr class="border-b border-gray-200">
                            <td class="px-4 py-2 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500">{{ $vehicleClassification->classification_name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500">{{ $vehicleClassification->formatted_weight_range }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500">{{ $vehicleClassification->max_weight }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500">{{ $vehicleClassification->min_weight }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500">{{ $vehicleClassification->rdc_fee }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500">{{ Str::limit($vehicleClassification->description, 50) }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500">
                                <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                    {{ $vehicleClassification->is_active ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }}">
                                    {{ $vehicleClassification->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-sm font-medium text-right whitespace-nowrap">
                                <x-action-dropdown>
                                    <x-slot name="trigger">
                                        <x-gold-button-sm class="text-indigo-600 hover:text-indigo-900">
                                            <x-icons.three-dots />
                                        </x-gold-button-sm>
                                    </x-slot>
                                    <button wire:click="openEditModal({{ $vehicleClassification->id }})" class="block w-full px-4 py-2 text-left text-gray-800 hover:bg-gray-100">
                                        Edit
                                    </button>
                                    <button wire:click="confirmDelete({{ $vehicleClassification->id }})" class="block w-full px-4 py-2 text-left text-red-600 hover:bg-red-100">
                                        Delete
                                    </button>
                                </x-action-dropdown>
                            </td>
                         </tr>
                         @empty
                         <tr>
                            <td colspan="6" class="px-4 py-2 text-sm text-center text-gray-500">
                                No vehicle classifications found
                            </td>
                         </tr>
                         @endforelse
                    </tbody>
                </table>
            </div>
            @else
                <h1 class="text-2xl">No vehicle classifications available</h1>
            @endif
        </div>

        {{-- Create Modal --}}
        @if($showModal)
            <div wire:ignore.self class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto bg-black bg-opacity-50">
                <div class="relative w-full max-w-2xl mx-4 my-8 md:mx-auto">
                    <div class="bg-white rounded-lg shadow-xl">
                        <div class="p-6">
                            <livewire:admin.vehicle-classification.create-vehicle-classification />
                        </div>
                        <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button wire:click="closeAddModal" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Edit Modal --}}
        @if($showEditModal)
            <div wire:ignore.self class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto bg-black bg-opacity-50">
                <div class="relative w-full max-w-2xl mx-4 my-8 md:mx-auto">
                    <div class="bg-white rounded-lg shadow-xl">
                        <div class="p-6">
                            @if($editingClassificationId)
                                <livewire:admin.vehicle-classification.edit-vehicle-classification
                                    :vehicleClassificationId="$editingClassificationId"
                                    :key="'edit-vehicle-classification-' . $editingClassificationId"/>
                            @endif
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button wire:click="closeEditModal" type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Delete Confirmation Modal --}}
        @if($confirmingDeletion)
            <div wire:ignore.self class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="p-6 bg-white rounded-lg shadow-lg w-96">
                    <h2 class="text-lg font-semibold">Confirm Deletion</h2>
                    <p class="mt-2 text-gray-600">Are you sure you want to delete this vehicle classification? This action cannot be undone.</p>
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
    </div>
</div>
