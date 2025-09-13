<div class="py-8 mx-auto space-y-8 max-w-12xl sm:px-6 lg:px-8">
    <div class="overflow-hidden bg-white border border-gray-100 rounded-lg shadow-md">
        <div class="p-6">
            <div class="flex items-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 text-indigo-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
                <h3 class="text-lg font-bold text-gray-800">Vehicle Makes Distribution</h3>
            </div>
            <div class="relative h-96">
                <canvas id="manufacturerChart"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('livewire:init', () => {
        const initManufacturerChart = () => {
            const ctx = document.getElementById('manufacturerChart');
            if (!ctx) return;

            if (ctx.chart) {
                ctx.chart.destroy();
            }

            ctx.chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: @json($makesStats->pluck('name')),
                    datasets: [{
                        label: 'Vehicles per Manufacturer',
                        data: @json($makesStats->pluck('vehicles_raw')),
                        backgroundColor: [
                            '#3B82F6', '#10B981', '#F59E0B', '#6366F1', '#EC4899',
                            '#8B5CF6', '#06B6D4', '#84CC16', '#F97316', '#6B7280'
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
                                padding: 15,
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b,
                                        0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value.toLocaleString()} vehicles (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        };
        initManufacturerChart();
        Livewire.hook('morph.updated', () => initManufacturerChart());
    });
</script>
