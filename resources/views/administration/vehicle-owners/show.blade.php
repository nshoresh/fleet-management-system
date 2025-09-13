<x-app-layout>
    <x-slot name='header'>
        <h1>{{ __('Vehicle Owner Details') }}</h1>
    </x-slot>
    <livewire:admin.vehicle-owners.view-vehicle-owners id="{{ $id }}" lazy />

</x-app-layout>
