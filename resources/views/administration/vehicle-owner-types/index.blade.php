<x-app-layout>
    <x-slot name='header'>
        <div class="px-4 py-2 bg-yellow-100">
        <h2 class="text-xl font-semibold">{{ __('Vehicle Owner Types  Management') }}</h2>
        </div>
    </x-slot>

    <livewire:admin.vehicle-owner-types.vehicle-owner-types-table lazy />

</x-app-layout>
