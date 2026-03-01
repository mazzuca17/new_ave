@extends('layouts.app_system')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Perfil del Docente</h4>
            </div>

            <div class="row">
                <!-- Columna de perfil -->
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <!-- Imagen de perfil -->
                            @if ($prof->user->image_profile)
                                <img src="{{ asset('storage/' . $prof->user->image_profile) }}" alt="Foto de Perfil"
                                    class="rounded-circle mb-3" width="150">
                            @else
                                <div class="avatar avatar-xxl">
                                    <span class="avatar-title rounded-circle border border-white" width="150">
                                        {{ strtoupper(substr($prof->user->name, 0, 1)) . strtoupper(substr($prof->user->last_name, 0, 1)) }}

                                    </span>

                                </div>
                            @endif


                            <h5 class="card-title">{{ $prof->user->name }} </h5>
                            <h5 class="card-title">{{ $prof->user->last_name }}</h5>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('school.docentes.index') }}" class="btn btn-primary">Volver a la lista</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <!-- Pestañas -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="datos-tab" data-bs-toggle="tab" href="#datos"
                                        role="tab" aria-controls="datos" aria-selected="true">Datos personales</a>
                                </li>
                                @if (Auth::user()->hasRole('Docente') || Auth::user()->hasRole('Colegio'))
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="cursos-tab" data-bs-toggle="tab" href="#cursos"
                                            role="tab" aria-controls="cursos" aria-selected="false">Cursos inscriptos</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="materias-tab" data-bs-toggle="tab" href="#materias"
                                            role="tab" aria-controls="materias" aria-selected="false">Materias asignadas</a>
                                    </li>
                                @endif
                            </ul>
                            @include('school.profesors.profile.personal_data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
