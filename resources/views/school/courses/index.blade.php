@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner mt--20">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
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
                            <div class='card-header d-flex justify-content-between align-items-center'>
                                <div class='card-title'>Cursos</div>
                                <div>
                                    <button id="reloadTable" class="btn btn-secondary">Actualizar</button>
                                    <a href="{{ route('school.courses.new') }}" class="btn btn-primary">Nuevo curso</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="coursesTable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Curso</th>
                                                <th>Nivel</th>
                                                <th>Orientación</th>
                                                <th>Cantidad de alumnos</th>
                                                <th>Cantidad de materias</th>

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
            let table = $('#coursesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('school.courses.data') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'level',
                        name: 'level'
                    },
                    {
                        data: 'orientation',
                        name: 'orientation'
                    },

                    {
                        data: 'students_count',
                        name: 'students_count',
                        defaultContent: '0'
                    },
                    {
                        data: 'materias_count',
                        name: 'materias_count',
                        defaultContent: '0'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                }
            });

            $('#reloadTable').on('click', function() {
                table.ajax.reload();
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('click', '.delete-course', function() {
            let courseId = $(this).data('id');

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/school/courses/delete/' + courseId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Eliminado',
                                text: 'El curso ha sido eliminado correctamente.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            $('#coursesTable').DataTable().ajax.reload();
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error',
                                text: 'No se pudo eliminar el curso.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
