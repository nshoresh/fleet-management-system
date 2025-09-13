<div>
    <div class="mb-4 flex flex-wrap items-center gap-4">
        <div class="flex-1 min-w-[220px]">
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
                        <input wire:model.live.debounce.300ms='search' id="search"
                            class="block w-full py-2 pl-10 pr-3 leading-5 placeholder-gray-500 bg-white border border-gray-300 rounded-md focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Search roles..." type="search">
                    </div>
                </div>
            </div>
        </div>
        <div wire:loading class="flex-col items-center justify-center overflow-hidden opacity-75 ">
            <x-loading-indicator />
        </div>
        <div>
            <select wire:model.live="perPage" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                @foreach ($perPageOptions as $option)
                    <option value="{{ $option }}">{{ $option }} per page</option>
                @endforeach
            </select>
        </div>
        <div>
            <select wire:model.live.debound.300ms="groupFilter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                <option value="">All Groups</option>
                @foreach ($groups as $group)
                    <option value="{{ $group }}">{{ $group }}</option>
                @endforeach
            </select>
        </div>
    </div>

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
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer" 
                        wire:click="sortBy('name')">
                        Permission Name
                        @if ($sortField === 'name')
                            <span>{{ $sortDirection === 'asc' ? '🔼' : '🔽' }}</span>
                        @endif
                    </th>
                    <th scope="col" 
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer" 
                        wire:click="sortBy('name')">
                        Slug
                        @if ($sortField === 'name')
                            <span>{{ $sortDirection === 'asc' ? '🔼' : '🔽' }}</span>
                        @endif
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer" 
                        wire:click="sortBy('name')">
                        Desciption

                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer" 
                        wire:click="sortBy('group')">
                        Group
                        @if ($sortField === 'group')
                            <span>{{ $sortDirection === 'asc' ? '🔼' : '🔽' }}</span>
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($permissions as $index => $permission)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $permission->name }}</td>
                        {{-- description --}}

                        <td class="px-6 py-4 text-sm text-gray-600">{{ $permission->slug }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $permission->description ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $permission->group }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No permissions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3">
        {{ $permissions->links('vendor.pagination.tailwind') }}
    </div>
</div>
