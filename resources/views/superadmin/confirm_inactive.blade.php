<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <form action="{{ route('admin.schools.destroy') }}" method="post">
        @csrf
        <div class="modal-dialog" role="document">
            <input type="hidden" name="school_id" value="{{ $item->user_id }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ $item->is_active ? 'Desactivar' : 'Activar' }}
                        cuenta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Confirmar {{ $item->is_active ? 'desactivación' : 'activación' }} de la cuenta del establecimiento:
                    <b>{{ $item->name }}</b>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </div>
        </div>
    </form>

</div>
