<div class="row">
    <!-- Tarjeta: Total de Alumnos -->
    <div class="col-md-3">
        <div class="card card-primary shadow-lg border-0 rounded-lg card-primary text-white">
            <div class="card-body d-flex align-items-center">
                <div class="row">


                    <div class="col-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div class="col-9 text-end">
                        <h5 class="fw-bold mb-1">Total de Alumnos</h5>
                        <h3 class="fw-bold">{{ $totalAlumnos }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta: Total Eventos -->
    <div class="col-md-3">
        <div class="card shadow-lg border-0 rounded-lg card-secondary text-white">
            <div class="card-body d-flex align-items-center">
                <div class="row">


                    <div class="col-3">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                    <div class="col-9 text-end">
                        <h5 class="fw-bold mb-1">Total Eventos</h5>
                        <h3 class="fw-bold">{{ $totalEventos }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta: Total de Cursos -->
    <div class="col-md-3">
        <div class="card shadow-lg border-0 rounded-lg card-success text-white">
            <div class="card-body d-flex align-items-center">
                <div class="row">


                    <div class="col-3">
                        <i class="fas fa-book fa-2x"></i>
                    </div>
                    <div class="col-9 text-end">
                        <h5 class="fw-bold mb-1">Total de Cursos</h5>
                        <h3 class="fw-bold">{{ $totalCursos }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
