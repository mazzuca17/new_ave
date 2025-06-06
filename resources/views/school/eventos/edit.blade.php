<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Editar Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editEventForm">
                    <input type="hidden" id="event_id" name="event_id">
                    <input type="hidden" id="user_role" value="{{ Auth::user()->roles[0]->name }}">
                    <!-- Valor dinámico del backend -->
                    <input type="hidden" id="preselected_curso" name="preselected_curso">
                    <!-- Valor dinámico del backend -->

                    <div class="form-group">
                        <label for="event_title">Título</label>
                        <input type="text" class="form-control" id="event_title" required>
                    </div>

                    <div class="form-group">
                        <label for="event_type">Tipo de Evento</label>
                        <select class="form-control" id="event_type" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="administrativo">Administrativo</option>
                            <option value="global">Global</option>
                            <option value="evaluacion">Evaluación</option>
                            <option value="entrega_tp">Entrega TP</option>
                        </select>
                    </div>

                    <div class="form-group" id="edit_curso_group">
                        <label for="event_curso">Curso</label>
                        <select class="form-control" id="event_curso">
                            <option value="preselect_curso"></option>

                        </select>
                    </div>

                    <div class="form-group" id="edit_materia_group">
                        <label for="event_materia">Materia</label>
                        <select class="form-control" id="event_materia">
                            <option value="">Seleccione una materia</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="event_date">Fecha</label>
                        <input type="date" class="form-control" id="event_date" required>
                    </div>

                    <div class="form-group">
                        <label for="event_description">Descripción</label>
                        <textarea class="form-control" id="event_description" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Editar evento</button>
                    <button type="submit" class="btn btn-danger">Eliminar evento</button>

                </form>
            </div>
        </div>
    </div>
</div>
