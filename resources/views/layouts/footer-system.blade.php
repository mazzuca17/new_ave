@php
    $user = Auth::user();
    $text = 'Default'; // Valor por defecto si el usuario no tiene roles asignados

    if ($user && $user->role) {
        switch ($user->role->role_id) {
            case 1:
                $text = 'Superadmin';
                break;
            case 2:
                $text = 'Colegios';
                break;
            case 3:
                $text = 'Docentes';
                break;
            case 4:
                $text = 'Alumnos';
                break;
        }
    }
@endphp

<footer class="footer">
    <div class="container-fluid">
        <nav class="pull-left">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        V 3.0
                    </a>
                </li>
            </ul>
        </nav>
        <div class="copyright ml-auto">
            <script>
                var today = new Date;
                var year = today.getFullYear();
                document.write(year +
                    "- AVE {{ $text }} - Un servicio de The Bildung Company - Todos los derechos reservados");
            </script>
        </div>
    </div>
</footer>
