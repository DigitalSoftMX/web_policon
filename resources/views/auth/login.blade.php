@extends('layouts.app', ['class' => 'login-page', 'page' => __('Inicio de Sesión'), 'contentClass' => 'login-page'])

@section('content')
    <div class="row pt-0 pb-0 justify-content-center">
        <div class="col-10 col-sm-4 mt-0 pl-0 pr-0">
            <form class="form " method="post" action="{{ route('login') }}">
                @csrf
                <div class="card p-0 m-0 bg-transparent" style="height: 100vh !important">
                    <div class="col mt-5">
                        <div class="card p-0 m-0 mt-5">
                            <div class="card-header p-0 mb-0">
                                <div class="row justify-content-center mb-4">
                                    <div class="col-sm-12 mt-5">
                                        <img class="mx-auto d-block mt-5" src="{{ asset('white') }}/img/mobil-logo.png" alt=""
                                            style="width: 30% !important">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-sm-9">
                                        <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-white">
                                                    <i class="tim-icons icon-email-85"></i>
                                                </div>
                                            </div>
                                            <input type="email" name="email"
                                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} bg-white"
                                                placeholder="{{ __('Correo electrónico') }}" value="{{ old('email') }}">
                                            @include('alerts.feedback', ['field' => 'email'])
                                        </div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-white">
                                                    <i class="tim-icons icon-lock-circle"></i>
                                                </div>
                                            </div>
                                            <input type="password" placeholder="{{ __('Contraseña') }}" name="password"
                                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} bg-white"
                                                value="{{ old('password') }}">
                                            @include('alerts.feedback', ['field' => 'password'])
                                        </div>
                                    </div>
                                    <div class="col-sm-8 text-center mt-3">
                                        <button type="submit" href=""
                                            class="btn btn-primary">{{ __('Iniciar sesión') }}</button>
                                        <div class="pull-right">
                                            <h6>
                                                <a href="{{ route('password.request') }}"
                                                    class="link footer-link text-primary">{{ __('¿Has olvidado tu contraseña?') }}</a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        {{-- <div class="col-sm-8 mt-0 p-0 bg-white justify-content-center">
            <img class="mx-auto d-block p-0 m-0" src="{{ asset('white') }}/img/svg/segunda.svg" alt=""
                style="height: 100vh !important">
        </div> --}}
    </div>

@endsection
