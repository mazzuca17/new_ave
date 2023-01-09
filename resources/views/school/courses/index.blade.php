<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class='card-header'>
                <div class='card-title'>Cursos</div>
            </div>
            <div class="table-responsive">
                @if (isset($cursos[0]))

                    <table id="example" class="table table-striped" style="width:100%">
                        <tbody>
                            @foreach ($cursos as $item)
                                <tr class="row100 body">
                                    <td class="cell100">
                                        <div class='d-flex'>
                                            <div class='flex-1 pt-1 ml-2'>
                                                <h4 class='fw-bold mb-1'>
                                                    {{ $item->name }}
                                                </h4>
                                                <br>
                                            </div>
                                            <div class='d-flex ml-auto align-items-center'>
                                                <a class='btn btn-primary  ml-auto' href="">
                                                    Más info.</a>
                                            </div>
                                        </div>
                                        <div class='separator-dashed'></div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="card-footer">
                <a href="" class="btn btn-success">Cargar evento</a>
                <a href='eventos.php' class='btn btn-success ml-auto'>Ver todos</a>
            </div>
        </div>



    </div>
</div>

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
