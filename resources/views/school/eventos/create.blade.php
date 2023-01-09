@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner mt--20">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 ml-auto mr-auto">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Crear evento.</div>
                            </div>
                            <form action="{{ route('school.events.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 col-lg-4">

                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label id="title" class="mb-3"><b>Título</b></label>
                                                <input class="form-control" name="title" type="text"
                                                    placeholder="Título del evento" required>
                                            </div>

                                            <div class="form-group">
                                                <label id="description" class="mb-3"><b>Descripción</b></label>
                                                <input class="form-control" name="description" type="text"
                                                    placeholder="Descripción del evento" required>
                                            </div>

                                            <div class="form-group">
                                                <label id="fecha" class="mb-3"><b>Fecha</b></label>
                                                <input class="form-control" name="fecha" type="date"
                                                    placeholder="Fecha del evento" required>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="card-action">
                                        <button class="btn btn-success" name="submit">Guardar</button>
                                        <a href="{{ route('school.dashboard') }}" class="btn btn-danger">Cancelar</a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
