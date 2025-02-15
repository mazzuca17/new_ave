@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="container container-full" style="max-width: none !important">
            <div class="page-inner page-inner-fill">
                <div class="page-with-aside mail-wrapper bg-white">
                    @include('announcements.options')
                    <div class="page-content mail-content" style="width: 100% !important">
                        <div class="inbox-body">
                            <div class="page-content mail-content">
                                <div class="email-head d-lg-flex d-block">
                                    <h3>
                                        <i class="flaticon-pen mr-1"></i>
                                        Nuevo mensaje
                                    </h3>
                                </div>
                                <form id="messageForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="to" class="col-form-label col-md-1">Para :</label>
                                        <div class="col-md-11">
                                            <select class="form-control" name="to" id="to" required>
                                                <option value="0">Envio a todos</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        data-image="{{ $user->image_profile ?? 'default.jpg' }}">
                                                        <div class="d-flex align-items-center">


                                                            {{-- Nombre completo --}}
                                                            <span style="text-transform: uppercase; font-weight: bold;">
                                                                {{ strtoupper($user->last_name) }},
                                                            </span>
                                                            <span>{{ $user->name }}</span>

                                                            {{-- Rol --}}
                                                            <span class="ml-auto">
                                                                @if ($user->role_name == 'Alumno')
                                                                    <span class="badge badge-primary ml-2">(Alumno)</span>
                                                                @elseif ($user->role_name == 'Docente')
                                                                    <span class="badge badge-warning ml-2">(Profesor)</span>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="subject" class="col-form-label col-md-1">Asunto :</label>
                                        <div class="col-md-11">
                                            <input type="text" class="form-control" id="subject" name="subject"
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Mensaje:</label>
                                        <textarea id="editor" name="message"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Adjuntar archivos:</label>
                                        <div class="custom-file-upload">
                                            <button type="button" class="btn btn-secondary" id="uploadButton">
                                                <i class="fas fa-paperclip"></i> Adjuntar archivos
                                            </button>
                                            <span id="fileList">Ningún archivo seleccionado</span>
                                            <input type="file" id="attachments" name="attachments[]" multiple
                                                style="display: none;">
                                        </div>
                                    </div>

                                    <div class="email-action">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                        <button type="button" class="btn btn-danger">Cancelar</button>
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

        <script>
            $.noConflict();
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
                        url: "{{ route('school.mensajes.send') }}", // Ruta del backend
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

        <style>
            .custom-file-upload {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            #fileList {
                font-size: 14px;
                color: #555;
            }

            .badge-primary {
                background-color: #007bff;
                color: white;
            }

            .badge-warning {
                background-color: #ffc107;
                color: white;
            }

            .ml-auto {
                margin-left: auto;
            }

            .avatar-title {
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #f0f0f0;
                font-weight: bold;
            }
        </style>
    @endsection
