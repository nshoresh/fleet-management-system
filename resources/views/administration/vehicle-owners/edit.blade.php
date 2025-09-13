<x-app-layout>
    <x-slot name='header'>
        <h1>{{ __('Edit Vehicle Owner') }}</h1>
    </x-slot>
    <!-- Nothing in life is to be feared, it is
        only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->

    <livewire:admin.vehicle-owners.edit-vehicle-owner :vehicleOwner="$vehicleOwner" />
</x-app-layout>
