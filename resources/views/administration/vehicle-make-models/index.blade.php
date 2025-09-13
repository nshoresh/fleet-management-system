<x-app-layout>
    <x-slot name='header'>
        <div class="px-4 py-2 bg-yellow-100">
        <h2 class="text-xl font-semibold">{{ __('Vehicle Make Models Management') }}</h2>
        <div></div>
    </x-slot>

    <livewire:vehicles.make-model.make-model-list lazy />

</x-app-layout>
