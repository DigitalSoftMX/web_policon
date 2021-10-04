@csrf
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            <a href="{{ route('stations.index') }}" title="Regresar a la lista" class="h4">
                <i class="tim-icons icon-minimal-left"></i>
            </a>
            {{ __((isset($btn) ? 'Editar' : 'Registrar') . ' estación') }}
        </h4>
        <p class="card-category"></p>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6">
                <label for="name">{{ __('Nombre de la estación') }}</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="input-name"
                    aria-describedby="nameHelp" placeholder="Escribe el nombre de la estación"
                    value="{{ old('name', $station->name ?? '') }}" aria-required="true" name="name">
                @if ($errors->has('name'))
                    <span id="name-error" class="error text-danger" for="input-name">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }} col-sm-6">
                <label for="address">{{ __('Dirección de la estación') }}</label>
                <input type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                    id="input-name" aria-describedby="nameHelp" placeholder="Escribe la dirección de la estación"
                    value="{{ old('address', $station->address ?? '') }}" aria-required="true" name="address">
                @if ($errors->has('address'))
                    <span id="name-error" class="error text-danger" for="input-name">
                        {{ $errors->first('address') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }} col-sm-6">
                <label for="phone">{{ __('Teléfono') }}</label>
                <input type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                    id="input-phone" aria-describedby="phoneHelp" placeholder="Escribe el teléfono"
                    value="{{ old('phone', $station->phone ?? '') }}" aria-required="true" name="phone">
                @if ($errors->has('phone'))
                    <span id="phone-error" class="error text-danger" for="input-phone">
                        {{ $errors->first('phone') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} col-sm-6">
                <label for="email">{{ __('Email') }}</label>
                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                    id="input-email" type="email" value="{{ old('email', $station->email ?? '') }}"
                    aria-required="true" aria-describedby="emailHelp" placeholder="Escribe el email de la estación"
                    aria-required="true">
                @if ($errors->has('email'))
                    <span id="email-error" class="error text-danger" for="input-email">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row mt-3">
            <div class="form-group{{ $errors->has('number_station') ? ' has-danger' : '' }} col-sm-6">
                <label for="number_station">{{ __('Número de la estación') }}</label>
                <input type="number" class="form-control{{ $errors->has('number_station') ? ' is-invalid' : '' }}"
                    id="input-name" aria-describedby="nameHelp" placeholder="Escribe el número de la estación"
                    value="{{ old('number_station', $station->number_station ?? '') }}" aria-required="true"
                    name="number_station">
                @if ($errors->has('number_station'))
                    <span id="name-error" class="error text-danger" for="input-name">
                        {{ $errors->first('number_station') }}
                    </span>
                @endif
            </div>
            <div class="col-sm-6">
                <label>{{ __('Subir imagen') }}</label>
                <input type="file" name="station" id="" accept="image/*">
                @if ($errors->has('station'))
                    <span id="text-station" class="error text-danger" for="input-station">
                        {{ $errors->first('station') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            @isset($station)
                <img src="{{ asset($station->image ?? '') }}" alt="" height="150">
            @endisset
        </div>
        <div class="card-footer ml-auto mr-auto mt-5 text-center">
            <button type="submit" class="btn btn-primary">{{ $btn ?? __('Registrar') }}</button>
        </div>
    </div>
</div>
