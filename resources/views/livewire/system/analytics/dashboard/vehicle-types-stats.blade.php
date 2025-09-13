<div class="py-8 mx-auto space-y-8 max-w-12xl sm:px-6 lg:px-8">
    <!-- ... (keep existing summary and top types sections the same) ... -->

    <!-- Detailed Statistics Pie Chart -->
    <div class="overflow-hidden bg-white border border-gray-100 rounded-lg shadow-md">
        <div class="p-6">
            <div class="flex items-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 text-indigo-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <h3 class="text-lg font-bold text-gray-800">Vechicles-Vehicle types Distribution</h3>
            </div>
            <div class="relative h-96"> <!-- Added container for responsive chart -->
                <canvas id="vehicleTypesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        const initChart = () => {
            const ctx = document.getElementById('vehicleTypesChart');
            if (!ctx) return;

            // Destroy existing chart instance if it exists
            if (ctx.chart) {
                ctx.chart.destroy();
            }

            // Create new chart
            ctx.chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: @json($typesStats->pluck('name')),
                    datasets: [{
                        label: 'Vehicle Count',
                        data: @json($typesStats->pluck('vehicles')), // Ensure this is numeric values
                        backgroundColor: [
                            '#3B82F6', '#10B981', '#F59E0B', '#6366F1', '#EC4899',
                            '#6B7280',
                            '#84CC16', '#F97316', '#8B5CF6', '#06B6D4'
                        ],
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 20,
                                padding: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b,
                                        0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        };

        // Initial chart creation
        initChart();

        // Refresh chart when Livewire updates
        Livewire.hook('morph.updated', () => initChart());
    });
</script>
