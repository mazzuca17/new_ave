 <!-- Navbar Header -->
 <nav class="navbar navbar-header navbar-expand-lg" data-background-color="dark2">

     <div class="container-fluid">
         <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
             <li class="nav-item dropdown hidden-caret">
                 <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                     <i class="fas fa-layer-group"></i>
                 </a>
                 @include('layouts.acciones_rapidas')
             </li>

             <!-- Notificaciones -->
             <li class="nav-item dropdown hidden-caret">
                 <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="fa fa-bell"></i>
                     @if ($notifications->count() > 0)
                         <span class="notification">{{ $notifications->count() }}</span>
                     @endif
                 </a>
                 <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                     <li>
                         <div class="dropdown-title">
                             Tienes {{ $notifications->count() }} nuevas notificaciones
                         </div>
                     </li>
                     <li>
                         <div class="notif-scroll scrollbar-outer">
                             <div class="notif-center">
                                 @forelse ($notifications as $notification)
                                     <a href="{{ url('/mensajes/' . $notification->data['announcement_id']) }}">
                                         <div class="notif-icon notif-primary"> <i class="fa fa-envelope"></i> </div>
                                         <div class="notif-content">
                                             <span class="block">
                                                 {{ $notification->data['subject'] }}
                                             </span>
                                             <span class="time">
                                                 {{ $notification->created_at->diffForHumans() }}
                                             </span>
                                         </div>
                                     </a>
                                 @empty
                                     <a class="dropdown-item text-muted">No hay notificaciones</a>
                                 @endforelse
                             </div>
                         </div>
                     </li>
                     <li>
                         <a class="see-all" href="{{ route('notifications.index') }}">
                             Ver todas las notificaciones <i class="fa fa-angle-right"></i>
                         </a>
                     </li>
                 </ul>
             </li>
             <!-- Fin Notificaciones -->

             <!-- Sección perfil -->
             <li class="nav-item dropdown hidden-caret">
                 <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                     <div class='avatar-sm float-left mr-2'><img src='{{ asset('img/profile.jpg') }}'
                             class='avatar-img'></div>
                 </a>
                 <ul class="dropdown-menu dropdown-user animated fadeIn">
                     <div class="dropdown-user-scroll scrollbar-outer">
                         <li>
                             <div class="dropdown-divider"></div>
                             <a class="dropdown-item" href="../ayuda.html">Ayuda</a>
                             <div class="dropdown-divider"></div>
                             <a class="dropdown-item" href="{{ route('logout') }}"
                                 onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                 {{ __('Cerrar sesión') }}
                             </a>

                             <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                 @csrf
                             </form>
                         </li>
                     </div>
                 </ul>
             </li>
             <!-- FIN Sección perfil -->
         </ul>
     </div>
 </nav>
 <!-- End Navbar -->
