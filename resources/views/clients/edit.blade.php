@extends('layouts.app', ['pageSlug' => 'Clientes', 'titlePage' => __('Gestión de clientes')])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 mx-auto d-block mt-3">
                    <form method="post" action="{{ route('clients.update', $user) }}" autocomplete="off"
                        class="form-horizontal">
                        @csrf
                        @method('PUT')
                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">
                                    <a href="{{ route('clients.index') }}" title="Buscar un usuario" class="h4"
                                    {{-- <a href="{{ URL::previous() }}" title="Buscar un usuario" class="h4" --}}
                                        title="Buscar un usuario">
                                        <i class="tim-icons icon-minimal-left"></i>
                                    </a>
                                    {{ __('Editar Cliente') }}
                                    <p class="card-category"></p>
                                </h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="name">{{ __('Nombre') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            id="input-name" aria-describedby="nameHelp" placeholder="Escribe un nombre"
                                            value="{{ old('name', $user->name) }}" required="true" aria-required="true"
                                            name="name">
                                        @if ($errors->has('name'))
                                            <span id="name-error" class="error text-danger" for="input-name">
                                                {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div
                                        class="form-group{{ $errors->has('first_surname') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="first_surname">{{ __('Apellido Paterno') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('first_surname') ? ' is-invalid' : '' }}"
                                            name="first_surname" id="input-first_surname" type="text"
                                            value="{{ old('first_surname', $user->first_surname) }}" required="true"
                                            aria-required="true" aria-describedby="first_surnameHelp"
                                            placeholder="Escribe el primer apellido" required="true" aria-required="true">
                                        @if ($errors->has('first_surname'))
                                            <span id="first_surname-error" class="error text-danger"
                                                for="input-first_surname">
                                                {{ $errors->first('first_surname') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div
                                        class="form-group{{ $errors->has('second_surname') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="second_surname">{{ __('Apellido Materno') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('second_surname') ? ' is-invalid' : '' }}"
                                            name="second_surname" id="input-second_surname" type="text"
                                            value="{{ old('second_surname', $user->second_surname) }}" required="true"
                                            aria-required="true" aria-describedby="second_surnameHelp"
                                            placeholder="Escribe el segundo apellido" required="true" aria-required="true">
                                        @if ($errors->has('second_surname'))
                                            <span id="second_surname-error" class="error text-danger"
                                                for="input-second_surname">{{ $errors->first('second_surname') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="phone">{{ __('Teléfono') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                            id="input-phone" aria-describedby="phoneHelp" placeholder="Escribe un telefono"
                                            value="{{ old('phone', $user->phone) }}" required="true" aria-required="true"
                                            name="phone">
                                        @if ($errors->has('phone'))
                                            <span id="phone-error" class="error text-danger" for="input-phone">
                                                {{ $errors->first('phone') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mt-3">

                                    <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }} col-sm-4">
                                        <label for="address">{{ __('Dirección') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                            name="address" id="input-address" type="text"
                                            value="{{ old('address', $user->client->address) }}" required="true"
                                            aria-required="true" aria-describedby="addressHelp"
                                            placeholder="Escribe la dirección del usuario" required="true"
                                            aria-required="true">
                                        @if ($errors->has('address'))
                                            <span id="address-error" class="error text-danger" for="input-address">
                                                {{ $errors->first('address') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('birthdate') ? ' has-danger' : '' }} col-sm-4">
                                        <label for="birthdate">{{ __('Fecha de nacimiento') }}</label>
                                        <input type="birthdate"
                                            class="form-control{{ $errors->has('birthdate') ? ' is-invalid' : '' }}"
                                            name="birthdate" id="input-birthdate" type="text"
                                            aria-describedby="birthdateHelp" placeholder="Escribe la fecha de nacimiento"
                                            value="{{ old('birthdate', $user->client->birthdate) }}">
                                        @if ($errors->has('birthdate'))
                                            <span id="birthdate-error" class="error text-danger" for="input-birthdate">
                                                {{ $errors->first('birthdate') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('sex') ? ' has-danger' : '' }} col-sm-4">
                                        <label for="input-sex">{{ __('Género') }}</label>
                                        <select id="input-sex" name="sex"
                                            class="selectpicker show-menu-arrow{{ $errors->has('sex') ? ' is-invalid' : '' }}"
                                            data-style="btn-primary" data-width="100%">
                                            <option value="H" @if ($user->client->sex == 'H')selected @endif>
                                                {{ __('H') }}
                                            </option>
                                            <option value="M" @if ($user->client->sex == 'M')selected @endif>
                                                {{ __('M') }}
                                            </option>
                                        </select>
                                    </div>

                                </div>

                                <div class="row mt-3">

                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} col-sm-4">
                                        <label for="email">{{ __('Email') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="email" id="input-email" type="text"
                                            value="{{ old('email', $user->email) }}" required="true" aria-required="true"
                                            aria-describedby="emailHelp" placeholder="Escribe el email del usuario"
                                            required="true" aria-required="true">
                                        @if ($errors->has('email'))
                                            <span id="email-error" class="error text-danger" for="input-email">
                                                {{ $errors->first('email') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }} col-sm-4">
                                        <label for="password">{{ __('Contraseña') }}</label>
                                        <input type="password"
                                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            name="password" id="input-password" type="text" aria-describedby="passwordHelp"
                                            placeholder="Escribe la nueva contraseña">
                                        @if ($errors->has('password'))
                                            <span id="password-error" class="error text-danger" for="input-password">
                                                {{ $errors->first('password') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="password_confirmation">{{ __('Confirmar contraseña') }}</label>
                                        <input type="password" class="form-control" id="input-password_confirmation"
                                            aria-describedby="phoneHelp" placeholder="Confirmar contraseña"
                                            name="password_confirmation">
                                    </div>

                                </div>

                                <div class="card-footer ml-auto mr-auto mt-5 text-center">
                                    <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
