 <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
     <div class="quick-actions-header">
         <span class="title mb-1">Acciones rápidas</span>
     </div>
     <div class="quick-actions-scroll scrollbar-outer">
         <div class="quick-actions-items">
             <div class="row m-0">
                 @if (Auth::user()->role->role_id == 1)
                     @include('layouts.actions.admin_actions')
                 @else
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
                 @endif


             </div>
         </div>
     </div>
 </div>
