@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://www.markuptag.com/bootstrap/5/css/bootstrap.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
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
                                <div class="form-group row row-remeber-forgot">

                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
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
