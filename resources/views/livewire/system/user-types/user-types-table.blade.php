<div> 
    <x-slot name='header'>
        <div class="px-2 py-2 bg-yellow-100">
            <h2 class="text-xl font-semibold">
                User Types
            </h2>
        </div>
    </x-slot>

    <!-- Table -->
    <div class="p-4 overflow-y-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-yellow-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left text-yellow-700 uppercase cursor-pointer">
                        ID
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left  text-yellow-700 uppercase cursor-pointer">
                        Type Name
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left  text-yellow-700 uppercase">
                        Slug
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left  text-yellow-700 uppercase cursor-pointer">
                        Description
                    </th>
                    <th scope="col"
                        class="px-6 py-6 text-xs font-medium tracking-wider text-left  text-yellow-700 uppercase cursor-pointer">
                        Access Code
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($userTypes as $userType)
                    <tr>
                        <td class="px-4 py-2 ">{{ $userType->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $userType->type_name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $userType->slug }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $userType->description }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $userType->access_code }}
                        </td>
                    </tr>
                @empty
                    <tr class="px-6 text-left border">
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            No User types found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
