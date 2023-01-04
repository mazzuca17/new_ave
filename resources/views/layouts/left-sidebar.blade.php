<!-- Sidebar -->
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <!-- Usuario-->
            <div class="user">
                <div class='avatar-sm float-left mr-2'><img src='{{ asset('img/profile.jpg') }}'
                        class='avatar-img rounded-circle'></div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            <h4>{{ Auth::user()->name }}</h4>
                            <span class="user-level">{{ Auth::user()->email }}</span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="misdatos.php">
                                    <span class="link-collapse">Mis datos</span>
                                </a>
                            </li>
                            <li>
                                <a href="../../centroayuda.html" target="_blank">
                                    <span class="link-collapse">Ayuda</span>
                                </a>
                            </li>
                            <li>
                                <a href="elegirfotoperfil.php">
                                    <span class="link-collapse">Cambiar foto de perfil</span>
                                </a>
                            </li>

                            <li>
                                <a href="../codigosphp/cerrarsesion-alumno.php">
                                    <span class="link-collapse">Salir</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Materias</h4>
                </li>



                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Mi desempeño</h4>
                </li>
                <li class="nav-item">
                <li class="nav-item">
                    <a href="misnotas.php">Ver mis notas</a>
                </li>
                <li class="nav-item">
                    <a href="entregas.php">Ver mis entregas</a>
                </li>
                <li class="nav-item">
                    <a href="subirentrega.php">Hacer una nueva entrega</a>


                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Comunicación</h4>
                </li>
                <li class="nav-item">
                <li class="nav-item">
                    <a href="eventos.php">Ver eventos</a>
                </li>
                </li>
                <li class="nav-item">
                    <a href="micurso.php">Mí curso</a>
                </li>


                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
