@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="panel-header bg-dark-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white op-7 mb-2">Hola {{ Auth::user()->name }}! Bienvenido a AVE </h2>
                        <h4 class="text-white op-7 mb-2">Un servicio de The Bildung Company.</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary bg-primary-gradient">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h3 class="card-title"><b>Eventos (últimos 10).<b></h3>

                            </div>
                        </div>
                        <div class="card-body">
                            @if (isset($eventos[0]))
                                @include('school.eventos.index')
                            @else
                                <div class="row">
                                    <div class="col-md-4">
                                        <h1 class="card-title">No hay eventos.</h1>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('school.events.create') }}" class="btn btn-success">Cargar evento</a>
                            <a href="{{ route('school.events.view') }}" class='btn btn-success ml-auto'>Ver todos</a>

                        </div>
                    </div>
                </div>


            </div>


            <!-- FIN informar eventos-->

            <!-- Sección de cursos-->
            @include('school.courses.index')

            <!-- FIN Sección de cursos-->

        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#example').DataTable();
            });
        </script>
    @endsection
