@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Crear Alumno</h4>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10">
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif

                    @if (Session::has('danger'))
                        <div class="alert alert-danger">{{ Session::get('danger') }}</div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Datos del Alumno</h5>
                        </div>

                        <form action="{{ route('school.alumnos.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="mt-3">Datos personales </h5>
                                    </div>

                                    {{-- Columna izquierda --}}
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Apellido</label>
                                            <input type="text" class="form-control" name="last_name" required>
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Nombre</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>DNI</label>
                                            <input type="number" class="form-control" name="dni" required>
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Fecha de Nacimiento</label>
                                            <input type="date" class="form-control" name="fecha_nacimiento">
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Género</label>
                                            <select class="form-control" name="genero">
                                                <option value="">Seleccione</option>
                                                <option value="masculino">Masculino</option>
                                                <option value="femenino">Femenino</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Columna derecha --}}
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Dirección</label>
                                            <input type="text" class="form-control" name="direccion">
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Teléfono</label>
                                            <input type="text" class="form-control" name="telefono">
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Nacionalidad</label>
                                            <input type="text" class="form-control" name="nacionalidad">
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Curso</label>
                                            <select class="form-control" name="curso_id">
                                                <option value="">Seleccione el curso</option>
                                                @foreach ($cursos as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Foto de perfil</label>
                                            <div class="card-body pt-0">
                                                <div class="setting-card">
                                                    <div class="logo-content mt-4">
                                                        <a href="{{ isset($profile_photo) && !empty($profile_photo) ? asset('uploads/profile/' . $profile_photo) : 'https://via.placeholder.com/150' }}"
                                                            target="_blank">
                                                            <img id="preview-image"
                                                                src="{{ isset($profile_photo) && !empty($profile_photo) ? asset('uploads/profile/' . $profile_photo) : 'https://via.placeholder.com/150' }}"
                                                                alt="{{ __('Tu imagen') }}" width="150px" class="big-logo">
                                                        </a>
                                                    </div>

                                                    <div class="choose-files mt-5">
                                                        <label for="profile_photo">
                                                            <div class="btn btn-sm btn-info">
                                                                <i class="ti ti-upload px-1"></i>
                                                                {{ __('Elige un foto aquí') }}
                                                            </div>
                                                            <input type="file" class="form-control file d-none"
                                                                name="profile_photo" id="profile_photo"
                                                                data-filename="profile_photo" accept=".jpeg,.jpg,.png">
                                                        </label>
                                                    </div>

                                                    @error('profile_photo')
                                                        <div class="row">
                                                            <span class="invalid-logo" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Datos académicos --}}
                                    <div class="col-md-6">
                                        <h5 class="mt-3">Datos académicos</h5>
                                        <div class="form-group form-group-default">
                                            <label>Año de ingreso</label>
                                            <input type="year" class="form-control" name="anio_ingreso">
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Condición</label>
                                            <select class="form-control" name="condition">
                                                <option value="regular">Regular</option>
                                                <option value="aprobado">Aprobado</option>
                                                <option value="finales">Finales</option>
                                            </select>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Estado Matrícula</label>
                                            <select class="form-control" name="estado_matricula">
                                                <option value="">Seleccione el curso</option>
                                                <option value="inscrito">Inscrito</option>
                                                <option value="preinscrito">Preinscrito</option>
                                                <option value="baja">Baja</option>
                                                <option value="egresado">Egresado</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Datos del Tutor --}}
                                    <div class="col-md-6">
                                        <h5 class="mt-3">Datos del Tutor</h5>
                                        <div class="form-group form-group-default">
                                            <label>Nombre del Tutor</label>
                                            <input type="text" class="form-control" name="nombre_tutor">
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Teléfono del Tutor</label>
                                            <input type="text" class="form-control" name="telefono_tutor">
                                        </div>
                                    </div>

                                    {{-- Información Médica --}}
                                    <div class="col-md-6">
                                        <h5 class="mt-3">Información Médica</h5>
                                        <div class="form-group form-group-default">
                                            <label>Alergias</label>
                                            <textarea class="form-control" name="alergias"></textarea>
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Seguro Médico</label>
                                            <input type="text" class="form-control" name="seguro_medico">
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Contacto de Emergencia</label>
                                            <input type="text" class="form-control" name="contacto_emergencia">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-success">Crear Alumno</button>
                                <a href="{{ route('school.alumnos.index') }}" class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('profile_photo').addEventListener('change', function(event) {
            let reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
            }

            if (event.target.files.length > 0) {
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    </script>
@endsection
