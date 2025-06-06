<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th><b>Nombre<b></th>
                <th><b>Materia<b></th>
                <th><b>Comentarios<b></th>
                <th><b>Curso<b></th>
                <th><b>Fecha<b></th>

            </tr>
        </thead>

        <tbody>
            @foreach ($course->eventos as $item)
                <tr class="row100 body">
                    <td class="cell100">
                        {{ $item['title'] }}
                    </td>
                    <td class="cell100">
                        {{ $item['materia']->nombre }}
                    </td>
                    <td class="cell100">
                        {{ $item['description'] }}
                    </td>
                    <td class="cell100">
                        {{ $item['curso']->name }}
                    </td>
                    <td class="cell100">
                        {{ $item['fecha'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
