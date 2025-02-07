@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner mt--20">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 ml-auto mr-auto">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Eventos</div>
                            </div>
                            <div class="card-body">
                                <button class="btn btn-primary" style="margin-bottom: 1rem;"
                                    onclick="openCreateModal()">Nuevo evento</button>

                                <!-- Calendario -->
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDITAR EVENTO -->
    @include('school.eventos.edit')
    <!-- MODAL CREAR EVENTO -->
    @include('school.eventos.create')

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },


                events: [
                    @foreach ($events as $item)
                        {
                            id: '{{ $item->id }}',
                            title: '{{ $item->title }} - {{ $item->materia ? $item->materia->nombre : 'General' }}',
                            start: '{{ $item->fecha }}',
                            description: '{{ $item->description }}',
                            type: '{{ $item->TypeEvent->name }}',
                            curso: '{{ $item->curso ? $item->curso->name : '' }}',
                            url: '{{ route('school.events.edit', ['event_id' => $item->id]) }}',
                            backgroundColor: '{{ $item->TypeEvent->code_color }}',
                            borderColor: '{{ $item->TypeEvent->code_color }}',
                        },
                    @endforeach
                ],
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    openEditModal(info.event);
                },
                dateClick: function(info) {
                    openCreateModal(info.dateStr);
                }
            });

            calendar.render();
        });



        function openEditModal(event) {
            console.log(event);
            $('#event_id').val(event.id);
            $('#event_title').val(event.title.split(" - ")[0]); // Extraer título sin la materia
            $('#event_description').val(event.extendedProps.description);
            $('#event_date').val(event.startStr);
            $('#event_type').val(event.type_event);
            $('#event_course').val(event.curso);

            $('#eventModal').modal('show');
        }

        function openCreateModal(date = '') {
            $('#new_event_title').val('');
            $('#new_event_description').val('');
            $('#new_event_date').val(date);
            $('#createEventModal').modal('show');
        }

        // Enviar cambios de edición por AJAX
        $('#editEventForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#event_id').val();
            var data = {
                _token: '{{ csrf_token() }}',
                event_id: id,
                title: $('#event_title').val(),
                description: $('#event_description').val(),
                fecha: $('#event_date').val()
            };

            $.ajax({
                url: `/school/eventos/update`,
                type: 'POST',
                data: data,
                success: function(response) {
                    alert('Evento actualizado correctamente');
                    $('#eventModal').modal('hide');
                    location.reload();
                }
            });
        });

        // Enviar creación de evento por AJAX
        $('#createEventForm').on('submit', function(e) {
            e.preventDefault();

            // Obtener valores del formulario
            var title = $('#new_event_title').val().trim();
            var description = $('#new_event_description').val().trim();
            var fecha = $('#new_event_date').val();
            var tipo_evento = $('#new_event_type').val();
            var curso_id = $('#new_event_curso').val();
            var materia_id = $('#new_event_materia').val();
            var is_profile_course = $('#preselected_curso').val();

            // Validaciones básicas
            if (!title || !description || !fecha || !tipo_evento) {
                alert('Por favor complete todos los campos obligatorios.');
                return;
            }

            if ((tipo_evento === 'evaluacion' || tipo_evento === 'entrega_tp') && (!curso_id || !materia_id)) {
                alert('Debe seleccionar un curso y una materia para este tipo de evento.');
                return;
            }

            var data = {
                _token: '{{ csrf_token() }}',
                title: title,
                description: description,
                fecha: fecha,
                tipo_evento: tipo_evento,
                curso_id: curso_id || null,
                materia_id: materia_id || null,
                is_profile_course: is_profile_course
            };
            console.log(data);
            $.ajax({
                url: `/school/eventos/store`,
                type: 'POST',
                data: data,
                success: function(response) {
                    alert('Evento creado correctamente');
                    $('#createEventModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    var errorMessage = 'Ocurrió un error al crear el evento.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert(errorMessage);
                }
            });
        });
    </script>
@endsection
