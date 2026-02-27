@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h4 class="page-title">{{ $forum->title }}</h4>
                    <p class="text-muted mb-1">Materia: {{ $forum->materia->nombre }}</p>
                    <p>{{ $forum->description }}</p>
                </div>
                <div>
                    <a href="{{ route('forums.index') }}" class="btn btn-light">Volver</a>
                    @if (Auth::user()->hasAnyRole(['Colegio', 'Docente']))
                        <a href="{{ route('forums.edit', $forum->id) }}" class="btn btn-warning">Editar</a>
                        <form method="POST" action="{{ route('forums.toggle_status', $forum->id) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-{{ $forum->is_active ? 'secondary' : 'success' }}">
                                {{ $forum->is_active ? 'Inhabilitar' : 'Habilitar' }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card mt-3">
                <div class="card-header">Publicar mensaje</div>
                <div class="card-body">
                    @if (!$forum->is_active)
                        <div class="alert alert-warning mb-0">Este foro está inactivo y no admite nuevas publicaciones.</div>
                    @else
                        <form action="{{ route('forums.messages.store', $forum->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <textarea name="body" class="form-control" rows="3" placeholder="Escribí tu mensaje..." required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Adjuntos (hasta 5 MB por archivo)</label>
                                <input type="file" name="attachments[]" class="form-control" multiple>
                            </div>
                            <button class="btn btn-primary">Publicar</button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="mt-4">
                @forelse ($forum->messages->sortByDesc('created_at') as $message)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $message->user->last_name }} {{ $message->user->name }}</strong>
                                <small>{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mt-2">{{ $message->body }}</p>

                            @if ($message->attachments->isNotEmpty())
                                <div class="mb-2">
                                    @foreach ($message->attachments as $attachment)
                                        <a class="badge badge-info mr-1" target="_blank"
                                            href="{{ asset('storage/' . $attachment->file_path) }}">{{ $attachment->file_name }}</a>
                                    @endforeach
                                </div>
                            @endif

                            <hr>
                            <h6>Comentarios</h6>
                            @forelse ($message->comments as $comment)
                                <div class="mb-2 pl-2 border-left">
                                    <small>
                                        <strong>{{ $comment->user->last_name }} {{ $comment->user->name }}</strong>
                                        · {{ $comment->created_at->diffForHumans() }}
                                    </small>
                                    <div>{{ $comment->body }}</div>
                                </div>
                            @empty
                                <small class="text-muted">Sin comentarios.</small>
                            @endforelse

                            @if ($forum->is_active)
                                <form action="{{ route('forums.comments.store', [$forum->id, $message->id]) }}" method="POST"
                                    class="mt-2">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="body" class="form-control" maxlength="1500"
                                            placeholder="Escribí un comentario" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary">Comentar</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">Todavía no hay mensajes en este foro.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
