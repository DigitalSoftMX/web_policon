@csrf
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            <a href="{{ URL::previous() }}" title="Regresar a la lista" class="h4">
                <i class="tim-icons icon-minimal-left"></i>
            </a>
            {{ __(($button ? 'Editar' : 'Agregar') . ' administrador') }}
        </h4>
        <p class="card-category"></p>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6">
                <label for="name">{{ __('Nombre') }}</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="input-name"
                    aria-describedby="nameHelp" placeholder="Escribe un nombre"
                    value="{{ old('name', $admin->name ?? '') }}" aria-required="true" name="name">
                @if ($errors->has('name'))
                    <span id="name-error" class="error text-danger" for="input-name">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('first_surname') ? ' has-danger' : '' }} col-sm-6">
                <label for="first_surname">{{ __('Apellido Paterno') }}</label>
                <input type="text" class="form-control{{ $errors->has('first_surname') ? ' is-invalid' : '' }}"
                    name="first_surname" id="input-first_surname"
                    value="{{ old('first_surname', $admin->first_surname ?? '') }}" aria-required="true"
                    aria-describedby="first_surnameHelp" placeholder="Escribe el primer apellido" aria-required="true">
                @if ($errors->has('first_surname'))
                    <span id="first_surname-error" class="error text-danger" for="input-first_surname">
                        {{ $errors->first('first_surname') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="form-group{{ $errors->has('second_surname') ? ' has-danger' : '' }} col-sm-6">
                <label for="first_surname">{{ __('Apellido Materno') }}</label>
                <input type="text" class="form-control{{ $errors->has('second_surname') ? ' is-invalid' : '' }}"
                    name="second_surname" id="input-second_surname"
                    value="{{ old('second_surname', $admin->second_surname ?? '') }}" aria-required="true"
                    aria-describedby="second_surnameHelp" placeholder="Escribe el segundo apellido"
                    aria-required="true">
                @if ($errors->has('second_surname'))
                    <span id="second_surname-error" class="error text-danger"
                        for="input-second_surname">{{ $errors->first('second_surname') }}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }} col-sm-6">
                <label for="phone">{{ __('Teléfono') }}</label>
                <input type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                    id="input-phone" aria-describedby="phoneHelp" placeholder="Escribe el teléfono"
                    value="{{ old('phone', $admin->phone ?? '') }}" aria-required="true" name="phone">
                @if ($errors->has('phone'))
                    <span id="phone-error" class="error text-danger" for="input-phone">
                        {{ $errors->first('phone') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} col-sm-6">
                <label for="email">{{ __('Email') }}</label>
                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                    id="input-email" type="email" value="{{ old('email', $admin->email ?? '') }}"
                    aria-required="true" aria-describedby="emailHelp" placeholder="Escribe el email del usuario"
                    aria-required="true">
                @if ($errors->has('email'))
                    <span id="email-error" class="error text-danger" for="input-email">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }} col-sm-6">
                <label for="password">{{ __('Contraseña') }}</label>
                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                    id="input-password" type="password" aria-describedby="passwordHelp"
                    placeholder="Escribe la contraseña">
                @if ($errors->has('password'))
                    <span id="password-error" class="error text-danger" for="input-password">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="form-group col-sm-6">
                <label for="password_confirmation">{{ __('Confirmar contraseña') }}</label>
                <input type="password" class="form-control" id="input-password_confirmation"
                    aria-describedby="passwordHelp" placeholder="Confirmar contraseña" name="password_confirmation">
            </div>
            <div class="form-group{{ $errors->has('rol') ? ' has-danger' : '' }} col-sm-6">
                <label for="input-rol">{{ __('Rol') }}</label>
                <select id="input-rol" name="rol"
                    class="selectpicker show-menu-arrow{{ $errors->has('rol') ? ' is-invalid' : '' }}"
                    data-style="btn-primary" data-live-search="true" data-width="100%">
                    <option disabled>{{ __('Elija una opción') }}</option>
                    @switch(auth()->user()->roles->first()->name)
                        @case('admin_master')
                            @foreach ($roles as $rol)
                                @if (isset($admin))
                                    <option value="{{ $rol->id }}" @if (($u = $admin->roles->first()->id) == $rol->id) selected @endif>{{ $rol->description }}
                                    </option>
                                @else
                                    <option value="{{ $rol->id }}">{{ $rol->description }}</option>
                                @endif
                            @endforeach
                        @break
                        @case('admin_eucomb')
                            @foreach ($roles as $rol)
                                @if ($rol->description != 'admin_master')
                                    @if (isset($admin))
                                        <option value="{{ $rol->id }}" @if (($u = $admin->roles->first()->id) == $rol->id) selected @endif>
                                            {{ $rol->description }}
                                        </option>
                                    @else
                                        <option value="{{ $rol->id }}">{{ $rol->description }}</option>
                                    @endif
                                @endif
                            @endforeach
                        @break
                    @endswitch
                </select>
            </div>

        </div>
        <div class="row mt-3">
            <div class="form-group{{ $errors->has('station_id') ? ' has-danger' : '' }} col-sm-6">
                <label for="input-station_id">{{ __('Estación') }}</label>
                <select id="input-station_id" name="station_id"
                    class="selectpicker show-menu-arrow {{ $errors->has('station_id') ? ' has-danger' : '' }}"
                    data-style="btn-primary" data-width="100%" data-live-search="true">
                    <option value="">{{ __('Elija una opción') }}</option>
                    @foreach ($stations as $station)
                        <option value="{{ $station->id }}" @if (($s = $admin->admin->station_id ?? '') == $station->id) selected @endif>{{ $station->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-footer ml-auto mr-auto mt-5 text-center">
            <button type="submit" class="btn btn-primary">{{ $button ?? 'Guardar' }}</button>
        </div>
    </div>
</div>
