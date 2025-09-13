<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('License List') }}
        </h2>
    </x-slot>
    <div>
        <livewire:client.license.license-list lazy />
        <!-- If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius -->
    </div>
</x-app-layout>
