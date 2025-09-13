<div>
    <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
        <!-- Total Licenses Card -->
        <div class="p-6 bg-white border-l-4 border-blue-500 rounded-lg shadow-md ">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 ">Total Licenses</p>
                    <p class="text-3xl font-bold text-gray-900 ">{{ number_format($totalLicenses) }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500 " fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Licenses Card -->
        <div class="p-6 bg-white border-l-4 border-green-500 rounded-lg shadow-md ">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 ">Active Licenses</p>
                    <p class="text-3xl font-bold text-gray-900 ">{{ number_format($activeLicenses) }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full dark:bg-green-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-500 dark:text-green-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <span
                        class="font-medium text-green-500">{{ $totalLicenses > 0 ? round(($activeLicenses / $totalLicenses) * 100) : 0 }}%</span>
                    of total licenses
                </p>
            </div>
        </div>

        <!-- Expired Licenses Card -->
        <div class="p-6 bg-white border-l-4 border-red-500 rounded-lg shadow-md ">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 ">Expired Licenses</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($expiredLicenses) }}
                    </p>
                </div>
                <div class="p-3 bg-red-100 rounded-full dark:bg-red-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-500 dark:text-red-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <span
                        class="font-medium text-red-500">{{ $totalLicenses > 0 ? round(($expiredLicenses / $totalLicenses) * 100) : 0 }}%</span>
                    of total licenses
                </p>
            </div>
        </div>

        <!-- Expiring Soon Card -->
        <div class="p-6 bg-white border-l-4 border-yellow-500 rounded-lg shadow-md ">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 ">Expiring in 30 Days</p>
                    <p class="text-3xl font-bold text-gray-900 ">{{ number_format($expiringLicenses) }}
                    </p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500 " fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-sm text-gray-500 ">
                    <span
                        class="font-medium text-yellow-500">{{ $activeLicenses > 0 ? round(($expiringLicenses / $activeLicenses) * 100) : 0 }}%</span>
                    of active licenses
                </p>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="p-6 mb-6 bg-white rounded-lg shadow-md ">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">License Trends</h3>
            <div class="flex space-x-2">
                <button wire:click="changePeriod('week')"
                    class="px-3 py-1.5 text-sm font-medium rounded-md {{ $selectedPeriod === 'week' ? 'bg-yellow-500 text-white  ' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-500' }}">
                    Week
                </button>
                <button wire:click="changePeriod('month')"
                    class="px-3 py-1.5 text-sm font-medium rounded-md {{ $selectedPeriod === 'month' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-500' }}">
                    Month
                </button>
                <button wire:click="changePeriod('year')"
                    class="px-3 py-1.5 text-sm font-medium rounded-md {{ $selectedPeriod === 'year' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-500' }}">
                    Year
                </button>
            </div>
        </div>
        <div wire:ignore>
            <canvas id="licensesTrendChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Licenses by Type -->
        <div class="p-6 bg-white rounded-lg shadow-md ">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 ">Licenses by Type</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 ">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                                License Type</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                                Count</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                                Percentage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 ">
                        @forelse($licensesByType as $type)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                    {{ $type['name'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap ">
                                    {{ number_format($type['total']) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 ">
                                            <div class="bg-blue-600 h-2.5 rounded-full"
                                                style="width: {{ $totalLicenses > 0 ? ($type['total'] / $totalLicenses) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                        <span
                                            class="ml-2 text-xs text-gray-600 ">{{ $totalLicenses > 0 ? round(($type['total'] / $totalLicenses) * 100) : 0 }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-sm text-center text-gray-500 ">No license
                                    types found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Licenses by Purpose -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 ">Licenses by Purpose</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                                Purpose</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                                Count</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                                Percentage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 ">
                        @forelse($licensesByPurpose as $purpose)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap ">
                                    {{ $purpose['name'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap ">
                                    {{ number_format($purpose['total']) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 ">
                                            <div class="bg-purple-600 h-2.5 rounded-full"
                                                style="width: {{ $totalLicenses > 0 ? ($purpose['total'] / $totalLicenses) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                        <span
                                            class="ml-2 text-xs text-gray-600 ">{{ $totalLicenses > 0 ? round(($purpose['total'] / $totalLicenses) * 100) : 0 }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-sm text-center text-gray-500">No license
                                    purposes found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            const chartContext = document.getElementById('licensesTrendChart').getContext('2d');
            let licensesTrendChart = new Chart(chartContext, {
                type: 'line',
                data: @json($chartData),
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });

            Livewire.on('chartDataUpdated', function(chartData) {
                licensesTrendChart.data = chartData[0];
                licensesTrendChart.update();
            });

        });
    </script>

</div>
