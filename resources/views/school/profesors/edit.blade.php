@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Editar Docente</h4>
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
                            <h5 class="card-title">Datos del Docente</h5>
                        </div>

                        <form action="{{ route('school.docentes.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="mt-3">Datos personales </h5>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="hidden" name="profesor_id" value="{{ $docente->id }}">
                                        <div class="form-group form-group-default">
                                            <label>Apellido</label>
                                            <input type="text" class="form-control" name="last_name"
                                                value="{{ old('last_name', $docente->user->last_name) }}" required>
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Nombre</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name', $docente->user->name) }}" required>
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email', $docente->user->email) }}" required>
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>DNI</label>
                                            <input type="number" class="form-control" name="dni"
                                                value="{{ old('dni', $docente->dni) }}" required>
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Fecha de Nacimiento</label>
                                            <input type="date" class="form-control" name="fecha_nacimiento"
                                                value="{{ old('fecha_nacimiento', $docente->fecha_nacimiento) }}">
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Género</label>
                                            <select class="form-control" name="genero">
                                                <option value="">Seleccione</option>
                                                <option value="masculino"
                                                    {{ old('genero', $docente->genero) == 'masculino' ? 'selected' : '' }}>
                                                    Masculino</option>
                                                <option value="femenino"
                                                    {{ old('genero', $docente->genero) == 'femenino' ? 'selected' : '' }}>
                                                    Femenino</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Dirección</label>
                                            <input type="text" class="form-control" name="direccion"
                                                value="{{ old('direccion', $docente->direccion) }}">
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Teléfono</label>
                                            <input type="text" class="form-control" name="telefono"
                                                value="{{ old('telefono', $docente->telefono) }}">
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Nacionalidad</label>
                                            <input type="text" class="form-control" name="nacionalidad"
                                                value="{{ old('nacionalidad', $docente->nacionalidad) }}">
                                        </div>

                                        <div class="form-group form-group-default">
                                            <label>Foto de perfil</label>
                                            <div class="card-body pt-0">
                                                <div class="setting-card">
                                                    <div class="logo-content mt-4">
                                                        <a href="{{ $docente->user->image_profile ? asset('storage/' . $docente->user->image_profile) : 'https://via.placeholder.com/150' }}"
                                                            target="_blank">
                                                            <img id="preview-image"
                                                                src="{{ $docente->user->image_profile ? asset('storage/' . $docente->user->image_profile) : 'https://via.placeholder.com/150' }}"
                                                                alt="Tu imagen" width="150px" class="big-logo">
                                                        </a>
                                                    </div>

                                                    <div class="choose-files mt-5">
                                                        <label for="profile_photo">
                                                            <div class="btn btn-sm btn-info">
                                                                <i class="ti ti-upload px-1"></i>
                                                                {{ __('Elige una foto aquí') }}
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
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success">Actualizar Docente</button>
                                <a href="{{ route('school.docentes.index') }}" class="btn btn-danger">Cancelar</a>
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
