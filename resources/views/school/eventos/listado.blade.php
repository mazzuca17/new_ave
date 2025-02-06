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
                            url: '{{ route('school.events.edit', ['event_id' => $item->id]) }}',
                            backgroundColor: '{{ $item->type_id ? '#3352FFFF' : '#ff5733' }}',
                            borderColor: '{{ $item->type_id ? '#3352FFFF' : '#ff5733' }}',

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

        // document.addEventListener('DOMContentLoaded', function() {
        //     var calendarEl = document.getElementById('calendar');

        //     var calendar = new FullCalendar.Calendar(calendarEl, {
        //         initialView: 'dayGridMonth',
        //         locale: 'es',
        //         headerToolbar: {
        //             left: 'prev,next today',
        //             center: 'title',
        //             right: 'dayGridMonth,timeGridWeek,timeGridDay'
        //         },
        //         events: @json($events),
        //         eventClick: function(info) {
        //             info.jsEvent.preventDefault();
        //             openEditModal(info.event);
        //         },
        //         dateClick: function(info) {
        //             openCreateModal(info.dateStr);
        //         }
        //     });

        //     calendar.render();
        // });

        function openEditModal(event) {
            $('#event_id').val(event.id);
            $('#event_title').val(event.title.split(" - ")[0]); // Extraer título sin la materia
            $('#event_description').val(event.extendedProps.description);
            $('#event_date').val(event.startStr);
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
            var data = {
                _token: '{{ csrf_token() }}',
                title: $('#new_event_title').val(),
                description: $('#new_event_description').val(),
                fecha: $('#new_event_date').val()
            };

            $.ajax({
                url: `/school/eventos/store`,
                type: 'POST',
                data: data,
                success: function(response) {
                    alert('Evento creado correctamente');
                    $('#createEventModal').modal('hide');
                    location.reload();
                }
            });
        });
    </script>
@endsection
