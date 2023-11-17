@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Profesores</h4>

            </div>
            <div class="row">
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='card-header'>
                            <div class='d-flex align-items-center'>
                                <h4 class='card-title'></h4>
                            </div>
                        </div>
                        <div class='card-body'>
                            @if ($data)
                                <div class='table table-responsive'>
                                    <table id="add-row" class='table'>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Fecha registro</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($data as $item)
                                                <tr class='row100 body'>
                                                    <td class='cell100 column2'>
                                                        {{ $item->id }}
                                                    </td>
                                                    <td class='cell100 column2'>
                                                        {{ $item->name }}
                                                    </td>
                                                    <td class='cell100 column2'>
                                                        {{ $item->email }}
                                                    </td>
                                                    <td class='cell100 column2'>
                                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s') }}
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif


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
