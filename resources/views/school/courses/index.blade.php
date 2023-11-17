@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner mt--20">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class='card-header'>
                                <div class='card-title'>Cursos</div>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('school.courses.new') }}" class="btn btn-primary btn-create_account"
                                    style="margin-block-end:  1rem !important;">Nuevo curso</a>

                                <div class="table-responsive">

                                    <table id="example" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th><b>Curso<b></th>
                                                <th><b>Cantidad de alumnos<b></th>
                                                <th><b>Acciones<b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($courses[0]))
                                                @foreach ($courses as $item)
                                                    <tr class="row100 body">
                                                        <td class="cell100">

                                                            {{ $item->name }}
                                                        </td>
                                                        <td class="cell100"></td>
                                                        <td class="cell100">
                                                            <a class='btn btn-primary  ml-auto' href="">
                                                                Más info.</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
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
@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endpush
