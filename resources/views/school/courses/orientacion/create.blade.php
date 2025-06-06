@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Nueva orientación.</h4>
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
                            <div class="card-title">Crear orientación</div>
                        </div>

                        <form action="{{ route('school.courses.orientation.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group form-group-default">
                                    <label>Nombre de la orientación</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Ej: Ciencias Naturales" required>
                                </div>

                                <div class="form-group form-group-default">
                                    <label>Descripción de la orientación</label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                            </div>

                            <div class="card-action">
                                <button class="btn btn-success" name="submit">Crear orientación</button>
                                <a href="{{ route('school.courses.orientation.index') }}"
                                    class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
