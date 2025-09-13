<!-- resources/views/livewire/flexible-table.blade.php -->
<div>
    <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
        <!-- Table Header -->
        <div class="flex items-center justify-between px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                {{ $tableTitle }}
                <span class="ml-2 text-sm text-gray-500">({{ $totalItems }} items)</span>
            </h3>
            <div class="flex items-center space-x-4">
                <!-- Search Box -->
                <div class="relative">
                    <input wire:model.debounce.300ms="searchQuery" type="text"
                        class="block w-full p-2 pl-10 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Search...">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <!-- Filter Button -->
                <button type="button" wire:click="toggleFilter"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                            clip-rule="evenodd" />
                    </svg>
                    Filters
                </button>

                <!-- Per Page Selector -->
                <select wire:model="perPage"
                    class="block w-full border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="5">5 per page</option>
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                    <option value="100">100 per page</option>
                </select>
            </div>
        </div>

        <!-- Filters Section (Conditional) -->
        @if ($showFilters)
            <div class="px-4 py-5 border-b border-gray-200 bg-gray-50 sm:px-6">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($columns as $column)
                        @if (isset($column['filterable']) && $column['filterable'])
                            <div>
                                <label for="filter-{{ $column['field'] }}"
                                    class="block text-sm font-medium text-gray-700">
                                    {{ $column['label'] }}
                                </label>
                                <select id="filter-{{ $column['field'] }}" wire:model="filters.{{ $column['field'] }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">All {{ $column['label'] }}</option>
                                    @foreach (collect($data)->pluck($column['field'])->unique() as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" wire:click="resetFilters"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Reset Filters
                    </button>
                </div>
            </div>
        @endif

        <!-- Loading Overlay -->
        <div wire:loading class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="p-4 bg-white rounded-lg shadow-lg">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-indigo-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>Loading...</span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <!-- Select All Checkbox -->
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            <input type="checkbox" wire:click="toggleSelectAll"
                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        </th>

                        <!-- Column Headers -->
                        @foreach ($columns as $column)
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                @if (isset($column['sortable']) && $column['sortable'])
                                    <button wire:click="sortBy('{{ $column['field'] }}')"
                                        class="inline-flex items-center group">
                                        {{ $column['label'] }}

                                        @if ($sortField === $column['field'])
                                            @if ($sortDirection === 'asc')
                                                <svg class="w-4 h-4 ml-1 text-gray-400"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 ml-1 text-gray-400"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 ml-1 text-gray-200 group-hover:text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V10a1 1 0 01-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd" />
                                                <path fill-rule="evenodd"
                                                    d="M5.293 12.293a1 1 0 011.414 0L9 14.586V10a1 1 0 012 0v4.586l2.293-2.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </button>
                                @else
                                    {{ $column['label'] }}
                                @endif
                            </th>
                        @endforeach

                        <!-- Actions Column -->
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($items as $index => $item)
                        <tr class="{{ $index % 2 ? 'bg-gray-50' : 'bg-white' }}">
                            <!-- Row Selection Checkbox -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" wire:model="selectedItems" value="{{ $item['id'] ?? $index }}"
                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </td>

                            <!-- Data Cells -->
                            @foreach ($columns as $column)
                                <td
                                    class="px-6 py-4 whitespace-nowrap {{ isset($column['align']) ? 'text-' . $column['align'] : 'text-left' }}">
                                    @if (isset($column['type']) && $column['type'] === 'boolean')
                                        @if ($item[$column['field']])
                                            <span
                                                class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                                Yes
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                                No
                                            </span>
                                        @endif
                                    @elseif(isset($column['type']) && $column['type'] === 'date')
                                        {{ $item[$column['field']] ? date('M d, Y', strtotime($item[$column['field']])) : '' }}
                                    @elseif(isset($column['type']) && $column['type'] === 'datetime')
                                        {{ $item[$column['field']] ? date('M d, Y H:i', strtotime($item[$column['field']])) : '' }}
                                    @elseif(isset($column['type']) && $column['type'] === 'number')
                                        {{ number_format($item[$column['field']], isset($column['decimals']) ? $column['decimals'] : 0) }}
                                    @elseif(isset($column['type']) && $column['type'] === 'currency')
                                        {{ isset($column['currency']) ? $column['currency'] : '$' }}{{ number_format($item[$column['field']], 2) }}
                                    @elseif(isset($column['type']) && $column['type'] === 'percentage')
                                        {{ number_format($item[$column['field']], 2) }}%
                                    @elseif(isset($column['type']) && $column['type'] === 'badge')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ isset($column['colors'][$item[$column['field']]]) ? $column['colors'][$item[$column['field']]] : 'gray' }}-100 text-{{ isset($column['colors'][$item[$column['field']]]) ? $column['colors'][$item[$column['field']]] : 'gray' }}-800">
                                            {{ $item[$column['field']] }}
                                        </span>
                                    @elseif(isset($column['type']) && $column['type'] === 'image')
                                        @if ($item[$column['field']])
                                            <img src="{{ $item[$column['field']] }}" alt="Image"
                                                class="w-10 h-10 rounded-full">
                                        @endif
                                    @else
                                        {{ $item[$column['field']] ?? '' }}
                                    @endif
                                </td>
                            @endforeach

                            <!-- Actions -->
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                @if (isset($item['id']))
                                    <a href="#" wire:click.prevent="$emit('editItem', {{ $item['id'] }})"
                                        class="mr-3 text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <a href="#" wire:click.prevent="$emit('deleteItem', {{ $item['id'] }})"
                                        class="text-red-600 hover:text-red-900">Delete</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + 2 }}"
                                class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                No items found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
            {{ $this->getPaginationLinks() }}
        </div>
    </div>
</div>
