@extends('layouts.app', ['pageSlug' => 'Elegir ganador', 'titlePage' => __('Gestión de ganadores')])

@section('content')
    <div class="row mb-2">
        <div class="col-3">
            @if ($seePeriod)
                @isset($currentPeriod)
                    <form class="form" id="finish" action="{{ route('periods.update', $currentPeriod) }}"
                        method="POST">
                        @method('put')
                        @csrf
                        <button type="button" class="btn btn-danger"
                            onclick="confirm('¿Esta seguro que desea finalizar el periodo?')?document.getElementById('finish').submit() : '';">
                            {{ __('Finalizar periodo') }}
                        </button>
                    </form>
                @endisset
            @else
                <button class="btn btn-dark" disabled>
                    {{ __('Finalizar periodo') }}
                </button>
            @endif
        </div>
    </div>
    <ul class="nav nav-pills nav-pills-info nav-pills-icons row" role="tablist">
        <li class="nav-item col-sm-3">
            <a class="nav-link active" href="#AldiaCholula" role="tab" data-toggle="tab">
                {{ __('Aldía Cholula') }}
            </a>
        </li>
        <li class="nav-item col-sm-3">
            <a class="nav-link" href="#AldiaDorada" role="tab" data-toggle="tab">
                {{ __('Aldía Dorada') }}
            </a>
        </li>
        <li class="nav-item col-sm-3">
            <a class="nav-link" href="#Animas" role="tab" data-toggle="tab">
                {{ __('Las Ánimas') }}
            </a>
        </li>
        <li class="nav-item col-sm-3">
            <a class="nav-link" href="#Vanoe" role="tab" data-toggle="tab">
                {{ __('Vanoe') }}
            </a>
        </li>
    </ul>

    <div class="tab-content tab-space">
        <div class="tab-pane active" id="AldiaCholula">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="datatable_1">
                                    <thead class="text-primary text-center">
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('Membresía') }}</th>
                                        <th>{{ __('Puntos') }}</th>
                                        <th>{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($winners[$stations[0]->number_station]['clients'] as $client)
                                            <tr class="text-center">
                                                <td>
                                                    {{ "{$client->user->name} {$client->user->first_surname} {$client->user->second_surname}" }}
                                                </td>
                                                <td>{{ $client->user->membership }}</td>
                                                <td>
                                                    {{ $client->puntos->where('station_id', $stations[0]->id)->first()->points }}
                                                </td>
                                                <td>
                                                    @if ($currentPeriod->winner)
                                                        <a href="{{ route('clients.points', $client) }}"
                                                            class="btn btn-blue btn-sm">{{ __('Movimientos') }}
                                                        </a>
                                                    @else
                                                        @if ($client->winner)
                                                            <a rel="tooltip" class="btn btn-primary btn-link"
                                                                href="{{ route('clients.edit', $client->user) }}"
                                                                data-original-title="" title="Ver el cliente">
                                                                <i class="fas fa-exclamation-circle"></i>
                                                            </a>
                                                        @else
                                                            @if (!$currentPeriod->winner)
                                                                <button class="btn btn-blue btn-sm" disabled>
                                                                    {{ __('Ganador') }}
                                                                </button>
                                                            @else
                                                                <form
                                                                    action="{{ route('selectwinner', [$client, $stations[0]->number_station]) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-blue btn-sm">{{ __('Ganador') }}</button>
                                                                </form>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="AldiaDorada">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="datatable_2">
                                    <thead class="text-primary text-center">
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('Membresía') }}</th>
                                        <th>{{ __('Puntos') }}</th>
                                        <th>{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($winners[$stations[3]->number_station]['clients'] as $client)
                                            <tr class="text-center">
                                                <td>
                                                    {{ "{$client->user->name} {$client->user->first_surname} {$client->user->second_surname}" }}
                                                </td>
                                                <td>{{ $client->user->membership }}</td>
                                                <td>
                                                    {{ $client->puntos->where('station_id', $stations[3]->id)->first()->points }}
                                                </td>
                                                <td>
                                                    @if ($currentPeriod->winner)
                                                        <a href="{{ route('clients.points', $client) }}"
                                                            class="btn btn-blue btn-sm">{{ __('Movimientos') }}
                                                        </a>
                                                    @else
                                                        @if ($client->winner)
                                                            <a rel="tooltip" class="btn btn-primary btn-link"
                                                                href="{{ route('clients.edit', $client->user) }}"
                                                                data-original-title="" title="Ver el cliente">
                                                                <i class="fas fa-exclamation-circle"></i>
                                                            </a>
                                                        @else
                                                            @if (!$currentPeriod->winner)
                                                                <button class="btn btn-blue btn-sm" disabled>
                                                                    {{ __('Ganador') }}
                                                                </button>
                                                            @else
                                                                <form
                                                                    action="{{ route('selectwinner', [$client, $stations[3]->number_station]) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-blue btn-sm">{{ __('Ganador') }}</button>
                                                                </form>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="Animas">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="datatable_3">
                                    <thead class="text-primary text-center">
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('Membresía') }}</th>
                                        <th>{{ __('Puntos') }}</th>
                                        <th>{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($winners[$stations[2]->number_station]['clients'] as $client)
                                            <tr class="text-center">
                                                <td>
                                                    {{ "{$client->user->name} {$client->user->first_surname} {$client->user->second_surname}" }}
                                                </td>
                                                <td>{{ $client->user->membership }}</td>
                                                <td>
                                                    {{ $client->puntos->where('station_id', $stations[2]->id)->first()->points }}
                                                </td>
                                                <td>
                                                    @if (!($currentPeriod->winner ?? true))
                                                        <a href="{{ route('clients.points', $client) }}"
                                                            class="btn btn-blue btn-sm">{{ __('Movimientos') }}
                                                        </a>
                                                    @else
                                                        @if ($client->winner)
                                                            <a rel="tooltip" class="btn btn-primary btn-link"
                                                                href="{{ route('clients.edit', $client->user) }}"
                                                                data-original-title="" title="Ver el cliente">
                                                                <i class="fas fa-exclamation-circle"></i>
                                                            </a>
                                                        @else
                                                            {{ $currentPeriod->winner }}
                                                            @if ($currentPeriod->winner ?? true)
                                                                <button class="btn btn-blue btn-sm" disabled>
                                                                    {{ __('Ganador') }}
                                                                </button>
                                                            @else
                                                                <form
                                                                    action="{{ route('selectwinner', [$client, $stations[2]->number_station]) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-blue btn-sm">{{ __('Ganador') }}</button>
                                                                </form>
                                                            @endif
                                                        @endif
                                                    @endif
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

        <div class="tab-pane" id="Vanoe">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="datatable_4">
                                    <thead class="text-primary text-center">
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('Membresía') }}</th>
                                        <th>{{ __('Puntos') }}</th>
                                        <th>{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($winners[$stations[1]->number_station]['clients'] as $client)
                                            <tr class="text-center">
                                                <td>
                                                    {{ "{$client->user->name} {$client->user->first_surname} {$client->user->second_surname}" }}
                                                </td>
                                                <td>{{ $client->user->membership }}</td>
                                                <td>
                                                    {{ $client->puntos->where('station_id', $stations[1]->id)->first()->points }}
                                                </td>
                                                <td>
                                                    @if ($currentPeriod->winner)
                                                        <a href="{{ route('clients.points', $client) }}"
                                                            class="btn btn-blue btn-sm">{{ __('Movimientos') }}
                                                        </a>
                                                    @else
                                                        @if ($client->winner)
                                                            <a rel="tooltip" class="btn btn-primary btn-link"
                                                                href="{{ route('clients.edit', $client->user) }}"
                                                                data-original-title="" title="Ver el cliente">
                                                                <i class="fas fa-exclamation-circle"></i>
                                                            </a>
                                                        @else
                                                            @if (!$currentPeriod->winner)
                                                                <button class="btn btn-blue btn-sm" disabled>
                                                                    {{ __('Ganador') }}
                                                                </button>
                                                            @else
                                                                <form
                                                                    action="{{ route('selectwinner', [$client, $stations[1]->number_station]) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-blue btn-sm">{{ __('Ganador') }}</button>
                                                                </form>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('app')
    <script>
        iniciar_date('datatable_4');
    </script>
@endpush
