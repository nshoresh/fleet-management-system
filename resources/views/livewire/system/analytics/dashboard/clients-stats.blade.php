<div class="overflow-hidden bg-white border border-gray-100 rounded-lg shadow-md">
    <div class="p-6">
        <h3 class="flex items-center mb-6 text-lg font-bold text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-blue-600" viewBox="0 0 20 20"
                fill="currentColor">
                <path
                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
            </svg>
            Vehicle Owner Statistics
        </h3>
        <!-- Added a fixed height container to constrain the chart -->
        <div class="p-4 border rounded">
            <h4 class="mb-2 font-semibold text-gray-700">Fleets Distribution by Owner</h4>
            <div style="height: 500px;"> <!-- Fixed height container -->
                <canvas id="ownerVehicleChart"></canvas> <!-- Removed height/width attributes -->
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const ownerVehicleCtx = document.getElementById('ownerVehicleChart').getContext('2d');

            let ownerVehicleChart;

            Livewire.on('update-charts', (data) => {
                const ownerVehicleData = data.ownerVehicleCounts;
                if (ownerVehicleChart) {
                    ownerVehicleChart.data.labels = ownerVehicleData.labels;
                    ownerVehicleChart.data.datasets[0].data = ownerVehicleData.data;
                    ownerVehicleChart.update();
                } else {
                    // Owner Vehicle Chart
                    ownerVehicleChart = new Chart(ownerVehicleCtx, {
                        type: 'bar',
                        data: {
                            labels: ownerVehicleData.labels,
                            datasets: [{
                                label: 'Number of Fleets',
                                data: ownerVehicleData.data,
                                backgroundColor: ownerVehicleData.colors,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Fleets'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Vehicle Owner'
                                    }
                                }
                            },
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return `Number of Fleets: ${context.raw}`;
                                        }
                                    }
                                }
                            }
                        },
                        plugins: [{
                            id: 'barLabels',
                            afterDatasetsDraw: function(chart) {
                                const ctx = chart.ctx;
                                chart.data.datasets.forEach((dataset, datasetIndex) => {
                                    const meta = chart.getDatasetMeta(
                                        datasetIndex);
                                    if (!meta.hidden) {
                                        meta.data.forEach((element, index) => {
                                            // Draw the value on top of the bar
                                            const value = dataset.data[
                                                index];
                                            const position = element
                                                .getCenterPoint();

                                            // Position to display the text
                                            const x = position.x;
                                            const y = element.y -
                                                10; // 10px above the bar

                                            ctx.save();
                                            ctx.textAlign = 'center';
                                            ctx.textBaseline = 'middle';
                                            ctx.font =
                                                'bold 12px Arial';
                                            ctx.fillStyle = '#000';
                                            ctx.fillText(value, x, y);
                                            ctx.restore();
                                        });
                                    }
                                });
                            }
                        }]
                    });
                }

                function generateColors(numColors) {
                    const colors = [];
                    for (let i = 0; i < numColors; i++) {
                        // Generate a random color
                        const r = Math.floor(Math.random() * 255);
                        const g = Math.floor(Math.random() * 255);
                        const b = Math.floor(Math.random() * 255);
                        colors.push(`rgba(${r}, ${g}, ${b}, 0.7)`);
                    }
                    return colors;
                }
            });

            // Initial chart update
            Livewire.dispatch('update-charts', {
                ownerVehicleCounts: @js($ownerVehicleCounts),
            });
        });
    </script>
</div>
