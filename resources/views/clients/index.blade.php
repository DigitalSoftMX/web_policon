@extends('layouts.app', ['pageSlug' => 'Clientes', 'titlePage' => __('Gestión de clientes')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Clientes') }}</h4>
                            <p class="card-category"> {{ __('Aquí puedes administrar a los clientes.') }}</p>
                            {{-- <h4 class="card-title">
                                <a href="{{ route('clients.index') }}" title="Regresar a la lista" class="h4">
                                    <i class="tim-icons icon-minimal-left"></i>
                                </a>
                                {{ __('Buscar un usuario') }}
                            </h4> --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="usuarios">
                                    <thead class=" text-primary">
                                        <th>{{ __('Membresía') }}</th>
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('Apellidos') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Puntos') }}</th>
                                        <th class="text-right">{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->membership }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ "{$user->first_surname} {$user->second_surname}" }}
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->client->puntos->sum('points') }} Pts</td>
                                                <td class="td-actions text-right">
                                                    <div class="row justify-content-center">
                                                        <div class="col-sm-2 mt-0">
                                                            <a rel="tooltip" class="btn btn-primary btn-link"
                                                                href="{{ route('clients.edit', $user) }}"
                                                                data-original-title="" title="">
                                                                <i class="tim-icons icon-pencil"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-sm-2 mt-0">
                                                            @isset($user->client)
                                                                <a rel="tooltip" class="btn btn-success btn-link"
                                                                    href="{{ route('clients.points', $user->client) }}"
                                                                    data-original-title="" title="">
                                                                    <i class="tim-icons icon-tag"></i>
                                                                </a>
                                                            @endisset
                                                        </div>
                                                    </div>
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
