<x-app-layout>
    <x-slot name='header'>
        <h1>{{ __('Role  Permissions Management') }}</h1>
    </x-slot>

    <livewire:system.roles.role-permissions id="{{ $id }}" lazy />

</x-app-layout>
