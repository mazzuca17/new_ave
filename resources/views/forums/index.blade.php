@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="page-title">Foros por materia</h4>
                    <p class="mb-0 text-muted">Ingresá a cada foro para ver mensajes y comentarios activos.</p>
                </div>
                @if (Auth::user()->hasAnyRole(['Colegio', 'Docente']))
                    <a href="{{ route('forums.create') }}" class="btn btn-primary">Crear foro</a>
                @endif
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @forelse ($materias as $materia)
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>{{ $materia->nombre }}</strong>
                        <small class="text-muted">{{ optional($materia->cursos)->name }}</small>
                    </div>
                    <div class="card-body">
                        @if ($materia->forums->isEmpty())
                            <p class="text-muted mb-0">No hay foros creados para esta materia.</p>
                        @else
                            <div class="list-group">
                                @foreach ($materia->forums as $forum)
                                    <a href="{{ route('forums.show', $forum->id) }}"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">{{ $forum->title }}</h5>
                                            <small>{{ $forum->description }}</small>
                                        </div>
                                        <span>
                                            <span class="badge badge-{{ $forum->is_active ? 'success' : 'secondary' }} mr-2">
                                                {{ $forum->is_active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                            <span class="badge badge-info">{{ $forum->messages_count }} mensajes</span>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="alert alert-info">No tenés materias asociadas para visualizar foros.</div>
            @endforelse
        </div>
    </div>
@endsection
