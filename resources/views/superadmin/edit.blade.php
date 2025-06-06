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
                                <div class="card-title">Editar establecimiento.</div>
                            </div>
                            <form action="{{ route('admin.schools.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 col-lg-4">

                                        </div>
                                        <div class="col-md-12">
                                            <input type="hidden" name="school_id" value="{{ $school->user_id }}">
                                            <div class="form-group">
                                                <label id="name_school" class="mb-3"><b>Nombre del
                                                        establecimiento</b></label>
                                                <input class="form-control" name="name_school" type="text"
                                                    placeholder="Nombre del establecimiento" value="{{ $school->name }}"
                                                    required>
                                            </div>

                                            <div class="form-group">
                                                <label id="email" class="mb-3"><b>Email del
                                                        establecimiento</b></label>
                                                <input class="form-control" name="email" type="email"
                                                    placeholder="Email del establecimiento"
                                                    value="{{ $school->user->email }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label id="description" class="mb-3"><b>Descripción del
                                                        establecimiento</b></label>
                                                <input class="form-control" name="description" type="text"
                                                    placeholder="Descripción del establecimiento"
                                                    value="{{ $school->description }}" required>
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
