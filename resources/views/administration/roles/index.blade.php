<x-app-layout>
    <x-slot name='header'>
        <div class="px-4 py-2 bg-yellow-100">
            <h2 class="text-xl font-semibold">
                {{ __('Roles Management') }}
            </h2>
        </div>
    </x-slot>
    <livewire:system.roles.roles-table lazy />

</x-app-layout>
