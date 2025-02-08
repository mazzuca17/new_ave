@extends('layouts.app_system')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                    right: ''
                },


                events: [
                    @foreach ($events as $item)
                        {
                            id: '{{ $item->id }}',
                            title: '{{ $item->title }} - {{ $item->materia ? $item->materia->nombre : 'General' }}',
                            start: '{{ $item->fecha }}',
                            description: '{{ $item->description }}',
                            typeEvent: '{{ $item->TypeEvent->name }}',
                            curso: '{{ $item->curso ? $item->curso->name : '' }}',
                            cursoID: '{{ $item->curso ? $item->curso->id : '' }}',
                            materia_id: '{{ $item->materia ? $item->materia->id : '' }}',

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
            $('#event_type').val(event.extendedProps.typeEvent);
            $('#event_curso').val(event.extendedProps.cursoID);
            $('#event_materia').val(event.extendedProps.materia_id);
            $('#preselected_curso').val(event.extendedProps.cursoID);
            $('#eventModal').modal('show');
            editCargarMaterias(event.extendedProps.cursoID, event.extendedProps.materia_id);

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

        const selectTipo = document.getElementById("event_type");
        const selectCurso = document.getElementById("event_curso");
        const selectMateria = document.getElementById("event_materia");
        const cursoGroup = document.getElementById("edit_curso_group");
        const materiaGroup = document.getElementById("edit_materia_group");
        const userRole = document.getElementById("user_role").value;
        const preselectedCurso = document.getElementById("preselected_curso").value;

        function editCargarCursos(preselectedCursoId = null, preselectedMateriaId = null) {
            console.log(preselectedCursoId);
            fetch('/school/api/cursos')
                .then(response => response.json())
                .then(data => {
                    selectCurso.innerHTML = '<option value="">Seleccione un curso</option>';
                    data.forEach(curso => {
                        let option = document.createElement("option");
                        option.value = curso.id;
                        option.textContent = curso.name;
                        selectCurso.appendChild(option);
                    });

                    // Si hay un curso preseleccionado, seleccionarlo
                    if (preselectedCursoId) {
                        selectCurso.value = preselectedCursoId;
                        selectCurso.dispatchEvent(new Event("change"));

                        // Cargar materias del curso seleccionado
                        editCargarMaterias(preselectedCursoId, preselectedMateriaId);
                    }
                })
                .catch(error => console.error("Error al cargar cursos:", error));
        }


        function editCargarMaterias(cursoId, preselectedMateriaId = null) {
            selectMateria.innerHTML = '<option value="">Seleccione una materia</option>';
            if (cursoId) {
                fetch(`/school/api/materias?curso_id=${cursoId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(materia => {
                            let option = document.createElement("option");
                            option.value = materia.id;
                            option.textContent = materia.nombre;
                            selectMateria.appendChild(option);
                        });

                        // Preseleccionar la materia si existe
                        if (preselectedMateriaId) {
                            selectMateria.value = preselectedMateriaId;
                        }
                    })
                    .catch(error => console.error("Error al cargar materias:", error));
            }
        }

        function actualizarVisibilidad() {
            let tipo = selectTipo.value;
            cursoGroup.style.display = "none";
            materiaGroup.style.display = "none";

            if (userRole === "Colegio" || userRole === "Docente") {
                if (tipo === "evaluacion" || tipo === "entrega_tp") {
                    cursoGroup.style.display = "block";
                    materiaGroup.style.display = "block";
                    selectCurso.setAttribute("required", "true");
                    selectMateria.setAttribute("required", "true");
                } else if (tipo === "administrativo" && userRole === "Colegio") {
                    cursoGroup.style.display = "block";
                    materiaGroup.style.display = "none";
                    selectCurso.setAttribute("required", "true");
                    selectMateria.removeAttribute("required");
                } else {
                    selectCurso.removeAttribute("required");
                    selectMateria.removeAttribute("required");
                }
            }
        }

        selectCurso.addEventListener("change", function() {
            editCargarMaterias(this.value);
        });

        selectTipo.addEventListener("change", actualizarVisibilidad);

        function cargarDatosEvento(evento) {
            document.getElementById("event_id").value = evento.id;
            document.getElementById("event_title").value = evento.title;
            document.getElementById("event_date").value = evento.date;
            document.getElementById("event_description").value = evento.description;
            document.getElementById("event_type").value = evento.type;
            actualizarVisibilidad();
            console.log(evento.course_id);
            editCargarCursos(evento.course_id, evento.subject_id);
        }

        window.abrirModalEdicion = function(evento) {
            cargarDatosEvento(evento);
            $("#eventModal").modal("show");
        };
        editCargarCursos(preselectedCurso);
    </script>
    <!-- Agregar SweetAlert2 desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editEventForm = document.getElementById("editEventForm");
            const editButton = document.querySelector(".btn-success");
            const deleteButton = document.querySelector(".btn-danger");

            // Función para mostrar el modal de edición con SweetAlert
            function showEditModal(evento) {
                console.log(evento);
                Swal.fire({
                    title: "Editar Evento",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Guardar cambios",
                    cancelButtonText: "Cancelar",
                    focusConfirm: false,

                }).then((result) => {
                    if (result.isConfirmed) {
                        const updatedEvent = {
                            title: evento.title,
                            description: evento.description,
                            date: evento.date,
                            type: evento.type,
                            id_curso: evento.id_curso,
                            id_materia: evento.id_materia,
                        };
                        // Enviar los datos mediante AJAX
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content');

                        fetch(`/school/eventos/update-event/${evento.id}`, {
                                method: "PUT",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": csrfToken
                                },
                                body: JSON.stringify(updatedEvent)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire("¡Actualizado!", "El evento ha sido actualizado.",
                                        "success");
                                    setTimeout(() => {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    Swal.fire("Error", "No se pudo actualizar el evento.", "error");
                                }
                            })
                            .catch(error => {
                                console.error("Error al actualizar el evento:", error);
                                Swal.fire("Error", "No se pudo actualizar el evento.", "error");
                            });
                    }
                });
            }

            // Función para mostrar el modal de confirmación de eliminación
            function showDeleteModal(eventId) {
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Esta acción no se puede deshacer.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar la solicitud de eliminación mediante AJAX
                        fetch(`/delete-event/${eventId}`, {
                                method: "DELETE",
                                headers: {
                                    "Content-Type": "application/json"
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire("¡Eliminado!", "El evento ha sido eliminado.", "success");
                                    location.reload(); // Recargar el calendario
                                } else {
                                    Swal.fire("Error", "No se pudo eliminar el evento.", "error");
                                }
                            })
                            .catch(error => {
                                console.error("Error al eliminar el evento:", error);
                                Swal.fire("Error", "No se pudo eliminar el evento.", "error");
                            });
                    }
                });
            }

            // Asignar eventos a los botones
            editButton.addEventListener("click", function(e) {
                e.preventDefault();
                const evento = {
                    id: document.getElementById("event_id").value,
                    title: document.getElementById("event_title").value,
                    type: document.getElementById("event_type").value,
                    id_curso: document.getElementById("event_curso").value,
                    id_materia: document.getElementById("event_materia").value,
                    date: document.getElementById("event_date").value,
                    description: document.getElementById("event_description").value,
                };
                showEditModal(evento);
            });

            deleteButton.addEventListener("click", function(e) {
                e.preventDefault();
                const eventId = document.getElementById("event_id").value;
                showDeleteModal(eventId);
            });
        });
    </script>
@endsection
