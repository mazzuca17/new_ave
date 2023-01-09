@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner mt--20">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 ml-auto mr-auto">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Eventos.</div>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('school.events.create') }}" class="btn btn-primary btn-create_account"
                                    style="margin-block-end:  1rem !important;">Nuevo evento</a>

                                <div class="table-responsive">


                                    <table id="example" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Autor</th>
                                                <th>Materia</th>
                                                <th>Título</th>
                                                <th>Descripción</th>
                                                <th>Fecha</th>
                                                <th>Curso</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($events as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->author->name }}</td>
                                                    <td>{{ $item->materia ? $item->materia->nombre : ' - ' }}</td>
                                                    <td>{{ $item->title }}</td>
                                                    <td>{{ $item->description }}</td>
                                                    <td> {{ $item->fecha }} </td>
                                                    <td> {{ $item->curso ? $item->curso->name : 'General' }} </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <a href="{{ route('school.events.edit', ['event_id' => $item->id]) }}"
                                                                    class="btn btn-success">Editar</a>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
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
            $('#example').DataTable();
        });
    </script>
@endsection
