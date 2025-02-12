@extends('layouts.app_system')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Perfil del Alumno</h4>
            </div>

            <div class="row">
                <!-- Columna de perfil -->
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            @if ($alumno->image_profile)
                                <img src="{{ asset('storage/' . $alumno->image_profile) }}" alt="Foto de Perfil"
                                    class="rounded-circle mb-3" width="150">
                            @else
                                <div class="avatar avatar-xxl">
                                    <span class="avatar-title avatar-alumno rounded-circle border border-white"
                                        width="150">
                                        {{ strtoupper(substr($alumno->user->name, 0, 1)) . strtoupper(substr($alumno->user->last_name, 0, 1)) }}

                                    </span>

                                </div>
                            @endif

                            <h5 class="card-title">{{ $alumno->user->name }} </h5>
                            <h5 class="card-title">{{ $alumno->user->last_name }}</h5>
                            <p class="text-muted">{{ $alumno->curso->name }}</p>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('school.alumnos.index') }}" class="btn btn-primary">Volver a la lista</a>
                        </div>
                    </div>
                </div>

                <!-- Columna de información del alumno -->
                <div class="col-md-9">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <!-- Pestañas -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="datos-tab" data-bs-toggle="tab" href="#datos"
                                        role="tab" aria-controls="datos" aria-selected="true">Datos del Alumno</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="tutor-tab" data-bs-toggle="tab" href="#tutor" role="tab"
                                        aria-controls="tutor" aria-selected="false">Datos del Tutor</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="medicos-tab" data-bs-toggle="tab" href="#medicos" role="tab"
                                        aria-controls="medicos" aria-selected="false">Información Médica</a>
                                </li>
                            </ul>

                            <!-- Contenido de las pestañas -->
                            <div class="tab-content" id="myTabContent">
                                <!-- Datos del Alumno -->
                                <div class="tab-pane fade show active" id="datos" role="tabpanel"
                                    aria-labelledby="datos-tab">
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <p><strong>Email:</strong> {{ $alumno->user->email }}</p>
                                            <p><strong>DNI:</strong> {{ $alumno->dni }}</p>
                                            <p><strong>Fecha de Nacimiento:</strong> {{ $alumno->fecha_nacimiento }}</p>
                                            <p><strong>Género:</strong> {{ ucfirst($alumno->genero) }}</p>
                                            <p><strong>Curso:</strong> {{ $alumno->curso->name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Dirección:</strong> {{ $alumno->direccion }}</p>
                                            <p><strong>Teléfono:</strong> {{ $alumno->telefono }}</p>
                                            <p><strong>Nacionalidad:</strong> {{ $alumno->nacionalidad }}</p>
                                            <p><strong>Condición:</strong> {{ ucfirst($alumno->condition) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Datos del Tutor -->
                                <div class="tab-pane fade" id="tutor" role="tabpanel" aria-labelledby="tutor-tab">
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <p><strong>Nombre del Tutor:</strong> {{ $alumno->nombre_tutor }}</p>
                                            <p><strong>Teléfono del Tutor:</strong> {{ $alumno->telefono_tutor }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información Médica -->
                                <div class="tab-pane fade" id="medicos" role="tabpanel" aria-labelledby="medicos-tab">
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <p><strong>Alergias:</strong> {{ $alumno->alergias }}</p>
                                            <p><strong>Seguro Médico:</strong> {{ $alumno->seguro_medico }}</p>
                                            <p><strong>Contacto de Emergencia:</strong> {{ $alumno->contacto_emergencia }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de navegación -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
