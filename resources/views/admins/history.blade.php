@extends('layouts.app', ['pageSlug' => 'Historial', 'titlePage' => __('Historial de movimientos')])

@section('content')
    {{-- <ul class="nav nav-pills nav-pills-success nav-pills-icons row" role="tablist">
        <li class="nav-item col-sm-6">
            <a class="nav-link active" href="#dashboard-1" role="tab" data-toggle="tab">
                {{ __('Tickets') }}
            </a>
        </li>
        <li class="nav-item col-sm-6">
            <a class="nav-link" href="#schedule-1" role="tab" data-toggle="tab">
                {{ __('Canjes') }}
            </a>
        </li>
    </ul> --}}
    <div class="card mt-4 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-2">
                    <label class="label-control">{{ __('Fecha de inicio') }}</label>
                    <input class="form-control datetimepicker" id="input-date-ini" name="input-date-ini" type="text" value=""
                        placeholder="Fecha">
                </div>
                <div class="form-group col-sm-2">
                    <label class="label-control">{{ __('Fecha de fin') }}</label>
                    <input class="form-control datetimepicker" id="input-date-end" name="input-date-end" type="text" value=""
                        placeholder="Fecha">
                </div>
                <div class="form-group col-sm-2">
                    <label for="folio">{{ __('Folio') }}</label>
                    <input type="number" class="form-control" name="folio" id="folio" aria-required="true"
                        aria-describedby="folioHelp" placeholder="Folio" aria-required="true">
                </div>
                <div class="form-group col-sm-2">
                    <label for="membresia">{{ __('membresia') }}</label>
                    <input type="text" class="form-control" name="membresia" id="membresia" aria-required="true"
                        aria-describedby="memnbresiaHelp" placeholder="Membresia" aria-required="true">
                </div>
                <div class="form-group mt-3 col-sm-2">
                    <button id="btnHistory" type="submit" class="btn btn-blue"
                        onClick="desabilitarBoton('btnHistory')">{{ __('Buscar') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content tab-space">
        <div class="tab-pane active" id="dashboard-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="datatable_1">
                                    <thead class=" text-primary">
                                        <th>{{ __('Membresía') }}</th>
                                        <th>{{ __('Ticket') }}</th>
                                        <th>{{ __('Puntos') }}</th>
                                        <th>{{ __('Litros') }}</th>
                                        <th>{{ __('Producto') }}</th>
                                        <th>{{ __('Estación') }}</th>
                                        <th>{{ __('Fecha y hora') }}</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="tab-pane" id="schedule-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="datatable_2">
                                    <thead class=" text-primary">
                                        <th>{{ __('Folio') }}</th>
                                        <th>{{ __('Estación') }}</th>
                                        <th>{{ __('Membresía') }}</th>
                                        <th>{{ __('Puntos') }}</th>
                                        <th>{{ __('Autorizado por') }}</th>
                                        <th>{{ __('Fecha y hora') }}</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

@endsection

@push('js')
    <script>
        let station = "{{ $station ?? '' }}";
        $(document).ready(function() {
            init_calendar('input-date-ini', `{{ $start }}`, `{{ $end }}`);
            init_calendar('input-date-end', `{{ $start }}`, `{{ $end }}`);
        });
        $("#btnHistory").click(function() {
            let data = {
                'start': $('#input-date-ini').val(),
                'end': $('#input-date-end').val(),
                'folio': $('#folio').val(),
                'membresia': $('#membresia').val(),
            };
            station !== '' ? data.station = station : data;
            $.ajax({
                url: "{{ route('get.history') }}",
                type: 'GET',
                dataType: 'json',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    demo.showNotification('top', 'center', 'Consulta realizada correctamente.',
                        'tim-icons icon-bell-55');
                    console.log(response);
                    destruir_table("datatable_1");
                    destruir_table("datatable_2");
                    $('#datatable_1').find('tbody').empty();
                    // $('#datatable_2').find('tbody').empty();
                    /* for (i = 0; i < response.points.length; i++) {
                        $("#datatable_1").find('tbody').append(
                            '<tr><td>' + response.points[i].membership + '</td><td>' + response
                            .points[i].sale + '</td><td>' + response.points[i].points +
                            '</td><td>' + response.points[i].liters + '</td><td>' + response.points[
                                i].gasoline + '</td><td>' + response.points[i].station +
                            '</td><td>' + response.points[i].date + '</td></tr>'
                        );
                    } */
                    response.points.forEach(point => {
                        $("#datatable_1").find('tbody').append( /* html */ `
                            <tr>
                                <td>${point.membership}</td>
                                <td>${point.sale}</td>
                                <td>${point.points}</td>
                                <td>${point.liters}</td>
                                <td>${point.gasoline}</td>
                                <td>${point.station}</td>
                                <td>${point.date}</td>
                            </tr>
                        `);
                    });
                    /* for (i = 0; i < response.exchanges.length; i++) {

                        $("#datatable_2").find('tbody').append(
                            '<tr><td>' + response.exchanges[i].folio + '</td><td>' + response
                            .exchanges[i].station + '</td><td>' + response.exchanges[i].membership +
                            '</td><td>' + response.exchanges[i].points + '</td><td>' + response
                            .exchanges[i].admin + '</td><td>' + response.exchanges[i].date +
                            '</td></tr>'
                        );
                    } */
                    iniciar_date('datatable_1');
                    // iniciar_date('datatable_2');
                },
                error: function(error) {
                    demo.showNotification('top', 'center', error, 'tim-icons icon-bell-55');
                }
            });
        });
    </script>
@endpush
