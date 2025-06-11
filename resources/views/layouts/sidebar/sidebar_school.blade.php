<li class="nav-item">
    <a data-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
        <i class="fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="dashboard">
        <ul class="nav nav-collapse">
            <li>
                <a href="{{ route('school.dashboard') }}">
                    <span class="sub-item">Ver dashboard</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a data-toggle="collapse" href="#ciclo_lectivo" class="collapsed" aria-expanded="false">
        <i class="fas fa-tachometer-alt"></i>
        <p>Ciclo lectivo</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="ciclo_lectivo">
        <ul class="nav nav-collapse">
            <li>
                <a href="{{ route('school.ciclos.dashboard') }}">
                    <span class="sub-item">Ver ciclos lectivos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('school.ciclos.dashboard') }}">
                    <span class="sub-item">Crear ciclos lectivos</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a data-toggle="collapse" href="#cursos" class="collapsed" aria-expanded="false">
        <i class="fas fa-book-open"></i>
        <p>Cursos</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="cursos">
        <ul class="nav nav-collapse">
            <li>
                <a href="{{ route('school.courses.index') }}">
                    <span class="sub-item">Ver cursos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('school.courses.new') }}">
                    <span class="sub-item">Crear curso</span>
                </a>
            </li>
            <hr>
            <li>
                <a href="{{ route('school.courses.orientation.index') }}">
                    <span class="sub-item">Ver orientaciones</span>
                </a>
            </li>
            <li>
                <a href="{{ route('school.courses.orientation.create') }}">
                    <span class="sub-item">Crear orientaciones</span>
                </a>
            </li>

        </ul>
    </div>
</li>

<li class="nav-item">
    <a data-toggle="collapse" href="#materias" class="collapsed" aria-expanded="false">
        <i class="fas fa-chalkboard-teacher"></i>
        <p>Materias</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="materias">
        <ul class="nav nav-collapse">
            <li>
                <a href="{{ route('school.materias.index') }}">
                    <span class="sub-item">Ver materias</span>
                </a>
            </li>
            <li>
                <a href="{{ route('school.materias.create') }}">
                    <span class="sub-item">Crear materias</span>
                </a>
            </li>

        </ul>
    </div>
</li>

<li class="nav-item">
    <a data-toggle="collapse" href="#alumnos" class="collapsed" aria-expanded="false">
        <i class="fas fa-user-graduate"></i>
        <p>Alumnos</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="alumnos">
        <ul class="nav nav-collapse">
            <li>
                <a href="{{ route('school.alumnos.index') }}">
                    <span class="sub-item">Ver alumnos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('school.alumnos.new') }}">
                    <span class="sub-item">Crear alumnos</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="sub-item">Carga masiva</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a data-toggle="collapse" href="#profesores" class="collapsed" aria-expanded="false">
        <i class="fas fa-users"></i>
        <p>Profesores</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="profesores">
        <ul class="nav nav-collapse">
            <li>
                <a href=" {{ route('school.docentes.index') }} ">
                    <span class="sub-item">Ver profesores</span>
                </a>
            </li>
            <li>
                <a href=" {{ route('school.docentes.new') }} ">
                    <span class="sub-item">Crear profesores</span>
                </a>
            </li>

        </ul>
    </div>
</li>

<li class="nav-item">
    <a data-toggle="collapse" href="#mensajería" class="collapsed" aria-expanded="false">
        <i class="fas fa-bullhorn"></i>
        <p>Mensajería</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="mensajería">
        <ul class="nav nav-collapse">
            <li>
                <a href="{{ route('mensajes.index') }}">
                    <span class="sub-item">Ver mensajes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('mensajes.create') }}">
                    <span class="sub-item">Nuevo mensaje</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a data-toggle="collapse" href="#asistencia" class="collapsed" aria-expanded="false">
        <i class="fas fa-calendar-check"></i>
        <p>Asistencia</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="asistencia">
        <ul class="nav nav-collapse">
            <li>
                <a href="#">
                    <span class="sub-item">Ver asistencia</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="sub-item">Crear registro</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a data-toggle="collapse" href="#configuracion" class="collapsed" aria-expanded="false">
        <i class="fas fa-cogs"></i>
        <p>Configuración</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="configuracion">
        <ul class="nav nav-collapse">
            <li>
                <a href="{{ route('school.grading_schemes.index') }}">
                    <span class="sub-item">Esquemas de calificación</span>
                </a>
            </li>
            <li>
                <a href="{{ route('school.academic_periods.index') }}">
                    <span class="sub-item">Períodos académicos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('school.educational_level.index') }}">
                    <span class="sub-item">Nivel académicos</span>
                </a>
            </li>
        </ul>
    </div>
</li>
