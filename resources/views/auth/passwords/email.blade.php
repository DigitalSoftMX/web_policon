@extends('layouts.app', ['class' => 'login-page', 'page' => __(''), 'contentClass' => 'login-page'])

@section('content')
    <div class="row pt-0 pb-0 bg-primary justify-content-center">
        <div class="col-sm-4 mt-0 pl-0 pr-0" >
            <form class="form " method="post" action="{{ route('password.email') }}">
                @csrf
                <div class="card bg-primary p-0 m-0" style="height: 100vh !important">
                    <div class="mt-5 ml-5 mr-5">
                        <div class="mt-5">
                            <div class="mx-auto d-block col-sm-8 mt-5">
                                <h3  class="text-white">RESTABLECER CONTRASEÑA</h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-5">
                        <div class="col-sm-8 mx-auto d-block">
                            <div class="form-group">
                                <label for="email" class="text-white">{{ __('Correo electrónico') }}</label>
                                <div >
                                    <input id="email"type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} bg-white" placeholder="{{ __('Email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <button type="submit"  class="btn btn-simple btn-white">
                                        {{ __('Enviar enlace de recuperación') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
