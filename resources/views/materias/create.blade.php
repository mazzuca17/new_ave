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

                                    <h5>Docentes</h5>
                                    <div id="teachers-wrapper">
                                        <div class="teacher-block border p-3 mb-3">
                                            <div class="form-group">
                                                <label>Docente</label>
                                                <input type="text" class="form-control" name="teachers[]"
                                                    placeholder="Nombre del docente" required>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary add-teacher mt-2">+ Agregar
                                        docente</button>

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

        $('.add-teacher').on('click', function() {
            const newTeacher = $('.teacher-block').first().clone();
            newTeacher.find('input').val('');
            $('#teachers-wrapper').append(newTeacher);
            teacherCount++;
        });

        $('.add-schedule').on('click', function() {
            const newSchedule = $('.horario-block').first().clone();
            newSchedule.find('select, input').each(function() {
                const name = $(this).attr('name');
                const base = name.split('[')[0];
                const key = name.split('[')[1].split(']')[0];
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
    </script>
@endsection
