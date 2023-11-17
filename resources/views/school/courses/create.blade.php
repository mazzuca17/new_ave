@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Crear curso.</h4>

            </div>
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Crear curso</div>
                        </div>
                        <form action="{{ route('school.courses.create') }}" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-lg-4">

                                    </div>
                                    <div class="col-md-12">

                                        <div class="form-group form-group-default">
                                            <label>Curso</label>
                                            <input id="Name" type="text" class="form-control"
                                                placeholder="Curso (ejemplo 3° G)" name="curso" required>
                                        </div>


                                        <div class="form-group form-group-default">
                                            <label for="comment">Modalidad</label>
                                            <input id="Name" type="text" class="form-control"
                                                placeholder="Modalidad" name="modalidad" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action">
                                    <button class="btn btn-success" name="submit">Crear curso</button>
                                    <a href="{{ route('school.courses.index') }}" class="btn btn-danger">Cancelar</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
