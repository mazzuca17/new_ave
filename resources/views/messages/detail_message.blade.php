@extends('layouts.app_system')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/messages.css') }}">

    <div class="content">
        <div class="container container-full" style="max-width: none !important">
            <div class="page-inner page-inner-fill">
                <div class="page-with-aside mail-wrapper bg-white">
                    @include('messages.options')
                    <div class="page-content mail-content">
                        @if (session('status'))
                            <div class="alert alert-success" id="success-alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="email-head d-lg-flex d-block align-items-center justify-content-between">

                            <h3 class="text-bold">
                                <b> {{ $data_message->subject }}
                                </b>
                            </h3>
                        </div>

                        <div class="email-sender d-flex align-items-center justify-content-between mt-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar mr-3">
                                    <img src="{{ $data_message->email->sender->avatar_url ?? asset('img/profile.jpg') }}"
                                        alt="Avatar de {{ $data_message->email->sender->name }}"
                                        style="width: 40px; height: 40px; border-radius: 50%;">
                                </div>
                                <div class="sender">
                                    <strong>De:
                                        <b>
                                            {{ $data_message->email->sender->name }}
                                        </b>
                                    </strong> <br>
                                    Para <span class="to">mí</span>

                                </div>
                            </div>
                            <div class="date text-muted">
                                {{ $data_message->email->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div class="email-body mt-4">
                            {!! $data_message->email->body !!}
                        </div>


                        @if ($data_message->email->attachments->count())
                            <div class="email-attachments mt-4">
                                <h5 class="mb-3">
                                    <i class="fa fa-paperclip"></i> Adjuntos
                                    <span class="text-muted">({{ $data_message->email->attachments->count() }}
                                        archivo{{ $data_message->email->attachments->count() > 1 ? 's' : '' }})</span>
                                </h5>

                                <div class="list-group">
                                    @foreach ($data_message->email->attachments as $attachment)
                                        <div
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-file mr-2 text-primary"></i>
                                                <strong>{{ basename($attachment->file_path) }}</strong>
                                            </div>
                                            <div class="btn-group">
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                    class="btn btn-sm btn-outline-success" download>
                                                    <i class="fa fa-download"></i> Descargar
                                                </a>
                                                <button class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                                    data-target="#viewModal-{{ $attachment->id }}">
                                                    <i class="fa fa-eye"></i> Ver
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="viewModal-{{ $attachment->id }}" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Vista previa:
                                                            {{ basename($attachment->file_path) }}</h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        @php
                                                            $ext = pathinfo($attachment->file_path, PATHINFO_EXTENSION);
                                                        @endphp

                                                        @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                                            <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                                                class="img-fluid rounded shadow">
                                                        @elseif (in_array($ext, ['pdf']))
                                                            <embed src="{{ asset('storage/' . $attachment->file_path) }}"
                                                                type="application/pdf" width="100%" height="600px" />
                                                        @else
                                                            <div class="alert alert-info">
                                                                Este tipo de archivo no tiene vista previa disponible.
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="email-body mt-4">
                            <form class="border_form_response"
                                action="{{ route('mensajes.reply', $data_message->email->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Respuesta:</label>
                                    <textarea id="editor" name="body"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Adjuntar archivos:</label>
                                </div>

                                <div class="form-group d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="custom-file-upload">
                                        <button type="button" class="btn btn-secondary" id="uploadButton">
                                            <i class="fas fa-paperclip"></i> Adjuntar archivos
                                        </button>
                                        <input type="file" id="attachments" name="attachments[]" multiple
                                            style="display: none;">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-reply"></i> Enviar respuesta
                                            </button>
                                            <a href="{{ route('mensajes.index') }}" class=" text-white btn btn-danger">
                                                Descartar
                                            </a>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>




                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap (si usas BS4) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- Summernote -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Ocultar automáticamente después de 3 segundos
            setTimeout(function() {
                $('#success-alert').fadeOut('slow');
            }, 3000); // 3000 milisegundos = 3 segundos
        });
    </script>

    <script>
        jQuery(document).ready(function($) {
            $('#editor').summernote({
                height: 300,
                placeholder: 'Escribe el mensaje...',
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        });

        jQuery(document).ready(function($) {
            $('#uploadButton').on('click', function() {
                $('#attachments').click();
            });

            $('#attachments').on('change', function() {
                let files = $(this)[0].files;
                let fileNames = [];
                for (let i = 0; i < files.length; i++) {
                    fileNames.push(files[i].name);
                }
                $('#fileList').text(fileNames.length > 0 ? fileNames.join(', ') :
                    'Ningún archivo seleccionado');
            });

            $('#editor').summernote({
                height: 300,
                placeholder: 'Escribe el mensaje...',
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });

            $('#messageForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                formData.append('message', $('#editor').summernote('code'));

                $.ajax({
                    url: "{{ route('mensajes.send') }}", // Ruta del backend
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Mensaje Enviado',
                            text: 'El mensaje se ha enviado correctamente.',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = Object.values(errors).map(error => error.join(
                                ', ')).join('<br>');

                            Swal.fire({
                                icon: 'error',
                                title: 'Error de Validación',
                                html: errorMessages,
                                confirmButtonColor: '#d33'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un problema al enviar el mensaje. Intenta nuevamente.',
                                confirmButtonColor: '#d33'
                            });
                        }
                    }
                });
            });
        });
    </script>

@endsection
