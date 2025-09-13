<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-12xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <livewire:client.vehicles.view-vehicle :id="$vehicle->id" lazy />

                    <!-- Download PDF Button -->
                    <div class="mt-6">
                        <a href="{{ route('app.vehicle_download_pdf', $vehicle->uuid) }}"
                           class="inline-block px-4 py-2 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                            Download PDF
                        </a>
                        <!-- Download Excel Button -->

                        <a href="{{ route('app.vehicle_download_excel', $vehicle->uuid) }}"
                        class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Download XLSX
                        </a>

                        <!-- Download CSV Button -->

                        <a href="{{ route('app.vehicle_download_csv', $vehicle->uuid) }}"
                        class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
                            Download CSV
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
