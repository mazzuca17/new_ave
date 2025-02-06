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
                    <input type="hidden" id="event_type" name="type_event" value="1">
                    <!-- Campo oculto agregado -->

                    <div class="form-group">
                        <label for="event_title">Título</label>
                        <input type="text" class="form-control" id="event_title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="event_date">Fecha</label>
                        <input type="date" class="form-control" id="event_date" name="date">
                    </div>
                    <div class="form-group">
                        <label for="event_description">Descripción</label>
                        <textarea class="form-control" id="event_description" name="description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>
