@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner mt--20">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Editar materia</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('school.materias.save_edit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $materia->id }}">

                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $materia->nombre) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Curso</label>
                                <select name="curso_id" class="form-control" required>
                                    @foreach ($cursos as $curso)
                                        <option value="{{ $curso->id }}" @selected(old('curso_id', $materia->curso_id) == $curso->id)>
                                            {{ $curso->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Docentes</label>
                                <select id="teacher-select" class="form-control">
                                    <option value="">Seleccionar docente</option>
                                    @foreach ($profesors as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->user->last_name }}
                                            {{ $teacher->user->name }}</option>
                                    @endforeach
                                </select>
                                <ul id="selected-teachers" class="list-group mt-2">
                                    @foreach ($materia->materiasprofesores as $item)
                                        @if ($item->teachers && $item->teachers->user)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $item->teachers->user->last_name }} {{ $item->teachers->user->name }}
                                                <input type="hidden" name="teachers[]" value="{{ $item->teacher_id }}">
                                                <button type="button" class="btn btn-sm btn-danger remove-teacher">Eliminar</button>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>

                            <h5 class="mt-3">Horarios</h5>
                            <div id="horarios-wrapper">
                                @foreach ($materia->horarios as $i => $horario)
                                    <div class="horario-block d-flex gap-2 mb-2">
                                        <select name="schedules[{{ $i }}][day]" class="form-control" required>
                                            @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'] as $day)
                                                <option @selected(
                                                    \App\Models\MateriasHorarios::getNumberDayWeek($day) == $horario->day_of_week)>
                                                    {{ $day }}</option>
                                            @endforeach
                                        </select>
                                        <input type="time" name="schedules[{{ $i }}][from]" class="form-control"
                                            value="{{ \Illuminate\Support\Carbon::parse($horario->start_time)->format('H:i') }}" required>
                                        <input type="time" name="schedules[{{ $i }}][to]" class="form-control"
                                            value="{{ \Illuminate\Support\Carbon::parse($horario->end_time)->format('H:i') }}" required>
                                        <button type="button" class="btn btn-sm btn-danger remove-schedule">−</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-info add-schedule mt-2">+ Agregar horario</button>

                            <div class="mt-4">
                                <button class="btn btn-success">Guardar cambios</button>
                                <a href="{{ route('school.materias.index') }}" class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let scheduleCount = {{ $materia->horarios->count() }};

        $('.add-schedule').on('click', function() {
            const newBlock = `<div class="horario-block d-flex gap-2 mb-2">
                <select name="schedules[${scheduleCount}][day]" class="form-control" required>
                    <option>Lunes</option><option>Martes</option><option>Miércoles</option><option>Jueves</option><option>Viernes</option>
                </select>
                <input type="time" name="schedules[${scheduleCount}][from]" class="form-control" required>
                <input type="time" name="schedules[${scheduleCount}][to]" class="form-control" required>
                <button type="button" class="btn btn-sm btn-danger remove-schedule">−</button>
            </div>`;
            scheduleCount++;
            $('#horarios-wrapper').append(newBlock);
        });

        $(document).on('click', '.remove-schedule', function() {
            if ($('.horario-block').length > 1) $(this).closest('.horario-block').remove();
        });

        $('#teacher-select').on('change', function() {
            const selectedId = $(this).val();
            const selectedText = $(this).find('option:selected').text();
            if (!selectedId) return;
            $('#selected-teachers').append(`<li class="list-group-item d-flex justify-content-between align-items-center">
                ${selectedText}
                <input type="hidden" name="teachers[]" value="${selectedId}">
                <button type="button" class="btn btn-sm btn-danger remove-teacher">Eliminar</button>
            </li>`);
            $(this).val('');
        });

        $(document).on('click', '.remove-teacher', function() {
            $(this).closest('li').remove();
        });
    </script>
@endsection
