@extends('layouts.app_system')

@section('content')
    <!-- Select2 -->

    <div class="content">
        <div class="container container-full" style="max-width: none !important">
            <div class="page-inner page-inner-fill">
                <div class="page-with-aside mail-wrapper bg-white">
                    @include('messages.options')
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
                                            <select class="form-control" name="to" id="to" required
                                                style="width: 100%">

                                                @if (Auth::user()->hasRole('Colegio'))
                                                    <option value="0">Todos los usuarios</option>
                                                    <option value="role:Padre">Todos los padres</option>
                                                    <option value="role:Alumno">Todos los alumnos</option>
                                                    <option value="role:Profesor">Todos los profesores</option>
                                                @endif

                                                @if (Auth::user()->hasRole('Docente'))
                                                    <option value="role:Alumno">Todos los alumnos</option>
                                                @endif

                                                @if (Auth::user()->hasRole('Alumno'))
                                                    <option value="role:Profesor">Todos los profesores</option>
                                                @endif

                                                @php $currentRole = null; @endphp

                                                @foreach ($users as $user)
                                                    @php
                                                        $role = $user->roles->first()->name ?? 'Otro';
                                                    @endphp

                                                    @if ($role !== $currentRole)
                                                        @if (!is_null($currentRole))
                                                            </optgroup>
                                                        @endif
                                                        <optgroup label="{{ $role }}">
                                                            @php $currentRole = $role; @endphp
                                                    @endif

                                                    <option value="{{ $user->id }}"
                                                        data-image="{{ $user->image_profile ?? 'default.jpg' }}">
                                                        {{ strtoupper($user->last_name) }}, {{ $user->name }}
                                                    </option>
                                                @endforeach

                                                @if (!is_null($currentRole))
                                                    </optgroup>
                                                @endif
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
                                                    <i class="fa fa-reply"></i> Enviar
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
                Swal.fire({
                    title: 'Enviando mensaje...',
                    html: 'Por favor espera',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
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

    <script>
        jQuery('#to').select2({
            templateResult: formatUserOption,
            templateSelection: formatUserOption,
            placeholder: "Selecciona un usuario",
            allowClear: false,
            width: 'resolve'
        });

        function formatUserOption(user) {
            if (!user.id) {
                return user.text;
            }
            console.log(user);
            const image = $(user.element).data('image_profile') || 'profile.jpg';
            const baseUrl = $(user.element).data('image_profile') ? '/storage/app/public/profile_images/' : '/img/';

            const $user = jQuery(`
        <span class="d-flex align-items-center">
            <img src="${baseUrl + image}" class="rounded-circle mr-2" style="width: 30px; height: 30px; object-fit: cover;">
            <span>${user.text}</span>
        </span>
    `);
            return $user;
        }
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

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            display: flex;
            align-items: center;
        }

        .select2-container .select2-selection--single {
            display: flex !important;
            height: 40px !important;
        }

        .select2-container--default .select2-results__option {
            padding-left: 10px;
        }
    </style>
@endsection
