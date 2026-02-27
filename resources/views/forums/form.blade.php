@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <h4 class="page-title">{{ $isEdit ? 'Editar foro' : 'Nuevo foro' }}</h4>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ $isEdit ? route('forums.update', $forum->id) : route('forums.store') }}">
                        @csrf
                        @if ($isEdit)
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label>Materia</label>
                            <select name="materia_id" class="form-control" required>
                                <option value="">Seleccionar</option>
                                @foreach ($materias as $materia)
                                    <option value="{{ $materia->id }}"
                                        {{ old('materia_id', $forum->materia_id) == $materia->id ? 'selected' : '' }}>
                                        {{ $materia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" name="title" class="form-control" maxlength="150"
                                value="{{ old('title', $forum->title) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea name="description" rows="4" class="form-control">{{ old('description', $forum->description) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success">{{ $isEdit ? 'Guardar cambios' : 'Crear foro' }}</button>
                        <a href="{{ route('forums.index') }}" class="btn btn-light">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
