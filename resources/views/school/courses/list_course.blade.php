<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Cursos</div>
            </div>
            <div class="table-responsive">
                @if (isset($cursos) && count($cursos) > 0)
                    <table class="table table-striped" style="width:100%">
                        <tbody>
                            @foreach ($cursos as $item)
                                <tr class="row100 body">
                                    <td class="cell100">
                                        <div class="d-flex">
                                            <div class="flex-1 pt-1 ml-2">
                                                <h4 class="fw-bold mb-1">
                                                    {{ $item->name }}
                                                </h4>
                                            </div>
                                            <div class="d-flex ml-auto align-items-center">
                                                <!-- La URL debe ser única para cada curso -->
                                                <a class="btn btn-primary ml-auto"
                                                    href="{{ route('school.courses.dashboard', ['id' => $item->id]) }}">
                                                    Ver más
                                                </a>
                                            </div>
                                        </div>
                                        <div class="separator-dashed"></div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No se encontraron cursos disponibles.</p>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('school.courses.new') }}" class="btn btn-success">Nuevo curso</a>
                <a href="{{ route('school.courses.index') }}" class="btn btn-success ml-auto">Ver todos</a>
            </div>
        </div>
    </div>
</div>
