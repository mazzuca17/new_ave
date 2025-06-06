@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Editar curso.</h4>

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
                            <div class="card-title">Editar curso</div>
                        </div>

                        <form action="{{ route('school.courses.save_edit') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-lg-4">

                                    </div>
                                    <div class="col-md-12">
                                        <input type="hidden" name="course_id" value="{{ $data->id }}">
                                        <div class="form-group form-group-default">
                                            <label>Curso</label>
                                            <input id="Name" type="text" class="form-control"
                                                value="{{ $data->name }}" name="curso" required>
                                        </div>


                                        <div class="form-group form-group-default">
                                            <label for="comment">Modalidad</label>
                                            <input id="Name" type="text" class="form-control"
                                                value="{{ $data->modalidad }}" name="modalidad" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action">
                                    <button class="btn btn-success" name="submit">Editar curso</button>
                                    <a href="{{ route('school.courses.index') }}" class="btn btn-danger">Cancelar</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
