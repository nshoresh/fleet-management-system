<x-app-layout>
    <x-slot name='header'>
        <div class="px-4 py-2 bg-yellow-100">
        <h2 class="text-xl font-semibold">{{ __('Vehicle Owners Management') }}</h2>
        </div>
    </x-slot>

    <livewire:admin.vehicle-owners.vehicle-owners-table lazy />

</x-app-layout>
