@extends('layouts.app_system')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

    <div class="content">
        <div class="panel-header bg-dark-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white op-7 mb-2">¡Hola {{ Auth::user()->name }}!</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="card card-entradas-borrador">
                            <div class="card-body">
                                <a href="{{ route('admin.schools.create') }}" class="btn btn-primary btn-create_account"
                                    style="margin-block-end:  1rem !important;">Registar nuevo establecimiento</a>

                                <div class="table-responsive">


                                    <table id="example" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($schools as $item)
                                                <tr>
                                                    <td>{{ $item->user_id }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->user->email }}</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-toggle="modal" data-target="#exampleModal">
                                                                    {{ $item->is_active ? 'Desactivar' : 'Activar' }} cuenta
                                                                </button>
                                                                @include('superadmin.confirm_inactive')

                                                            </div>
                                                            <div class="col-md-6">
                                                                <a href="{{ route('admin.schools.edit', ['id' => $item->user_id]) }}"
                                                                    class="btn btn-success">Editar cuenta</a>
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
