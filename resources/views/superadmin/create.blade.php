@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner mt--20">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 ml-auto mr-auto">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Crear establecimiento.</div>
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 col-lg-4">

                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label id="name_school" class="mb-3"><b>Nombre del
                                                        establecimiento</b></label>
                                                <input class="form-control" name="name_school" type="text"
                                                    placeholder="Nombre del establecimiento" required>
                                            </div>

                                            <div class="form-group">
                                                <label id="name_school" class="mb-3"><b>Email del
                                                        establecimiento</b></label>
                                                <input class="form-control" name="name_school" type="text"
                                                    placeholder="Nombre del establecimiento" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-action">
                                        <button class="btn btn-success" name="submit">Guardar</button>
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-danger">Cancelar</a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
