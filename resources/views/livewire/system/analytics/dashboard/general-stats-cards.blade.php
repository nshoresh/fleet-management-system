<div>
    {{-- LocationCounts General Stats Cards --}}
    <div class="p-6 ">
        {{-- <h2 class="mb-6 text-2xl font-bold text-gray-800">LocationCounts Overview</h2> --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
            {{-- Vehicles Stats Card --}}
            {{-- ownerCount --}}

            <div class="flex flex-col h-full p-6 bg-white border-t-4 border-yellow-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Vehicle Owners</h3>
                    <div class="p-3 bg-indigo-100 rounded-full">
                        <x-icons.users />
                    </div>
                </div>

                <div class="mt-2">
                    <span class="text-3xl font-bold text-yellow-600">{{ number_format($ownerCount) }}</span>
                </div>

                <div class="flex items-center mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 {{ $ownerTrend >= 0 ? 'text-green-500' : 'text-red-500' }}" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="{{ $vehicleTrend >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                    </svg>
                    <span class="ml-1 {{ $ownerTrend >= 0 ? 'text-green-500' : 'text-red-500' }} font-medium">
                        {{ abs($ownerTrend) }}% {{ $ownerTrend >= 0 ? 'increase' : 'decrease' }}
                    </span>
                    <span class="ml-1 text-sm text-gray-500">since last month</span>
                </div>
            </div>
            <div class="flex flex-col h-full p-6 bg-white border-t-4 border-indigo-600 rounded-lg shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Vehicles</h3>
                    <div class="p-3 bg-indigo-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                </div>

                <div class="mt-2">
                    <span class="text-3xl font-bold text-indigo-600">{{ number_format($vehicleCount) }}</span>
                </div>

                <div class="flex items-center mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 {{ $vehicleTrend >= 0 ? 'text-green-500' : 'text-red-500' }}" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="{{ $vehicleTrend >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                    </svg>
                    <span class="ml-1 {{ $vehicleTrend >= 0 ? 'text-green-500' : 'text-red-500' }} font-medium">
                        {{ abs($vehicleTrend) }}% {{ $vehicleTrend >= 0 ? 'increase' : 'decrease' }}
                    </span>
                    <span class="ml-1 text-sm text-gray-500">since last month</span>
                </div>
            </div>

            {{-- Licenses Stats Card --}}
            <div class="flex flex-col h-full p-6 bg-white border-t-4 rounded-lg shadow-md border-sky-500">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Licenses</h3>
                    <div class="p-3 rounded-full bg-sky-100">
                        <x-icons.permit />
                    </div>
                </div>

                <div class="mt-2">
                    <span class="text-3xl font-bold text-sky-500">{{ number_format($licenseCount) }}</span>
                </div>

                <div class="flex items-center mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 {{ $licenseTrend >= 0 ? 'text-green-500' : 'text-red-500' }}" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="{{ $licenseTrend >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                    </svg>
                    <span class="ml-1 {{ $licenseTrend >= 0 ? 'text-green-500' : 'text-red-500' }} font-medium">
                        {{ abs($licenseTrend) }}% {{ $licenseTrend >= 0 ? 'increase' : 'decrease' }}
                    </span>
                    <span class="ml-1 text-sm text-gray-500">since last month</span>
                </div>
            </div>

            {{-- RFID Devices Stats Card --}}
            <div class="flex flex-col h-full p-6 bg-white border-t-4 rounded-lg shadow-md border-emerald-500">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">RFID Devices</h3>
                    <div class="p-3 rounded-full bg-emerald-100">
                        <x-icons.chip />
                    </div>
                </div>

                <div class="mt-2">
                    <span class="text-3xl font-bold text-emerald-500">{{ number_format($rfidCount) }}</span>
                </div>

                <div class="flex items-center mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 {{ $rfidTrend >= 0 ? 'text-green-500' : 'text-red-500' }}" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="{{ $rfidTrend >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                    </svg>
                    <span class="ml-1 {{ $rfidTrend >= 0 ? 'text-green-500' : 'text-red-500' }} font-medium">
                        {{ abs($rfidTrend) }}% {{ $rfidTrend >= 0 ? 'increase' : 'decrease' }}
                    </span>
                    <span class="ml-1 text-sm text-gray-500">since last month</span>
                </div>
            </div>
        </div>
    </div>
</div>
