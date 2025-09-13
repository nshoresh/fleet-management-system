<div>
    <x-slot name='header'>
        <div class="px-4 py-2 bg-yellow-100">
            <h2 class="text-xl font-semibold">
                License Types Management
            </h2>
        </div>
    </x-slot>
     <!-- search Input-->
    <div class="mb-4 flex flex-wrap items-center gap-4">
        <div class="flex-1 min-w-[250px]">
            <div class="flex items-center">
                <div class="w-full max-w-lg lg:max-w-xs">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms='searchTerm' id="search"
                            class="block w-full py-2 pl-10 pr-3 leading-5 placeholder-gray-500 bg-white border border-gray-300 rounded-md focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Search license type..." type="search">
                    </div>
                </div>
            </div>
        </div>
        <div wire:loading class="flex-col items-center justify-center overflow-hidden opacity-75 ">
            <x-loading-indicator />
        </div>
        <div class="flex">
            <x-gold-button-link href="{{ route('admin.license-types.create') }}" wire:navigate
            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-700">
                <x-icons.plus-circle /> 
                New License Type
            </x-gold-button-link>
        </div>
    </div>
    <!-- Table -->
    <div class="p-4 overflow-y-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-yellow-50">
                <tr>
                    <th scope="col"
                        wire:click.prevent="sortBy('type_name')" 
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        Type Name
                        {{-- @include('partials.sort-icon', ['field' => 'type_name']) --}}
                    </th>
                    <th scope="col"
                        wire:click.prevent="sortBy('type_category')" 
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        Category
                        {{-- @include('partials.sort-icon', ['field' => 'type_category']) --}}
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        Description
                    </th>
                    <th scope="col"
                        wire:click.prevent="sortBy('is_active')" 
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        Status
                        {{-- @include('partials.sort-icon', ['field' => 'is_active']) --}}
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($licenseTypes as $type)
                    <tr>
                        <td class="px-6 py-4">{{ $type->type_name }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="bg-gray-200 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded ">
                                {{ $type->type_category }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ Str::limit($type->type_description, 50) }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="bg-{{ $type->is_active ? 'green' : 'red' }}-500 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                {{ $type->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <x-gold-button-link href="{{ route('admin.license-types.edit', $type->id) }}"
                                class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                <x-icons.pencil-square /> Edit
                            </x-gold-button-link>
                            <button wire:click="delete({{ $type->id }})"
                                class="px-4 py-2 ml-2 font-bold text-white bg-red-500 rounded hover:bg-red-700"
                                onclick="return confirm('Are you sure?')">
                                <x-icons.trash-icon />
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center">
                            No license types found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3">
        {{ $licenseTypes->links() }}
    </div>
</div>
