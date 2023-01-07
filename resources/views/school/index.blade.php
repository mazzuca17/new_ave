@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="panel-header bg-dark-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white op-7 mb-2">Hola {{ Auth::user()->name }}! Bienvenido a AVE </h2>
                        <h4 class="text-white op-7 mb-2">Un servicio de The Bildung Company.</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary bg-primary-gradient">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h3 class="card-title"><b>Eventos (últimos 10).<b></h3>
                            </div>
                        </div>
                        <div class="card-body">


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
                                <a href='eventos.php' class='btn btn-success ml-auto'>Ver todos los eventos</a>

                            </div>
                        </div>
                    </div>
                </div>


            </div>


            <!-- FIN informar eventos-->

            <!-- Sección de cursos-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">


                        <div class='card-header'>
                            <div class='card-title'>Cursos</div>
                        </div>
                        <?php
                        //$sentencia = "SELECT * FROM apuntes";
                        
                        // $sentencia = "SELECT * FROM cursos WHERE id_colegio = '$id_colegio' GROUP BY curso";
                        
                        // ($resultado = $link->query($sentencia)) or die(mysqli_error($link));
                        // $num = 1;
                        
                        // while ($fila = $resultado->fetch_assoc()) {
                        //     echo "<div class='card-body pb-0'>";
                        
                        //     echo "<div class='d-flex'>";
                        //     echo "<div class='flex-1 pt-1 ml-2'>";
                        //     echo "<h4 class='fw-bold mb-1'>";
                        //     echo $fila['curso'];
                        //     echo '</h4>';
                        //     echo "<small class='text-muted'>";
                        //     echo 'Modalidad: ';
                        //     echo $fila['modalidad'];
                        //     echo '</small>';
                        //     echo '<br>';
                        
                        //     echo '</div>';
                        //     echo "<div class='d-flex ml-auto align-items-center'>";
                        //     echo "<a class='btn btn-primary  ml-auto'  href='cursos.php?c=";
                        //     echo $fila['curso'];
                        //     echo "'>";
                        //     echo 'Más info.';
                        //     echo '</a></td>';
                        
                        //     echo '</div>';
                        //     echo '</div>';
                        //     echo "<div class='separator-dashed'></div>";
                        
                        //     echo '</div>';
                        // }
                        
                        //
                        ?>
                    </div>
                </div>

            </div>
            <!-- FIN Sección de cursos-->

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
