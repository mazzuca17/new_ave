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
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <span class="link-collapse">{{ __('Cerrar sesión') }}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                @if (Auth::user()->role->role_id == 1)
                    @include('layouts.sidebar.sidebar_admin')
                @endif

                @if (Auth::user()->role->role_id == 2)
                @endif

                @if (Auth::user()->role->role_id == 3)
                @endif

                @if (Auth::user()->role->role_id == 4)
                @endif



            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
