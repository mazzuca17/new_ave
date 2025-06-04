@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Crear curso.</h4>
            </div>

            <div class="row">
                <div class="col-md-8 ml-auto mr-auto">
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if (Session::has('danger'))
                        <div class="alert alert-danger">
                            {{ Session::get('danger') }}
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Crear curso</div>
                        </div>

                        <form action="{{ route('school.courses.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group form-group-default">
                                    <label>Curso</label>
                                    <input type="text" class="form-control" placeholder="Curso (ejemplo: 3° A)"
                                        name="curso" required>
                                </div>

                                <div class="form-group form-group-default">
                                    <label for="nivel">Nivel</label>
                                    <select class="form-control" name="nivel" id="nivel" required
                                        onchange="toggleOrientacion()">
                                        <option value="">Seleccionar nivel</option>
                                        <option value="Primaria">Primaria</option>
                                        <option value="Secundaria">Secundaria</option>
                                    </select>
                                </div>


                                <div class="form-group form-group-default" id="orientacion-group" style="display: none;">
                                    <label for="orientacion_id">Orientación</label>
                                    <select class="form-control" name="orientacion_id" id="orientacion_id">
                                        <option value="">Seleccionar orientación</option>
                                        @foreach ($orientation as $orientacion)
                                            <option value="{{ $orientacion->id }}">
                                                {{ $orientacion->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="card-action">
                                <button class="btn btn-success" name="submit">Crear curso</button>
                                <a href="{{ route('school.courses.index') }}" class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleOrientacion() {
            const nivel = document.getElementById('nivel').value;
            const orientacionGroup = document.getElementById('orientacion-group');

            if (nivel === 'Secundaria' || nivel === 'Técnica') {
                orientacionGroup.style.display = 'block';
            } else {
                orientacionGroup.style.display = 'none';
            }
        }
    </script>
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const nivel = document.getElementById('nivel').value;
            const orientacion = document.getElementById('orientacion_id').value;

            if ((nivel === 'Secundaria' || nivel === 'Técnica') && !orientacion) {
                e.preventDefault();
                alert('Debe seleccionar una orientación para el nivel seleccionado.');
            }
        });
    </script>
@endsection
