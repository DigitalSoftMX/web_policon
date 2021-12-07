@extends('layouts.app', ['pageSlug' => 'Elegir ganador', 'titlePage' => __('Gestión de ganadores')])

@section('content')
    <div class="row mb-2">
        <div class="col-3">
            @if (!$currentPeriod or $currentPeriod->finish)
                <button class="btn btn-dark" disabled>{{ __('Finalizar periodo') }}</button>
            @else
                <form class="form" id="finish" action="{{ route('periods.update', $currentPeriod) }}"
                    method="POST">
                    @method('put')
                    @csrf
                    <button type="button" class="btn btn-danger"
                        onclick="confirm('¿Esta seguro que desea finalizar el periodo?')?document.getElementById('finish').submit() : '';">
                        {{ __('Finalizar periodo') }}
                    </button>
                </form>
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
            @include('winners.winnerstable',[$station=$stations[0],$id=1])
        </div>

        <div class="tab-pane" id="AldiaDorada">
            @include('winners.winnerstable',[$station=$stations[3],$id=2])
        </div>

        <div class="tab-pane" id="Animas">
            @include('winners.winnerstable',[$station=$stations[2],$id=3])
        </div>

        <div class="tab-pane" id="Vanoe">
            @include('winners.winnerstable',[$station=$stations[1],$id=4])
        </div>
    </div>

@endsection
@push('app')
    <script>
        iniciar_date('datatable_4');
    </script>
@endpush
