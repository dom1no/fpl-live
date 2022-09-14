<canvas id="chart-points" class="chart-canvas mt-4 p-3" height="180"></canvas>

@push('js')
    <script src="{{ asset('assets') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script type="text/javascript">
        const data = {
            labels: @json($manager->pointsHistory->pluck('gameweek_id')->sort()->all()),
            datasets: [{
                label: '{{ $manager->name }}',
                data: @json($manager->pointsHistory->sortBy('gameweek_id')->pluck('points')->all()),
                borderWidth: 1,
                backgroundColor: 'rgba(63, 87, 223, .7)',
                barPercentage: 0.7
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                legend: {
                    display: false
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                    xAxes: [{
                        maxBarThickness: 100,
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: 10,
                            max: {{ $manager->pointsHistory->max('points') + 20 - ($manager->pointsHistory->max('points') % 10) }}
                        }
                    }]
                },
                tooltips: {
                    enabled: false
                },
                hover: {
                    animationDuration: 1
                },
                animation: {
                    duration: 1,
                    onComplete: function () {
                        let chartInstance = this.chart,
                            ctx = chartInstance.ctx;
                        ctx.textAlign = 'center';
                        ctx.fillStyle = "#000";
                        ctx.textBaseline = 'bottom';

                        let dataset = this.data.datasets[0];
                        let meta = chartInstance.controller.getDatasetMeta(0);
                        meta.data.forEach(function (bar, index) {
                            let data = dataset.data[index];
                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
                        });
                    }
                },
            },
        };

        new Chart(
            document.getElementById('chart-points'),
            config
        );
    </script>
@endpush
