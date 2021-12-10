@push('js')
    <script>
        var totalSales = @json($sales);
        var ctxL = document.getElementById("{{ $idChart }}").getContext('2d');
        var gradientStroke = ctxL.createLinearGradient(0, 230, 0, 50);
        gradientStroke.addColorStop(1.0, 'rgba(255, 255, 255,0.2)');
        gradientStroke.addColorStop(0.5, 'rgba(255, 255, 255,0.05)');
        gradientStroke.addColorStop(0.0, 'rgba(255, 255, 255,0.0)');

        //purple colors
        var config = {
            type: 'line',
            data: {
                labels: [
                    @foreach ($sales as $station)
                        "{{ $station['station'] }}",
                    @endforeach
                ],
                datasets: [{
                    fill: true,
                    backgroundColor: gradientStroke,
                    borderColor: '#FFFFFF',
                    borderWidth: 2,
                    borderDash: [],
                    borderDashOffset: 0.0,
                    pointBackgroundColor: '#FFFFFF',
                    pointBorderColor: 'rgba(255,255,255,0)',
                    pointHoverBackgroundColor: '#FFFFFF',
                    pointBorderWidth: 20,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 15,
                    pointRadius: 4,
                    data: [
                        @foreach ($sales as $total)
                            "{{ $total['total'] }}",
                        @endforeach
                    ]
                }]
            },
            options: gradientChartOptionsConfigurationWithTooltipPurple,
        };

        var myChartDataL = new Chart(ctxL, config);
    </script>
@endpush
