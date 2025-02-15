@extends('layouts.app_system')

@section('content')
    <div class="content">
        <!-- Header de Bienvenida -->
        <div class="panel-header bg-dark-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white op-7 mb-2">Hola {{ Auth::user()->name }}! Bienvenido a AVE </h2>
                        <h6 class="text-white op-7 mb-2">Un servicio de The Bildung Company.</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-inner mt--5">

            <!-- Sección de Eventos Recientes -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card bg-primary-gradient">
                        <div class="card-header">
                            <h3 class="card-title text-white"><b>Últimos 10 Eventos</b></h3>
                        </div>
                        <div class="card-body">

                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('school.events.view') }}" class="btn btn-light">Ver todos</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de Cursos y Comunicados -->
            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endsection
