<x-app-layout>
    <x-slot name='header'>
        <div class="px-4 py-2 bg-yellow-100">
            <h2 class="text-xl font-semibold">
                {{ __('Permissions Management') }}
            </h2>
        </div>
    </x-slot>


    <livewire:system.permissions.permissions-table lazy />

</x-app-layout>
