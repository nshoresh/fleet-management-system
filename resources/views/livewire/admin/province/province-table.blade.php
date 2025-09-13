<div>
    <!-- Header, search and filters -->
    <x-slot name='header'>
        <div class="px-4 py-2 bg-yellow-100">
            <h2 class="text-xl font-semibold">
                Manage Provices
            </h2>
        </div>
    </x-slot>
    <div class="flex flex-col items-start justify-between gap-4 mb-4 sm:flex-row sm:items-center">
        <div class="flex-1 min-w-[250px]">
            <label for="search" class="block text-sm font-medium text-gray-700"></label>
            <input wire:model.live.debounce.300ms="search" type="text" id="search"
                class="block mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Search provinces...">
        </div>
        <div wire:loading class="flex-col items-center justify-center overflow-hidden opacity-75 ">
            <x-loading-indicator />
        </div>
        <div class="w-full sm:w-auto">
            <select wire:model.live="regionFilter"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All Regions</option>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex">
            <x-gold-button wire:click="openModal"
                class="px-4 py-2 font-medium text-white transition-colors duration-200 bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-4 h-4 mr-1" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Add Province
            </x-gold-button>
        </div>
    </div>

     <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="p-4 mb-2 bg-green-50 border-l-4 border-green-500"
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
    <div class="p-4 overflow-y-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-yellow-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        #</th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer"
                        wire:click="sortBy('name')">
                        Name
                        @if ($sortField === 'name')
                            <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                        @endif
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer"
                        wire:click="sortBy('code')">
                        Code
                        @if ($sortField === 'code')
                            <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                        @endif
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer"
                        wire:click="sortBy('region')">
                        Region
                        @if ($sortField === 'region')
                            <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                        @endif
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">
                        Created At
                    </th>
                    <th scope="col" 
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase">
                        <!--<span class="sr-only">-->Actions<!--</span>-->
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($provinces as $province)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $province->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                {{ $province->code ?? '—' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                {{ $province->region->name ?? '—' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $province->created_at ? $province->created_at->format('M d, Y') : '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <div class="relative text-left" x-data="{ open: false }">
                                <x-gold-button-sm x-on:click="open = !open">
                                    <svg class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </x-gold-button-sm>
                                <div x-show="open" x-cloak @click.away="open = false"
                                    class="absolute right-0 z-30 w-40 bg-white border border-gray-300 divide-y divide-gray-200 rounded-md shadow-lg">
                                    <a href="{{ route('system.provinces.view', $province->id) }}" wire:navigate
                                        wire:click="edit({{ $province->id }})"
                                        class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                        Details
                                    </a>
                                    <button wire:click="edit({{ $province->id }})"
                                        class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                        Edit
                                    </button>
                                    <button wire:click="confirmProvinceDeletion({{ $province->id }})"
                                        class="block px-4 py-2 text-red-600 hover:bg-gray-100">
                                        Delete
                                    </button>


                                </div>
                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                            No provinces found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $provinces->links('vendor.pagination.tailwind') }}
    </div>

    <!-- Create/Edit Modal -->
    @if ($isModalOpen)
        <div class="fixed inset-0 z-40 flex items-center justify-center p-4 bg-black bg-opacity-50">
            <div class="w-full max-w-md max-h-full overflow-hidden bg-white rounded-lg shadow-xl">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                        {{ $provinceId ? 'Edit Province' : 'Create Province' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="px-6 py-4">
                    <form wire:submit.prevent="save">
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" id="name" wire:model="name"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                            @error('name')
                                <span class="text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="code" class="block text-sm font-medium text-gray-700">Code
                                (Optional)</label>
                            <input type="text" id="code" wire:model="code"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                            @error('code')
                                <span class="text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="region_id"
                                class="block text-sm font-medium text-gray-700">Region</label>
                            <select id="region_id" wire:model="region_id"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Select Region</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                            @error('region_id')
                                <span class="text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="px-6 py-4 space-x-2 text-right bg-gray-50">
                    <button type="button" wire:click="closeModal"
                        class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <x-gold-button wire:click="save" type="submit"
                        class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ $provinceId ? 'Update' : 'Create' }}
                    </x-gold-button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if ($confirmingProvinceDeletion)
        <div class="fixed inset-0 z-40 flex items-center justify-center p-4 bg-black bg-opacity-50">
            <div class="w-full max-w-md bg-white rounded-lg shadow-xl">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Delete Province</h3>
                    <button wire:click="$set('confirmingProvinceDeletion', false)" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-2 bg-red-100 rounded-full">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-700">
                                Are you sure you want to delete this provinve? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="deleteProvince"
                        class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button type="button" wire:click="$set('confirmingProvinceDeletion', false)"
                        class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif
    <!-- JavaScript for Event Listeners -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('province-saved', (event) => {
                // You could use a toast notification library here
                alert(event.message);
            });

            Livewire.on('province-deleted', (event) => {
                // You could use a toast notification library here
                alert(event.message);
            });
        });
    </script>
</div>
