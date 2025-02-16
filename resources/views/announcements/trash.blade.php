@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="container container-full" style="max-width: none !important">
            <div class="page-inner page-inner-fill">
                <div class="page-with-aside mail-wrapper bg-white">
                    @include('announcements.options')
                    <div class="page-content mail-content">
                        <div class="inbox-head d-lg-flex d-block">
                            <h3>Papelera</h3>
                            <form action="#" class="ml-auto">
                                <div class="input-group">
                                    <input type="text" placeholder="Buscar mensaje" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-search search-icon"></i>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="inbox-body">
                            @include('announcements.list_options_filters')

                            @forelse ($messages as $item)
                                <div class="email-list">
                                    <div class="email-list-item {{ $item->is_read ? '' : 'unread' }}">
                                        <div class="email-list-actions">
                                            <div class="d-flex">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                                <span class="rating rating-sm mr-3">
                                                    <input type="checkbox" id="star{{ $item->id }}" value="1">
                                                    <label for="star{{ $item->id }}">
                                                        <span class="fa fa-star"></span>
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="email-list-detail">
                                            <span class="date float-right">
                                                @if ($item->files->count() > 0)
                                                    <i class="fa fa-paperclip paperclip"></i>
                                                @endif
                                                {{ $item->created_at->format('d M') }}
                                            </span>
                                            <span class="from">{{ $item->sender->name }}</span>
                                            <p class="msg">{{ $item->subject }}</p>

                                            <div class="actions mt-2">
                                                <button class="btn btn-success btn-sm restore-message"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fa fa-undo"></i> Restaurar
                                                </button>
                                                <button class="btn btn-danger btn-sm delete-message"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fa fa-trash"></i> Eliminar definitivamente
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="email-list-detail">
                                    <p class="msg text-center">No tienes mensajes en la papelera.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert y AJAX para restaurar o eliminar --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Restaurar mensaje
            document.querySelectorAll('.restore-message').forEach(button => {
                button.addEventListener('click', function() {
                    let messageId = this.getAttribute('data-id');

                    Swal.fire({
                        title: "¿Restaurar mensaje?",
                        text: "El mensaje volverá a la bandeja de entrada.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#28a745",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, restaurar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/mensajes/${messageId}/restore`, {
                                method: "PATCH",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                }
                            }).then(response => {
                                if (response.ok) {
                                    Swal.fire("Restaurado",
                                            "El mensaje ha sido restaurado.",
                                            "success")
                                        .then(() => location.reload());
                                } else {
                                    Swal.fire("Error",
                                        "No se pudo restaurar el mensaje.",
                                        "error");
                                }
                            });
                        }
                    });
                });
            });

            // Eliminar mensaje definitivamente
            document.querySelectorAll('.delete-message').forEach(button => {
                button.addEventListener('click', function() {
                    let messageId = this.getAttribute('data-id');

                    Swal.fire({
                        title: "¿Eliminar permanentemente?",
                        text: "Esta acción no se puede deshacer.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Sí, eliminar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/mensajes/${messageId}/force-delete`, {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                }
                            }).then(response => {
                                if (response.ok) {
                                    Swal.fire("Eliminado",
                                            "El mensaje ha sido eliminado definitivamente.",
                                            "success")
                                        .then(() => location.reload());
                                } else {
                                    Swal.fire("Error",
                                        "No se pudo eliminar el mensaje.",
                                        "error");
                                }
                            });
                        }
                    });
                });
            });
        });
    </script>
@endsection
