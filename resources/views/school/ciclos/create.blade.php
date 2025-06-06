@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Crear ciclo lectivo.</h4>

            </div>


            <div class="row">
                <div class="col-md-8 ml-auto mr-auto">
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if (Session::has('danger'))
                        <div class="alert alert-danger">
                            {{ Session::get('danger') }}
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Crear ciclo lectivo
                                <i class="fas fa-info-circle text-info ml-2" data-toggle="tooltip" data-placement="right"
                                    title="Una vez creado, el ciclo se activará automáticamente en la fecha de inicio."></i>
                            </div>
                        </div>



                        <form action="{{ route('school.ciclos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-lg-4">

                                    </div>
                                    <div class="col-md-12">

                                        <div class="form-group form-group-default">
                                            <label>Nombre del ciclo lectivo</label>
                                            <input id="Name" type="text" class="form-control"
                                                placeholder="Nombre del ciclo lectivo" name="name" required>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label for="comment">Fecha de inicio</label>
                                            <input id="Name" type="date" class="form-control"
                                                placeholder="Fecha de inicio" name="start_date" required>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label for="comment">Fecha de cierre</label>
                                            <input id="Name" type="date" class="form-control"
                                                placeholder="Fecha de cierre" name="end_date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action">
                                    <button class="btn btn-success" name="submit">Crear ciclo lectivo</button>
                                    <a href="{{ route('school.ciclos.dashboard') }}" class="btn btn-danger">Cancelar</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
