@extends('layouts.app', ['pageSlug' => 'dashboard', 'titlePage' => __('dashboard')])

@section('content')
    <div class="tab-content text-center">
        <div class="row">
            <div class="col-12 col-sm-6 text-left mb-3">
                @isset($currentperiod)
                    @if (!$currentperiod->finish)
                        <form class="form" id="finish" action="{{ route('periods.update', $currentperiod) }}"
                            method="POST">
                            @method('put')
                            @csrf
                            <a class="btn btn-danger text-white"
                                onclick="confirm('¿Esta seguro que desea finalizar el periodo?')?document.getElementById('finish').submit() : '';">
                                {{ __('Finalizar periodo') }}
                            </a>
                            <a class="btn btn-info text-white" data-toggle="modal" data-target="#termsAndConditions">
                                {{ __('Ver términos y condiciones') }}
                            </a>
                        </form>
                        <div class="modal fade" id="termsAndConditions" tabindex="-1" role="dialog"
                            aria-labelledby="termsAndConditionsLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title text-primary" id="termsAndConditionsLabel">
                                            <strong>{{ __('Términos y Condiciones') }}</strong>
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form" id="terminos"
                                            action="{{ route('periods.update', $currentperiod) }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <div class="row justify-content-center">
                                                <div class="form-group col-12">
                                                    <textarea class="form-control" name="conditions" id="input-conditions"
                                                        cols="50" rows="10"
                                                        placeholder="Escribe los términos y condiciones">{{ old('conditions', $currentperiod->terms) }}</textarea>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-info"
                                            onclick="confirm('Confirme la actualización de términos y condiciones')?document.getElementById('terminos').submit() : '';">
                                            {{ __('Guardar') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <a class="btn btn-info text-white" data-toggle="modal" data-target="#period">
                            {{ __('Iniciar nuevo periodo') }}
                        </a>
                    @endif
                @else
                    <a class="btn btn-info text-white" data-toggle="modal" data-target="#period">
                        {{ __('Iniciar nuevo periodo') }}
                    </a>
                @endisset
                <div class="modal fade" id="period" tabindex="-1" role="dialog" aria-labelledby="periodLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title text-primary" id="periodLabel">
                                    <strong>{{ __('Selecciona el periodo de activación') }}</strong>
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h5>
                                    {{ __('Una vez seleccinado el periodo los usuarios podrán comenzar a realizar la suma de sus puntos') }}
                                </h5>
                                <form class="form" id="init" action="{{ route('periods.store') }}"
                                    method="POST">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="form-group col-12 col-sm-6">
                                            <label class="label-control">{{ __('Fecha de inicio') }}</label>
                                            <input class="form-control datetimepicker" id="input-date-ini" name="date_start"
                                                type="text" value="" placeholder="Fecha de inicio" required>
                                            @include('partials.error',[$name='date_start'])
                                        </div>
                                        <div class="form-group col-12 col-sm-6">
                                            <label class="label-control">{{ __('Fecha de término') }}</label>
                                            <input class="form-control datetimepicker" id="input-date-end" name="date_end"
                                                type="text" value="" placeholder="Fecha de término" required>
                                            @include('partials.error',[$name='date_end'])
                                        </div>
                                        <div class="form-group col-12 col-sm-6">
                                            <label class="label-control">{{ __('Hora de inicio') }}</label>
                                            <input class="form-control datetimepicker" id="input-date-ini" name="hour_start"
                                                type="time" value="{{ old('hour_start', $hour) }}"
                                                placeholder="Fecha de inicio" required>
                                            @include('partials.error',[$name='hour_start'])
                                        </div>
                                        <div class="form-group col-12 col-sm-6">
                                            <label class="label-control">{{ __('Hora de término') }}</label>
                                            <input class="form-control datetimepicker" id="input-date-end" name="hour_end"
                                                type="time" value="{{ old('hour_end', $hour) }}"
                                                placeholder="Fecha de término" required>
                                            @include('partials.error',[$name='hour_end'])
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="form-group col-12">
                                            <textarea class="form-control" name="terms" id="input-terms" cols="30"
                                                placeholder="Escribe los términos y condiciones"
                                                rows="10">{{ old('terms') }}</textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info"
                                    onclick="confirm('¿Esta seguro que desea iniciar con la activacion de la promoción?')?document.getElementById('init').submit() : '';">
                                    {{ __('Iniciar periodo') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane active" id="updates">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('Usuarios registrados') }}</h6>
                            <h3 class="title mb-0">{{ $totalclients }}</h3>
                            @if ($clientsCurrentMonth > 0)
                                <a class="text-success"> +{{ $clientsCurrentMonth }} </a>
                            @elseif($clientsCurrentMonth == 0)
                                <a class="text-info"> {{ $clientsCurrentMonth }} </a>
                            @else
                                <a class="text-danger"> {{ $clientsCurrentMonth }} </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('Litros vendidos por periodo') }}</h6>
                            <h3 class="title mb-0">{{ $litersInThisPeriod }}</h3>
                            <a class="text-info">{{ $period }}</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('Tickets registrados') }}</h6>
                            <h3 class="title mt-0 mb-0">{{ number_format($tickets, 0) }}</h3>
                            <a class="mt-1 mb-1">
                                <br>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('litros vendidos') }}</h6>
                            <h3 class="title mb-0">{{ $totaliters }}</h3>
                            <a class="mt-1 mb-1">
                                <br>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card overflowCards card-chart bg-danger">
                <div class="card-header">
                    <div class="row mt-1 mb-0">
                        <div class="col-12 pt-2 text-left">
                            <h4 class="card-subtitle text-white">VENTAS TOTALES POR ESTACIÓN</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:44vh;">
                        <canvas id="totalSales"></canvas>
                    </div>
                    @include('Graphics.dashboardGraphics',[$sales=$totalSales,$idChart='totalSales'])
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card overflowCards card-chart bg-primary">
                <div class="card-header">
                    <div class="row mt-1 mb-0">
                        <div class="col-12 pt-2 text-left">
                            <h4 class="card-subtitle text-white">VENTAS TOTALES POR PERIODO POR ESTACIÓN</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:40vh;">
                        <canvas id="periodSales"></canvas>
                    </div>
                    @include('Graphics.dashboardGraphics',[$sales=$periodSales,$idChart='periodSales'])
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="height:55vh;">
                <div class="card-header text-left m-0 p-0 pt-4 pl-5 pb-0">
                    <h4 class="title text-primary font-weight-bold p-0 m-0 text-left">
                        {{ __('INFORMACIÓN POR ESTACIÓN') }}
                    </h4>
                </div>
                <div class="card-body text-left m-0 p-0 pt-3 pb-3">
                    <div class="row m-0 pl-5 pr-5 pt-0 pb-0">
                        <div class="table-full-width table-responsive col-sm-12 m-0 mr-0 ml-0 pr-0 pl-0">
                            <table class="table table-shopping">
                                <tbody>
                                    @foreach ($stations as $estacion_1)
                                        <tr>
                                            <td>
                                                <p class=" card-subtitle">{{ $estacion_1->name }}</p>
                                            </td>
                                            <td class="td-actions text-right">
                                                <a class="btn btn-danger btn-link p-0 m-0" data-original-title=""
                                                    href="{{ route('stations.show', $estacion_1) }}" rel="tooltip"
                                                    title="Ver información de la estación">
                                                    <i class="material-icons text-success">keyboard_arrow_right</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card overflowCards card-chart">
                <div class="card-header">
                    <div class="row mt-1 mb-0">
                        <div class="col-12 col-md-6 pt-2 text-left">
                            <h4 class="card-subtitle">{{ __('VENTAS TOTALES POR DÍA') }}</h4>
                        </div>
                        <div class="col-12 col-md-6 pt-2 text-center">
                            <h4 style="float: left;" class="mx-1">
                                <i class="fas fa-square-full text-primary"></i> {{ $months[0][1] }}
                            </h4>
                            <h4 style="float: left;" class="mx-1">
                                <i class="fas fa-square-full text-danger"></i> {{ $months[1][1] }}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:60vh;">
                        <canvas id="totalPerDay"></canvas>
                    </div>
                    @push('js')
                        <script>
                            var totalSales = @json($totalPerDay);
                            var ctxL = document.getElementById("totalPerDay").getContext('2d');
                            var red = ctxL.createLinearGradient(238, 3, 3, 50);
                            red.addColorStop(1.0, 'rgba(238, 3, 3,1)');
                            var blue = ctxL.createLinearGradient(28, 28, 205, 50);
                            blue.addColorStop(1.0, 'rgba(28, 28, 205,1)');

                            //purple colors
                            var config = {
                                type: 'bar',
                                data: {
                                    labels: [
                                        @foreach ($totalPerDay['days'] as $day)
                                            "{{ $day }}",
                                        @endforeach
                                    ],
                                    datasets: [{
                                        label: "{{ $months[0][1] }}",
                                        fill: true,
                                        backgroundColor: blue,
                                        borderColor: '#0E6CC4',
                                        borderWidth: 1,
                                        barPercentage: 0.5,
                                        borderDashOffset: 0.0,
                                        data: [
                                            @foreach ($totalPerDay['salesFmonth'] as $total)
                                                "{{ $total }}",
                                            @endforeach
                                        ]
                                    }, {
                                        label: "{{ $months[1][1] }}",
                                        fill: true,
                                        backgroundColor: red,
                                        borderColor: '#F30F00',
                                        borderWidth: 1,
                                        barPercentage: 0.5,
                                        borderDashOffset: 0.0,
                                        data: [
                                            @foreach ($totalPerDay['salesSmonth'] as $total)
                                                "{{ $total }}",
                                            @endforeach
                                        ]
                                    }]
                                },
                                options: gradientChartOptionsConfigurationWithTooltipPurple,
                            };

                            var myChartDataL = new Chart(ctxL, config);
                        </script>
                    @endpush
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">{{ __('Registro de ventas excel de las estaciones') }}</h4>
                    <p class="card-category">
                        {{ __('Aquí puedes ver las ventas excel de las estaciones.') }}
                    </p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <select id="input-station" name="station" class="selectpicker show-menu-arrow"
                                data-style="btn-primary" data-width="100%">
                                <option selected value="0">{{ __('Todas las estaciones') }}
                                </option>
                                @foreach ($stations as $station)
                                    <option value="{{ $station->id }}">{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                            cellspacing="0" width="100%" id="datatable_1">
                            <thead class=" text-primary">
                                <th>{{ __('Estación') }}</th>
                                <th>{{ __('Ticket') }}</th>
                                <th>{{ __('Producto') }}</th>
                                <th>{{ __('Litros') }}</th>
                                <th>{{ __('Pago') }}</th>
                                <th>{{ __('Fecha') }}</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        init_calendar('input-date-ini', "{{ $start }}");
        init_calendar('input-date-end', "{{ $start }}");

        // getExcelSales();

        $("#input-station").change(function() {
            getExcelSales();
        });

        async function getExcelSales() {
            try {
                let station = document.getElementById('input-station').value;
                station = station != 0 ? station : '';
                const resp = await fetch(`{{ url('sales/${station}') }}`);
                const data = await resp.json();
                console.log(data);
                destruir_table("datatable_1");
                $('#datatable_1').find('tbody').empty();
                data.sales.forEach(sale => {
                    $("#datatable_1").find('tbody').append( /* html */ `
                        <tr>
                            <td>${sale.station.name}</td>
                            <td>${sale.ticket}</td>
                            <td>${sale.product}</td>
                            <td>${Number(sale.liters).toFixed(3)} Lts</td>
                            <td>$${Number(sale.payment).toFixed(2)}</td>
                            <td>${sale.date}</td>
                        </tr>
                    `);
                });
                iniciar_date('datatable_1');
            } catch (error) {
                console.log(error);
            }
        }
    </script>
@endpush
