@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="panel-header bg-dark-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white op-7 mb-2">Estás viendo el curso {{ $course->name }}</h2>
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
                                <h3 class="card-title"><b>Eventos de {{ $course->name }} <b></h3>

                            </div>
                        </div>
                        <div class="card-body">
                            @if (isset($course->eventos[0]))
                                @include('school.courses.list_eventos')
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
                            <a href="{{ route('school.courses.list_eventos', ['id' => $course->id]) }}"
                                class='btn btn-success ml-auto'>Ver
                                todos</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Materias -->
                <div class="col-md-4">
                    <div class="card card-primary bg-primary-gradient">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center justify-content-center">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-book fa-3x"></i>
                                    </div>
                                </div>
                                <div class="col-9 text-right">
                                    <h5 class="card-category">Materias</h5>
                                    <h3 class="card-title">{{ count($course->materias) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('school.courses.list_materias', ['id' => $course->id]) }}"
                                class="btn btn-info btn-sm">Ver más</a>
                        </div>
                    </div>
                </div>

                <!-- Alumnos -->
                <div class="col-md-4">
                    <div class="card card-primary bg-primary-gradient">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center justify-content-center">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-users fa-3x"></i>
                                    </div>
                                </div>
                                <div class="col-9 text-right">
                                    <h5 class="card-category">Alumnos</h5>
                                    <h3 class="card-title">{{ count($course->students) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('school.courses.list_students', ['id' => $course->id]) }}"
                                class="btn btn-success btn-sm">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

        <script>
            $(document).ready(function() {
                $('#example').DataTable();
            });
        </script>
    @endsection
