@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner mt--20">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif

                        @if (Session::has('danger'))
                            <div class="alert alert-danger">{{ Session::get('danger') }}</div>
                        @endif

                        <div class="card mb-3">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Carga masiva de materias</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('school.materias.bulk_store') }}" method="POST" enctype="multipart/form-data"
                                    class="d-flex gap-2 align-items-center">
                                    @csrf
                                    <input type="file" name="csv_file" class="form-control" accept=".csv,.txt" required>
                                    <button class="btn btn-primary">Subir CSV</button>
                                </form>
                                <small class="text-muted">Formato esperado: columnas <b>nombre</b>, <b>curso_id</b>.</small>
                            </div>
                        </div>

                        <div class="card">
                            <div class='card-header d-flex justify-content-between align-items-center'>
                                <div class='card-title'>Materias</div>
                                <a href="{{ route('school.materias.create') }}" class="btn btn-primary">Cargar materia</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="cicloslectivosTable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th>Curso</th>
                                                <th>Orientación</th>
                                                <th>Docentes</th>
                                                <th>Horario</th>
                                                <th>Cantidad de horas</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            let table = $('#cicloslectivosTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('school.materias.data') }}",
                columns: [{ data: 'code', name: 'code' }, { data: 'name', name: 'name' }, { data: 'course', name: 'course' },
                    { data: 'orientation_course', name: 'orientation_course' }, { data: 'profesores', name: 'profesores' },
                    { data: 'horarios', name: 'horarios' }, { data: 'total_horas', name: 'total_horas' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });

            $(document).on('click', '.delete-materia', function() {
                const id = $(this).data('id');
                if (!confirm('¿Seguro que querés eliminar esta materia?')) return;

                $.ajax({
                    url: `{{ url('/school/materias/delete') }}/${id}`,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        table.ajax.reload();
                    },
                    error: function() {
                        alert('No se pudo eliminar la materia.');
                    }
                });
            });
        });
    </script>
@endsection
