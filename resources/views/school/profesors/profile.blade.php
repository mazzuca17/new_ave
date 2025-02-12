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
                            @if ($prof->image_profile)
                                <img src="{{ asset('storage/' . $prof->image_profile) }}" alt="Foto de Perfil"
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

                <!-- Columna de información del alumno -->
                <div class="col-md-9">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <!-- Pestañas -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="datos-tab" data-bs-toggle="tab" href="#datos"
                                        role="tab" aria-controls="datos" aria-selected="true">Datos personales</a>
                                </li>

                            </ul>

                            <!-- Contenido de las pestañas -->
                            <div class="tab-content" id="myTabContent">
                                <!-- Datos del Alumno -->
                                <div class="tab-pane fade show active" id="datos" role="tabpanel"
                                    aria-labelledby="datos-tab">
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <p><strong>Email:</strong> {{ $prof->user->email }}</p>
                                            <p><strong>DNI:</strong> {{ $prof->dni }}</p>
                                            <p><strong>Fecha de Nacimiento:</strong> {{ $prof->fecha_nacimiento }}</p>
                                            <p><strong>Género:</strong> {{ ucfirst($prof->genero) }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Dirección:</strong> {{ $prof->direccion }}</p>
                                            <p><strong>Teléfono:</strong> {{ $prof->telefono }}</p>
                                            <p><strong>Nacionalidad:</strong> {{ $prof->nacionalidad }}</p>
                                            <p><strong>Condición:</strong> {{ ucfirst($prof->condition) }}</p>
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
