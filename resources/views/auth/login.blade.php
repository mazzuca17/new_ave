@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://www.markuptag.com/bootstrap/5/css/bootstrap.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-adminpanel">
                    <div class="card-title title-options row justify-content-center" style="background-color: transparent;">
                        <h4> <b>Iniciar sesión</b> </h4>
                    </div>
                    <hr>
                    <div class="card-body" style="margin-top: -30px">
                        <div class="text-center">
                            @if (session('status'))
                                <div class="alert alert-danger-register">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>

                        <div class="login-form mt-4 p-4">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group row justify-content-center">
                                    <div class="col-md-9">
                                        <input id="email" placeholder="Email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <div class="col-md-9">
                                        <input placeholder="Contraseña" id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                                        @if (Route::has('password.request'))
                                            <span>
                                                <a href="{{ route('password.request') }}"
                                                    tabindex="0">{{ __('¿Olvidaste tu contraseña?') }}</a>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row justify-content-center" style="text-align: center">
                                    <div class="col-md-9">
                                        <button type="submit" class="btn btn-login btn-lg btn-block mt-3">
                                            {{ __('Iniciar sesión') }}
                                        </button>
                                    </div>
                                </div>



                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.title = 'Inicio de sesión';
    </script>
@endsection

@section('js')
    <script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>
@endsection
