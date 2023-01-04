<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Inicio | AVE Alumnos | The Bildung Company</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('img/logo-1.png') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ["{{ asset('css/fonts.min.css') }}"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/atlantis.min.css') }}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}">
</head>

<body>
    <div class="wrapper overlay-sidebar">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark2">

                <a href="inicio.php" class="logo">
                    <img src="{{ asset('img/logo-1.png') }}" alt="navbar brand" class="navbar-brand" width="50%"
                        heigth="500px">
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle sidenav-overlay-toggler">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="dark2">

                <div class="container-fluid">
                    <div class="collapse" id="search-nav">

                        <h2 class="text-white">
                            <?php
                            //Se define el timezone que sea necesario
                            date_default_timezone_set('America/Argentina/Buenos_Aires');
                            
                            //Dia-Mes-Año Hora:Minutos:Segundos
                            $fecha = date('d-m-Y');
                            echo $fecha;
                            
                            ?>

                        </h2>
                    </div>
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item dropdown hidden-caret">
                            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="fas fa-layer-group"></i>
                            </a>
                            <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                                <div class="quick-actions-header">
                                    <span class="title mb-1">Acciones rápidas</span>
                                </div>
                                <div class="quick-actions-scroll scrollbar-outer">
                                    <div class="quick-actions-items">
                                        <div class="row m-0">
                                            <a class="col-6 col-md-4 p-0" href="eventos.php">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-calendar"></i>
                                                    <span class="text">Ver evento</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="misdatos.php">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-database"></i>
                                                    <span class="text">Mis datos</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="subirentrega.php">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-pen"></i>
                                                    <span class="text">Nueva entrega</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="entregas.php">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-message"></i>
                                                    <span class="text">Ver entregas</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="misnotas.php">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-check"></i>
                                                    <span class="text">Mis notas</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="elegirfotoperfil.php">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-user"></i>
                                                    <span class="text">Cambiar foto de perfil</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="micurso.php">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-file"></i>
                                                    <span class="text">Mi curso</span>
                                                </div>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item toggle-nav-search hidden-caret">
                            <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button"
                                aria-expanded="false" aria-controls="search-nav">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>


                        <!-- Sección perfil-->
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <div class='avatar-sm float-left mr-2'><img src='{{ asset('img/profile.jpg') }}'
                                        class='avatar-img'></div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="../ayuda.html">Ayuda</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                            href="../codigosphp/cerrarsesion-alumno.php">Salir</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                        <!-- FIN Sección perfil-->
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>


        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <!-- Usuario-->
                    <div class="user">
                        <div class='avatar-sm float-left mr-2'><img src='{{ asset('img/profile.jpg') }}'
                                class='avatar-img rounded-circle'></div>
                        <div class="info">
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


        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-dark-gradient">
                    <div class="page-inner py-5">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h4 class="text-white op-7 mb-2">Un servicio de The Bildung Company.</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">

                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul class="nav">

                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    V3.0
                                </a>
                            </li>

                        </ul>
                    </nav>
                    <div class="copyright ml-auto">
                        <script>
                            var today = new Date;
                            var year = today.getFullYear();
                            document.write(year + "- AVE Alumnos - Un servicio de The Bildung Company - Todos los derechos reservados");
                        </script>
                    </div>
                </div>
            </footer>
        </div>



    </div>

    <!--   Core JS Files   -->
    <script src="{{ asset('js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>


    <!-- Chart JS -->
    <script src="{{ asset('js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('js/plugin/datatables/datatables.min.js') }}"></script>
    <!-- jQuery Vector Maps -->
    <script src="{{ asset('js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Atlantis JS -->
    <script src="{{ asset('js/atlantis.min.js') }}"></script>

    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="{{ asset('js/setting-demo.js') }}"></script>
    <script src="{{ asset('js/demo.js') }}"></script>
    <script>
        $('#lineChart').sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: '#177dff',
            fillColor: 'rgba(23, 125, 255, 0.14)'
        });

        $('#lineChart2').sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: '#f3545d',
            fillColor: 'rgba(243, 84, 93, .14)'
        });

        $('#lineChart3').sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: '#ffa534',
            fillColor: 'rgba(255, 165, 52, .14)'
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({});

            $('#multi-filter-select').DataTable({
                "pageLength": 5,
                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        var select = $(
                                '<select class="form-control"><option value=""></option></select>'
                            )
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d + '">' + d +
                                '</option>')
                        });
                    });
                }
            });

            // Add Row
            $('#add-row').DataTable({
                "pageLength": 5,
            });

            var action =
                '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

            $('#addRowButton').click(function() {
                $('#add-row').dataTable().fnAddData([
                    $("#addName").val(),
                    $("#addPosition").val(),
                    $("#addOffice").val(),
                    action
                ]);
                $('#addRowModal').modal('hide');

            });
        });
    </script>
</body>

</html>
