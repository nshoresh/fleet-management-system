<div wire:poll.60s="updateCount" class="relative inline-block">
    <x-sidebar-link route="admin.license.applications" wire:navigate
        class="block px-3 py-2 ml-8 text-gray-600 transition duration-150 rounded-md hover:bg-blue-50 hover:text-blue-700">
        <span>License Applications</span>
        @if ($count > 0)
            <span
                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 
                       text-xs font-bold leading-none text-white bg-red-600 rounded-full -mt-2 -mr-2">
                {{ $count }}
            </span>
        @endif
    </x-sidebar-link>
</div>
