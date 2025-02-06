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
                    <input type="hidden" id="new_event_type" value="1"> <!-- Campo oculto agregado -->

                    <div class="form-group">
                        <label for="new_event_title">Título</label>
                        <input type="text" class="form-control" id="new_event_title">
                    </div>
                    <div class="form-group">
                        <label for="new_event_date">Fecha</label>
                        <input type="date" class="form-control" id="new_event_date">
                    </div>
                    <div class="form-group">
                        <label for="new_event_description">Descripción</label>
                        <textarea class="form-control" id="new_event_description"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Crear Evento</button>
                </form>
            </div>
        </div>
    </div>
</div>
