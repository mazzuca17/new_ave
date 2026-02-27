@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="panel-header bg-dark-gradient">
            <div class="page-inner py-5">
                <h2 class="text-white pb-2 fw-bold">{{ $materia->nombre }}</h2>
            </div>
        </div>

        <div class="page-inner mt--5">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Datos de la materia</h4>
                            </div>
                            <div class="card-body">
                                <p><b>Nombre:</b> {{ $materia->nombre }}</p>
                                <p><b>Curso:</b> {{ $materia->cursos->name ?? '-' }}</p>
                                <p><b>Ciclo lectivo:</b> {{ optional($materia->cursos->academicYear)->year ?? '-' }}</p>
                                <p><b>Carga horaria:</b> {{ $totalHoras }} hs</p>
                                <p><b>Docentes asignados:</b></p>
                                <ul>
                                    @forelse ($profesores as $p)
                                        <li>{{ $p }}</li>
                                    @empty
                                        <li>Sin docentes asignados.</li>
                                    @endforelse
                                </ul>
                                <p><b>Horarios:</b></p>
                                <ul>
                                    @foreach ($horarios as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Promedios y aprobados</h4>
                            </div>
                            <div class="card-body">
                                <h3>{{ $approvalRate }}%</h3>
                                <small>Tasa de alumnos aprobados</small>
                                <hr>
                                @forelse ($termAverages as $term => $avg)
                                    <div class="mb-2">
                                        <b>{{ $term }}</b>: {{ $avg }}
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ min(100, ($avg / 10) * 100) }}%"></div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted mb-0">Sin notas cargadas.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Notas de alumnos</h4>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Alumno</th>
                                            <th>Promedio</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($studentGrades as $item)
                                            <tr>
                                                <td>{{ $item['student'] }}</td>
                                                <td>{{ $item['promedio'] ?? '-' }}</td>
                                                <td>{{ $item['estado'] }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">Sin alumnos/notas cargadas.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h4 class="card-title">Actividades cargadas</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('school.materias.activities.store', $materia->id) }}" method="POST" class="mb-3">
                                    @csrf
                                    <input name="title" class="form-control mb-2" placeholder="Ej: Entregar TP 1" required>
                                    <textarea name="instructions" class="form-control mb-2" placeholder="Consigna"></textarea>
                                    <input type="date" name="due_date" class="form-control mb-2">
                                    <button class="btn btn-primary btn-sm">Cargar actividad</button>
                                </form>
                                <ul class="list-group">
                                    @forelse ($activities as $a)
                                        <li class="list-group-item">
                                            <b>{{ $a->title }}</b><br>
                                            <small>{{ $a->instructions }}</small><br>
                                            <small>Entrega: {{ $a->due_date ?? 'sin fecha' }}</small><br>
                                            <small class="text-muted">Los alumnos pueden responder con link o archivo.</small>
                                        </li>
                                    @empty
                                        <li class="list-group-item">Sin actividades aún.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h4 class="card-title">Contenido / apuntes</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('school.materias.contents.store', $materia->id) }}" method="POST"
                                    enctype="multipart/form-data" class="mb-3">
                                    @csrf
                                    <input name="title" class="form-control mb-2" placeholder="Título" required>
                                    <input name="category" class="form-control mb-2" placeholder="Categoría (unidad/tema)" required>
                                    <textarea name="description" class="form-control mb-2" placeholder="Descripción"></textarea>
                                    <input name="link" class="form-control mb-2" placeholder="Link (opcional)">
                                    <input type="file" name="file" class="form-control mb-2">
                                    <button class="btn btn-primary btn-sm">Cargar contenido</button>
                                </form>
                                <ul class="list-group">
                                    @forelse ($contents as $c)
                                        <li class="list-group-item">
                                            <b>{{ $c->title }}</b> <span class="badge badge-info">{{ $c->category }}</span><br>
                                            <small>{{ $c->description }}</small><br>
                                            @if ($c->link)
                                                <a href="{{ $c->link }}" target="_blank">Ver link</a>
                                            @endif
                                            @if ($c->file_path)
                                                <span class="text-muted d-block">Archivo cargado</span>
                                            @endif
                                        </li>
                                    @empty
                                        <li class="list-group-item">Sin contenido aún.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Listado de eventos de la materia</h4>
                        <a href="{{ route('school.events.create') }}" class="btn btn-primary btn-sm">Agregar evento</a>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($events as $event)
                                    <tr>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ $event->description }}</td>
                                        <td>{{ $event->fecha }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No hay eventos para esta materia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
