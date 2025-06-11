@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="panel-header bg-dark-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">{{ $materia->nombre ?? 'Nombre de la Materia' }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-inner mt--5">
            <div class="container">
                {{-- Calendario de eventos --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card card-primary bg-primary-gradient">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h3 class="card-title fw-bold">Calendario de eventos</h3>
                                <div>
                                    <a href="{{ route('school.events.create') }}" class="btn btn-light">Agregar evento</a>
                                    <a href="{{ route('school.events.view') }}" class="btn btn-light">Ver todos</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><strong>Nombre</strong></th>
                                                <th><strong>Materia</strong></th>
                                                <th><strong>Comentarios</strong></th>
                                                <th><strong>Fecha</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Aquí irán los eventos --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Desempeño y datos de la materia --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Desempeño en {{ $materia->nombre ?? '' }}</div>
                            </div>
                            <div class="card-body">
                                <div id="container"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h5 class="card-title">Datos de la materia</h5>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                        Agregar notas
                                    </button>
                                    <ul class="dropdown-menu">
                                        {{-- Opciones dinámicas --}}
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body px-4 py-3">
                                <div class="row">
                                    <!-- Columna izquierda -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Nombre:</label>
                                            <div>{{ $materia->nombre ?? '---' }}</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Curso:</label>
                                            <div>{{ $materia->cursos->name }}</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Carga horaria:</label>
                                            <div>{{ $totalHoras }}</div>
                                        </div>
                                    </div>

                                    <!-- Columna derecha -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Profesores:</label>
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($profesores as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div>
                                            <label class="form-label fw-bold text-muted">Horarios:</label>
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($horarios as $item)
                                                    <li> {{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Archivos de la materia --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Archivos de la materia</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills nav-secondary mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#apuntes" role="tab">Apuntes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#actividades" role="tab">Actividades /
                                    TP</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            {{-- Apuntes --}}
                            <div class="tab-pane fade show active" id="apuntes" role="tabpanel">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Agregar apunte</h4>
                                        <a href="" class="btn btn-primary">Agregar Apunte</a>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Título</th>
                                                    <th>Comentarios</th>
                                                    <th>Presentación</th>
                                                    <th>Descargar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- Contenido dinámico --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- Actividades --}}
                            <div class="tab-pane fade" id="actividades" role="tabpanel">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Agregar actividad / TP</h4>
                                        <a href="" class="btn btn-primary">Agregar</a>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Título</th>
                                                    <th>Comentarios</th>
                                                    <th>Fecha de entrega</th>
                                                    <th>Descargar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- Contenido dinámico --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Foros --}}
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Foros de {{ $materia->nombre ?? '' }}</h4>
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Opciones foros
                        </button>
                        <div class="dropdown-menu">
                            {{-- Opciones de foros --}}
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- Contenido dinámico --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
@endsection
