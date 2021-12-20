@extends('layouts.app', ['pageSlug' => 'Clientes', 'titlePage' => __('Gestión de clientes')])

@section('content')

    <ul class="nav nav-pills nav-pills-info nav-pills-icons row" role="tablist">
        <li class="nav-item col-sm-3">
            <a class="nav-link font-weight-bold active" href="#animas-1" role="tab" data-toggle="tab">
                {{ __('Ánimas') }}
            </a>
        </li>
        <li class="nav-item col-sm-3">
            <a class="nav-link font-weight-bold" href="#vanoe-1" role="tab" data-toggle="tab">
                {{ __('Vanoe') }}
            </a>
        </li>
        <li class="nav-item col-sm-3">
            <a class="nav-link font-weight-bold" href="#aldia-1" role="tab" data-toggle="tab">
                {{ __('Aldia') }}
            </a>
        </li>
        <li class="nav-item col-sm-3">
            <a class="nav-link font-weight-bold" href="#dorada-1" role="tab" data-toggle="tab">
                {{ __('Dorada') }}
            </a>
        </li>
    </ul>

    <div class="card mt-4 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-2">
                    <label class="label-control">Fecha de inicio</label>
                    <input class="form-control datetimepicker" id="input-date-ini" name="input-date-ini" type="text"
                        value="" placeholder="Fecha">
                </div>
                <div class="form-group col-sm-2">
                    <label class="label-control">Fecha de fin</label>
                    <input class="form-control datetimepicker" id="input-date-end" name="input-date-end" type="text"
                        value="" placeholder="Fecha">
                </div>

                <input type="text" class="form-control d-none" id="input-client_id"
                    placeholder="Escribe la membresía del usuario" name="client_id" value="{{ $client->id }}">

                <div class="form-group mt-3 col-sm-2">
                    <button id="points" type="submit" class="btn btn-primary">{{ __('Buscar') }}</button>
                </div>

                <div class="col text-right">
                    <h4 class="text-primary font-weight-bold">Puntos totales
                        <p class="text-primary font-weight-bold h3">{{ $client->puntos->sum('points') }}</p>
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-content tab-space">
        <div class="tab-pane active" id="animas-1">
            @include('clients.tablepoints',[$stationame='animas'])
        </div>
        <div class="tab-pane" id="vanoe-1">
            @include('clients.tablepoints',[$stationame='vanoe'])
        </div>
        <div class="tab-pane" id="aldia-1">
            @include('clients.tablepoints',[$stationame='aldia'])
        </div>
        <div class="tab-pane" id="dorada-1">
            @include('clients.tablepoints',[$stationame='dorada'])
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <h4 class="card-title">
                    <a class="btn btn-primary" href="{{ route('clients.index') }}" title="Regresar a la lista"
                        class="h4">
                        {{ __('Regresar') }}
                    </a>
                </h4>
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script>
        $(document).ready(function() {
            iniciar_date('animas_table');
            iniciar_date('vanoe_table');
            iniciar_date('aldia_table');
            iniciar_date('dorada_table');
            init_calendar('input-date-ini', '01-01-2018', '07-07-2025');
            init_calendar('input-date-end', '01-01-2018', '07-07-2025');
        });
        // Ajax para el historial de puntos
        $("#points").click(function() {
            document.getElementById('points').disabled = true;
            document.getElementById('points').innerHTML = "Buscando...";
            $.ajax({
                url: "{{ route('history.points') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    'client_id': $('#input-client_id').val(),
                    'inicial': $('#input-date-ini').val(),
                    'final': $('#input-date-end').val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    demo.showNotification('top', 'center', 'Consulta realizada correctamente.',
                        'tim-icons icon-bell-55');
                    writeTable(response, 5286, 'animas_table');
                    writeTable(response, 13771, 'vanoe_table');
                    writeTable(response, 6532, 'aldia_table');
                    writeTable(response, 5391, 'dorada_table');
                },
                error: function(error) {
                    demo.showNotification('top', 'center', error, 'tim-icons icon-bell-55');
                },
                complete: function(data) {
                    document.getElementById('points').disabled = false;
                    document.getElementById('points').innerHTML = "Buscar";
                }
            });
        });
        // Funcion para escribir los datos de puntos en las tablas
        function writeTable(response, id, name) {
            destruir_table(name);
            $(`#${name}`).find('tbody').empty();
            response.pointsadded.forEach(point => {
                let {
                    sale,
                    station,
                    station_id,
                    liters,
                    points,
                    concepto,
                    date
                } = point;
                if (station_id == id) {
                    $(`#${name}`).find('tbody').append( /* html */
                        `<tr>
                            <td>${sale}</td>
                            <td>${station}</td>
                            <td>${liters}</td>
                            <td>${points}</td>
                            <td>${concepto}&#170 suma</td>
                            <td>${date}</td>
                        </tr>`
                    );
                }
            });
            iniciar_date(name);
        }
    </script>
@endpush
