<div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-labelledby="createEventModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEventModalLabel">Crear Nuevo Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createEventForm">
                    <input type="hidden" id="user_role" value="Colegio"> <!-- Valor dinámico del backend -->
                    <input type="hidden" id="preselected_curso" value="{{ $curso->id ?? '' }}">

                    <div class="form-group">
                        <label for="new_event_title">Título</label>
                        <input type="text" class="form-control" id="new_event_title" required>
                    </div>

                    <div class="form-group">
                        <label for="new_event_type">Tipo de Evento</label>
                        <select class="form-control" id="new_event_type" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="administrativo">Administrativo</option>

                            <option value="global" {{ $curso != null ? 'hidden' : '' }}>Global</option>
                            <option value="evaluacion">Evaluación</option>
                            <option value="entrega_tp">Entrega TP</option>
                        </select>
                    </div>

                    <div class="form-group" id="curso_group">
                        <label for="new_event_curso">Curso</label>
                        <select class="form-control" id="new_event_curso" {{ $curso != null ? 'readonly' : '' }}>
                            <option value="">Seleccione un curso</option>
                        </select>
                    </div>

                    <div class="form-group" id="materia_group">
                        <label for="new_event_materia">Materia</label>
                        <select class="form-control" id="new_event_materia">
                            <option value="">Seleccione una materia</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="new_event_date">Fecha</label>
                        <input type="date" class="form-control" id="new_event_date" required>
                    </div>

                    <div class="form-group">
                        <label for="new_event_description">Descripción</label>
                        <textarea class="form-control" id="new_event_description" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Crear Evento</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectTipo = document.getElementById("new_event_type");
        const selectCurso = document.getElementById("new_event_curso");
        const selectMateria = document.getElementById("new_event_materia");
        const cursoGroup = document.getElementById("curso_group");
        const materiaGroup = document.getElementById("materia_group");
        const userRole = document.getElementById("user_role").value;
        const preselectedCurso = document.getElementById("preselected_curso").value;

        /**
         * Carga los cursos disponibles
         */
        function cargarCursos() {
            fetch('/school/api/cursos')
                .then(response => response.json())
                .then(data => {
                    selectCurso.innerHTML = '<option value="">Seleccione un curso</option>';
                    data.forEach(curso => {
                        let option = document.createElement("option");
                        option.value = curso.id;
                        option.textContent = curso.name;
                        if (curso.id == preselectedCurso) {
                            option.selected = true;
                        }
                        selectCurso.appendChild(option);
                    });

                    if (preselectedCurso) {
                        selectCurso.dispatchEvent(new Event('change'));
                    }
                })
                .catch(error => console.error("Error al cargar cursos:", error));
        }

        /**
         * Carga las materias según el curso seleccionado
         */
        function cargarMaterias(cursoId) {
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
                    })
                    .catch(error => console.error("Error al cargar materias:", error));
            }
        }

        /**
         * Maneja la visibilidad de los campos Curso y Materia
         */
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
                    alert('ACA');
                    cursoGroup.style.display = "block";
                    materiaGroup.style.display = "none";
                    selectCurso.setAttribute("required", "true");
                    selectMateria.removeAttribute("required");
                } else {
                    cursoGroup.style.display = "none";
                    materiaGroup.style.display = "none";
                    selectCurso.removeAttribute("required");
                    selectMateria.removeAttribute("required");
                }
            } else {
                cursoGroup.style.display = "none";
                materiaGroup.style.display = "none";
                selectCurso.removeAttribute("required");
                selectMateria.removeAttribute("required");
            }
        }

        // Listeners
        selectCurso.addEventListener("change", function() {
            cargarMaterias(this.value);
        });

        cursoGroup.style.display = "none";
        materiaGroup.style.display = "none";

        selectTipo.addEventListener("change", actualizarVisibilidad);

        // Inicializar
        cursoGroup.style.display = "none";
        materiaGroup.style.display = "none";

        cargarCursos();
    });
</script>
