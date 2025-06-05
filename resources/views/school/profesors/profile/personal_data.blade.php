   <!-- Contenido de las pestañas -->
   <div class="tab-content" id="myTabContent">
       <!-- Datos del Alumno -->
       <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
           <div class="row mt-3">
               <div class="col-md-6">
                   <p><strong>Email:</strong> {{ $prof->user->email }}</p>
                   <p><strong>DNI:</strong> {{ $prof->dni }}</p>
                   <p><strong>Fecha de Nacimiento:</strong> {{ $prof->fecha_nacimiento }}</p>
                   <p><strong>Género:</strong> {{ ucfirst($prof->genero) }}</p>
               </div>
               <div class="col-md-6">
                   <p><strong>Dirección:</strong> {{ $prof->direccion }}</p>
                   <p><strong>Teléfono:</strong> {{ $prof->telefono }}</p>
                   <p><strong>Nacionalidad:</strong> {{ $prof->nacionalidad }}</p>
                   <p><strong>Condición:</strong> {{ ucfirst($prof->condition) }}</p>
               </div>
           </div>
       </div>


   </div>
