@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Crear materia.</h4>
            </div>

            <div class="row">
                <div class="col-md-8 ml-auto mr-auto">
                    @if ($show_message)
                        <div class="alert alert-danger">
                            <h4><b>¡Ups, algo salió mal!</b></h4>
                            Antes de cargar una materia, tenes que asegurarte de haber cargado y activado las materias y los
                            docentes.
                            <a class="btn btn-primary" href="{{ route('school.materias.index') }}">Volver atrás</a>
                        </div>
                    @else
                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        @if (Session::has('danger'))
                            <div class="alert alert-danger">{{ Session::get('danger') }}</div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Crear materia</div>
                            </div>



                            <form action="{{ route('school.materias.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group form-group-default">
                                        <label>Nombre de la materia</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>

                                    <div class="form-group form-group-default">
                                        <label>Curso</label>
                                        <select class="form-control" name="curso_id" id="">
                                            <option value="">Selecciona el curso</option>
                                            @foreach ($cursos as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group form-group-default">
                                        <label>Seleccionar docente</label>
                                        <select class="form-control" id="teacher-select">
                                            <option value="">Selecciona un docente</option>
                                            @foreach ($profesors as $teacher)
                                                <option value="{{ $teacher->id }}">
                                                    {{ strtoupper($teacher->user->last_name) }}, {{ $teacher->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <ul id="selected-teachers" class="list-group mt-3"></ul>

                                    </div>



                                    <h5 class="mt-4">Horarios de la materia</h5>
                                    <div id="horarios-wrapper">
                                        <div class="horario-block d-flex gap-2 mb-2">
                                            <select name="schedules[0][day]" class="form-control" required>
                                                <option value="">Día</option>
                                                <option>Lunes</option>
                                                <option>Martes</option>
                                                <option>Miércoles</option>
                                                <option>Jueves</option>
                                                <option>Viernes</option>
                                            </select>
                                            <input type="time" name="schedules[0][from]" class="form-control" required>
                                            <input type="time" name="schedules[0][to]" class="form-control" required>
                                            <button type="button" class="btn btn-sm btn-danger remove-schedule">−</button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-info add-schedule mt-2">+ Agregar horario</button>

                                    <div class="card-action mt-4">
                                        <button class="btn btn-success">Crear materia</button>
                                        <a href="{{ route('school.ciclos.dashboard') }}" class="btn btn-danger">Cancelar</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let teacherCount = 1;
        let scheduleCount = 1;

        function actualizarOpcionesDocentes() {
            const seleccionados = [];

            $('.teacher-select').each(function() {
                const val = $(this).val();
                if (val) {
                    seleccionados.push(val);
                }
            });

            $('.teacher-select').each(function() {
                const currentSelect = $(this);
                const currentVal = currentSelect.val();

                currentSelect.find('option').each(function() {
                    const optionVal = $(this).attr('value');
                    if (!optionVal) return; // Ignorar opción vacía

                    if (optionVal === currentVal || !seleccionados.includes(optionVal)) {
                        $(this).prop('disabled', false);
                    } else {
                        $(this).prop('disabled', true);
                    }
                });
            });
        }

        $('.add-teacher').on('click', function() {
            const newTeacher = $('.teacher-block').first().clone();
            newTeacher.find('select').val('');
            $('#teachers-wrapper').append(newTeacher);
            teacherCount++;
            actualizarOpcionesDocentes();
        });

        $(document).on('change', '.teacher-select', function() {
            actualizarOpcionesDocentes();
        });

        $('.add-schedule').on('click', function() {
            const newSchedule = $('.horario-block').first().clone();
            newSchedule.find('select, input').each(function() {
                const name = $(this).attr('name');
                const field = name.split('[')[2].split(']')[0];
                $(this).attr('name', `schedules[${scheduleCount}][${field}]`).val('');
            });
            scheduleCount++;
            $('#horarios-wrapper').append(newSchedule);
        });

        $(document).on('click', '.remove-schedule', function() {
            if ($('.horario-block').length > 1) {
                $(this).closest('.horario-block').remove();
            }
        });

        $(document).ready(function() {
            actualizarOpcionesDocentes();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#teacher-select').on('change', function() {
                const selectedId = $(this).val();
                const selectedText = $(this).find('option:selected').text();

                if (!selectedId) return;

                // Agregar a la lista visual
                const listItem = $(`
        <li class="list-group-item d-flex justify-content-between align-items-center">
            ${selectedText}
            <input type="hidden" name="teachers[]" value="${selectedId}">
            <button type="button" class="btn btn-sm btn-danger remove-teacher">Eliminar</button>
        </li>
    `);
                $('#selected-teachers').append(listItem);

                // Eliminar del select
                $(this).find(`option[value="${selectedId}"]`).hide();
                $(this).val('');
            });

            $(document).on('click', '.remove-teacher', function() {
                const li = $(this).closest('li');
                const teacherId = li.find('input').val();

                // Volver a mostrar en el select
                $(`#teacher-select option[value="${teacherId}"]`).show();

                li.remove();
            });

        });
    </script>


@endsection
