@extends('layouts.app')


@section('content')
    <div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center text-center bg-dark">
        <h1 class="title fw-bold text-white mb-3">Bienvenido a AVE</h1>
        <p class="subtitle text-white op-7">Un servicio de The Bildung Company</p>
    </div>

    <div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
        <div class="container container-login container-transparent animated fadeIn" style="display: block;">
            <h2 class="text-center">Iniciar sesión</h2>

            <div class="text-center">
                @if (session('status'))
                    <div class="alert alert-danger-register">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group"> <label for="email" class="placeholder"><b>Email</b></label>
                    <input id="email" placeholder="Email" type="email"
                        class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                        required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="placeholder"><b>Contraseña</b></label>
                    <div class="position-relative">
                        <input placeholder="Contraseña" id="password" name="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" required="">
                        <div class="show-password">
                            <i class="icon-eye"></i>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="form-group form-action-d-flex mb-3">
                    <button type="submit" class="btn btn-dark btn-round col-md-12 float-right mt-3 mt-sm-0 fw-bold">
                        Iniciar sesión
                    </button>
                </div>

            </form>
        </div>


    </div>

    <script>
        document.title = 'Inicio de sesión';
    </script>
@endsection

@section('js')
    <script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>
@endsection
