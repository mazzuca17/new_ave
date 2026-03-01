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

       @if (Auth::user()->hasRole('Docente') || Auth::user()->hasRole('Colegio'))
           <div class="tab-pane fade" id="cursos" role="tabpanel" aria-labelledby="cursos-tab">
               <div class="row mt-3">
                   <div class="col-12">
                       @if (isset($assignedCourses) && $assignedCourses->count())
                           <ul class="list-group">
                               @foreach ($assignedCourses as $course)
                                   <li class="list-group-item d-flex justify-content-between align-items-center">
                                       <span>{{ $course->curso_nombre }}</span>
                                       @if (!empty($course->ciclo_lectivo))
                                           <span class="badge bg-primary">{{ $course->ciclo_lectivo }}</span>
                                       @endif
                                   </li>
                               @endforeach
                           </ul>
                       @else
                           <p class="text-muted mb-0">No tiene cursos inscriptos.</p>
                       @endif
                   </div>
               </div>
           </div>

           <div class="tab-pane fade" id="materias" role="tabpanel" aria-labelledby="materias-tab">
               <div class="row mt-3">
                   <div class="col-12">
                       @if (isset($assignedSubjects) && $assignedSubjects->count())
                           <div class="table-responsive">
                               <table class="table table-striped mb-0">
                                   <thead>
                                       <tr>
                                           <th>Materia</th>
                                           <th>Curso</th>
                                           <th>Ciclo lectivo</th>
                                           <th>Estado</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @foreach ($assignedSubjects as $subject)
                                           <tr>
                                               <td>{{ $subject->materia_nombre }}</td>
                                               <td>{{ $subject->curso_nombre }}</td>
                                               <td>{{ $subject->ciclo_lectivo ?? 'Sin ciclo' }}</td>
                                               <td>
                                                   <span
                                                       class="badge {{ $subject->estado_asignacion === 'Actual' ? 'bg-success' : 'bg-secondary' }}">
                                                       {{ $subject->estado_asignacion }}
                                                   </span>
                                               </td>
                                           </tr>
                                       @endforeach
                                   </tbody>
                               </table>
                           </div>
                       @else
                           <p class="text-muted mb-0">No tiene materias asignadas.</p>
                       @endif
                   </div>
               </div>
           </div>
       @endif


   </div>
