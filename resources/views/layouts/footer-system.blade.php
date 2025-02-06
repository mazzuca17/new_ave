@php
    $user = Auth::user();
    // Valor por defecto si el usuario no tiene roles asignados
    $roleText = $user->roles[0]->name;

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
                var today = new Date();
                var year = today.getFullYear();
                document.write(year +
                    "- AVE {{ $roleText }} - Un servicio de The Bildung Company - Todos los derechos reservados");
            </script>
        </div>
    </div>
</footer>
