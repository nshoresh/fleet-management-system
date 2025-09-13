<x-app-layout>

    <x-slot name="header">

    </x-slot>
    <div class="py-12">

        <div class="mx-auto max-w-12xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-2xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:client.vehicles.vehicle-listing lazy />

                        <!-- Download Excel Button -->

                        <a href="{{ route('app.vehicles_download_excel') }}"
                        class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Download XLSX
                        </a>

                        <!-- Download CSV Button -->

                        <a href="{{ route('app.vehicles_download_csv') }}"
                        class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
                            Download CSV
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->
