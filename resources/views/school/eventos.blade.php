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
            <tr class="row100 body">
                <td class="cell100">
                    {{$item['title']}}
                </td>
                <td class="cell100">
                    {{$item['materia_']}}
                </td>
                <td class="cell100">
                    {{$item['title']}}
                </td>
            </tr>
            {{-- <?php
            //$sentencia = "SELECT * FROM apuntes";
            $id = $_SESSION['id'];
            
            $sentencia = "SELECT E.id_colegio, E.nombre_evento, E.id_materia, E.comentarios, E.fecha, E.id_curso, M.asignatura, M.id_cursos, M.id_prof, C.id, C.curso, CO.id 
                                                                                                                                                                                                            													FROM evento E, materias M, cursos C, colegios CO 
                                                                                                                                                                                                            													WHERE M.id_cursos = C.id AND E.id_curso = M.id_cursos 
                                                                                                                                                                                                            													AND M.id_materia = E.id_materia AND E.id_colegio = CO.id 
                                                                                                                                                                                                            													GROUP BY M.asignatura ORDER BY fecha ASC LIMIT 10";
            ($resultado = $link->query($sentencia)) or die(mysqli_error($link));
            $num = 1;
            
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr class='row100 body'>";
                echo "<td class='cell100 column2'>";
                echo $fila['nombre_evento'];
                echo '</td>';
                echo "<td class='cell100 column3'>";
                echo $fila['asignatura'];
                echo '</td>';
                echo "<td class='cell100 column3'>";
                echo $fila['comentarios'];
                echo '</td>';
                echo "<td class='cell100 column3'>";
                echo $fila['curso'];
                echo '</td>';
                echo "<td class='cell100 column3'>";
                echo $fila['fecha'];
                echo '</td>';
            
                echo '</tr>';
            
                $num++;
            }
            
            ?> --}}

        </tbody>
    </table>

</div>
