@extends('layouts.app', ['pageSlug' => $estacion_dashboard ?? 'Estaciones', 'titlePage' => __($station->name)])

@section('content')

    <div class="tab-content text-center">
        <div class="tab-pane active" id="updates">
            <div class="row mx-3">
                <div class="card mb-3 card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="statistics">
                                    <div class="card-body pt-0 pb-0 text-left">
                                        <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('Subir excel de ventas') }}
                                        </h6>
                                        <form id="sales" action="{{ route('uploadexcelsales', $station) }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="excel" id="file_excel" required onfocus
                                                accept=".csv,.xlsx,.xls,.ods">
                                            <button type="submit" id="btnFetch"
                                                class="spinner-button btn btn-sm btn-success">
                                                {{ __('Cargar excel') }}
                                            </button>
                                            @if ($errors->has('extension'))
                                                <br>
                                                <span id="extension-error" class="error text-danger" for="input-extension">
                                                    {{ $errors->first('extension') }}
                                                </span>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-md-3">
                                <div class="statistics">
                                    <div class="card-body pt-0 pb-0 text-left">
                                        <h6 class="card-subtitle mt-0 mb-0 text-muted">
                                            {{ __('total de vales entregados') }}</h6>
                                        <h3 class="title mb-0">
                                            {{ number_format($station->exchanges->where('status', 14)->count(), 0) }}</h3>
                                    </div>
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-3">
                                <div class="statistics">
                                    <div class="card-body pt-0 pb-0 text-left">
                                        <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('litros vendidos') }}</h6>
                                        <h3 class="title mb-0">{{ number_format($station_show['liters'], 2) }}</h3>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-md-6">
                                <div class="">
                                    <div class=" card-body pt-0 pb-0
                                    text-left">
                                        <h6 class="card-subtitle mt-0 mb-0 text-muted">
                                            {{ __('total de tickets escaneados') }}
                                        </h6>
                                        <h3 class="title mt-0 mb-0">
                                            {{ number_format($station_show['tickets'], 0) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflowCards card-chart">
                        <div class="card-header">
                            <div class="row mt-1 mb-0">
                                <div class="col-sm-6 pt-2 text-left">
                                    <h3 class="card-subtitle text-muted">VENTAS TOTALES</h3>
                                </div>
                                <div class="col-sm-6">
                                    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                                        <label class="btn btn-sm btn-success btn-simple active" id="4">
                                            <input type="radio" name="options" checked>
                                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Magna</span>
                                            <span class="d-block d-sm-none">MA</span>
                                        </label>
                                        <label class="btn btn-sm btn-danger btn-simple" id="5">
                                            <input type="radio" class="d-none d-sm-none" name="options">
                                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Premium</span>
                                            <span class="d-block d-sm-none">PR</span>
                                        </label>
                                        <label class="btn btn-sm btn-primary btn-simple" id="7">
                                            <input type="radio" class="d-none" name="options">
                                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Ventas
                                                totales</span>
                                            <span class="d-block d-sm-none">
                                                VT
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-0 mb-0">
                                <div class="col-sm-5 text-left pt-3 pl-3">
                                    <h4 class="card-subtitle text-muted"> LITROS</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area_2 p-3">
                                <canvas id="chartBig1L"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $year = date('Y');
            @endphp

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflowCards card-chart">
                        <div class="card-header text-left">
                            <div class="row">
                                <div class="col-sm-7 pt-2">
                                    <h3 class="card-subtitle text-muted" id="valesTotalH3">Total de vales entregados:</h3>
                                </div>
                                <div class="col-sm-5 text-right">
                                    <select id="select_dash_1" class="selectpicker show-menu-arrow pr-4"
                                        data-style="btn-simple btn-github" data-width="50%">
                                        @for ($mes_imprimir = 0; $mes_imprimir < 3; $mes_imprimir++)
                                            <option value="{{ $mes_imprimir }}">{{ $year - $mes_imprimir }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="chart-area_3 mt-1 pl-5 pr-2 mr-5">
                                    <canvas id="CountryChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflowCards card-chart">
                        <div class="card-header text-left">
                            <div class="row">
                                <div class="col-sm-7 pt-2">
                                    <h3 class="card-subtitle text-muted" id="ticketsTotalH3">Total de tickets escaneados:
                                    </h3>
                                </div>
                                <div class="col-sm-5 text-right">
                                    <select id="select_dash_2" class="selectpicker show-menu-arrow pr-4"
                                        data-style="btn-simple btn-github" data-width="50%">
                                        @for ($mes_imprimir = 0; $mes_imprimir < 3; $mes_imprimir++)
                                            <option value="{{ $mes_imprimir }}">{{ $year - $mes_imprimir }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">

                                <div class="chart-area_3 mt-1 pl-5 pr-2 mr-5">
                                    <canvas id="CountryChart3"></canvas>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="tab-pane" id="history">
            <div class="row mr-0 ml-0">
                <div class="card mb-3 card-stats">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="statistics">
                                    <div class="card-body pt-0 pb-0 text-left">
                                        <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('Ventas totales') }}</h6>
                                        <h3 class="title mb-0">{{ count($station->sales) }}</h3>
                                        @if ($sales > 0)
                                            <a class="text-success mt-0 mb-0">+{{ $sales }} %</a>
                                        @elseif($sales == 0)
                                            <a class="text-muted mt-0 mb-0">{{ $sales }} %</a>
                                        @else
                                            <a class="text-danger mt-0 mb-0">{{ $sales }} %</a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="statistics">
                                    <div class="card-body pt-0 pb-0 text-left">
                                        <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('Litros vendidos') }}</h6>
                                        <h3 class="title mb-0">
                                            {{ $station->sales->where('liters', '>', 0)->sum('liters') }}</h3>
                                        @if ($liters > 0)
                                            <a class="text-success mt-0 mb-0">
                                                <i class="material-icons md-18">
                                                    arrow_circle_up
                                                </i>
                                                +{{ $liters }}%
                                            </a>
                                        @elseif($liters == 0)
                                            <a class="text-muted mt-0 mb-0">{{ $liters }} %</a>
                                        @else
                                            <a class="text-danger mt-0 mb-0">
                                                <i class="material-icons md-18">
                                                    arrow_circle_down
                                                </i>
                                                {{ $liters }}%
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-3">
                            <div class="">
                                    <div class=" card-body pt-0 pb-0 text-left">
                                <h6 class="card-subtitle mt-0 mb-0 text-muted">Abonos pendientes</h6>
                                <h3 class="title mt-0 mb-0">
                                    {{ count($station->deposits->where('status', 1)) }}
                                </h3>
                                <a href="{{ route('balances.index', $station) }}" class="badge badge-success mt-0 mb-0">
                                    Autorizar
                                </a>
                            </div>
                        </div> --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="card card-chart">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-sm-4 text-left">
                                <h3 class="title mb-0">Ventas totales</h3>
                                <h4 class="card-title mb-2">Litros</h4>
                            </div>
                            <div class="col-sm-8">
                                <div class="btn-group btn-group-toggle mx-auto d-block" data-toggle="buttons">
                                    <label class="btn btn-sm btn-success btn-simple active" id="0">
                                        <input type="radio" name="options" checked>
                                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Magna</span>
                                        <span class="d-block d-sm-none">MA</span>
                                    </label>
                                    <label class="btn btn-sm btn-danger btn-simple" id="1">
                                        <input type="radio" class="d-none d-sm-none" name="options">
                                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Premium</span>
                                        <span class="d-block d-sm-none">PR</span>
                                    </label>
                                    <label class="btn btn-sm btn-dark btn-simple btn-tumblr" id="2">
                                        <input type="radio" class="d-none" name="options">
                                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Diésel</span>
                                        <span class="d-block d-sm-none">DI</span>
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-simple" id="3">
                                        <input type="radio" class="d-none" name="options">
                                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Ventas
                                            totales</span>
                                        <span class="d-block d-sm-none">
                                            VT
                                        </span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area_2">
                            <canvas id="chartBig1"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 pl-0">
                <div class="row pl-3 pr-3">
                    <div class="card card-chart">
                        <div class="card-header ">
                            <h5 class="card-category">Ventas totales por producto</h5>
                            <h3 class="card-title"></h3>
                        </div>
                        <div class="card-body mt-3 mr-0 ml-0 pl-0 pr-0">
                            <div class="chart-area mr-0 ml-0 pl-0 pr-0">
                                <canvas id="chartLineGreen" class="mr-0 ml-0 pl-0 pr-0"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @endsection

    @push('js')
        <script>
            $("#btnFetch").click(function() {
                let file = document.getElementById('file_excel').value;
                if (file) {
                    // disable button
                    $(this).prop("disabled", true);
                    // add spinner to button
                    $(this).html(
                        'Cargando archivo...'
                    );
                    document.getElementById("sales").submit();
                }
            });
        </script>
    @endpush
