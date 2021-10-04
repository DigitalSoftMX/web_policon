@extends('layouts.app', ['pageSlug' => 'Estaciones', 'titlePage' => __('Gestión de estaciones')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 mx-auto d-block mt-3">
                    <form method="post" action="{{ route('stations.update', $station) }}" autocomplete="off"
                        class="form-horizontal" enctype="multipart/form-data">
                        @method('patch')
                        @include('stations.station',[$btn='Actualizar'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
