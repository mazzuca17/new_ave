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
                                <div class='card-title'>Orientaciones de cursos</div>
                                <div>
                                    <a href="{{ route('school.courses.orientation.create') }}"
                                        class="btn btn-primary">Agregar nuevo
                                        orientación</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="cicloslectivosTable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
                                                <th>Última actualización</th>
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
                ajax: "{{ route('school.courses.orientation.data') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    }, {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'last_update',
                        name: 'last_update'
                    }, {
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
@endsection
