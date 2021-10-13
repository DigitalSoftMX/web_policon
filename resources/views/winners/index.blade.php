@extends('layouts.app', ['pageSlug' => 'Elegir ganador', 'titlePage' => __('Gestión de ganadores')])

@section('content')

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
                                        @foreach ($winners['6532']['clients'] as $winner)
                                            {{-- {{ 'bg-primary' }} --}}
                                            <tr class="text-center">
                                                <td>{{ $winner->user->name }}</td>
                                                <td>{{ $winner->user->membership }}</td>
                                                <td>{{ $winner->qrs->where('station_id', 1)->sum('points') }}</td>
                                                <td>
                                                    @if ($stations->where('number_station', 6532)->first()->winner)
                                                        @if ($winner->winner)
                                                            <button class="btn btn-sm btn-primary">
                                                                {{ __('Entregar premio') }}
                                                            </button>
                                                        @else
                                                            <button type="submit" class="btn btn-sm"
                                                                disabled>{{ __('Elegir') }}</button>
                                                        @endif
                                                    @else
                                                        <form action="{{ route('selectwinner', [$winner, 6532]) }}"
                                                            method="post">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm">{{ __('Elegir') }}</button>
                                                        </form>
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
                                    @foreach ($winners['5391']['clients'] as $winner)
                                        <tr class="text-center">
                                            <td>{{ $winner->user->name }}</td>
                                            <td>{{ $winner->user->membership }}</td>
                                            <td>{{ $winner->qrs->where('station_id', 2)->sum('points') }}</td>
                                            <td>
                                                @if ($stations->where('number_station', 5391)->first()->winner)
                                                    <button type="submit" class="btn btn-sm"
                                                        disabled>{{ __('Elegir') }}</button>
                                                @else
                                                    <form action="{{ route('selectwinner', [$winner, 5391]) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-success btn-sm">{{ __('Elegir') }}</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
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
                                    @foreach ($winners['5286']['clients'] as $winner)
                                        <tr class="text-center">
                                            <td>{{ $winner->user->name }}</td>
                                            <td>{{ $winner->user->membership }}</td>
                                            <td>{{ $winner->qrs->where('station_id', 3)->sum('points') }}</td>
                                            <td>
                                                @if ($stations->where('number_station', 5286)->first()->winner)
                                                    <button type="submit" class="btn btn-sm"
                                                        disabled>{{ __('Elegir') }}</button>
                                                @else
                                                    <form action="{{ route('selectwinner', [$winner, 5286]) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-success btn-sm">{{ __('Elegir') }}</button>
                                                    </form>
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
                                        @foreach ($winners['13771']['clients'] as $winner)
                                            <tr class="text-center">
                                                <td>{{ $winner->user->name }}</td>
                                                <td>{{ $winner->user->membership }}</td>
                                                <td>{{ $winner->qrs->where('station_id', 4)->sum('points') }}</td>
                                                <td>
                                                    @if ($stations->where('number_station', 13771)->first()->winner)
                                                        <button type="submit" class="btn btn-sm"
                                                            disabled>{{ __('Elegir') }}</button>
                                                    @else
                                                        <form action="{{ route('selectwinner', [$winner, 13771]) }}"
                                                            method="post">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm">{{ __('Elegir') }}</button>
                                                        </form>
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
    </div>

@endsection
@push('app')
    <script>
        iniciar_date('datatable_4');
    </script>
@endpush
