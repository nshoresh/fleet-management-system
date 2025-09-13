<x-app-layout>

    <x-slot name="header">

    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-12xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-2xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:client.users.users-list lazy />
                </div>
            </div>
        </div>
</x-app-layout>
<!-- The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh -->
