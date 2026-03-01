@extends('layouts.app_system')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Perfil del Alumno</h4>
            </div>

            <div class="row">
                <!-- Columna de perfil -->
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            @if ($alumno->image_profile)
                                <img src="{{ asset('storage/' . $alumno->image_profile) }}" alt="Foto de Perfil"
                                    class="rounded-circle mb-3" width="150">
                            @else
                                <div class="avatar avatar-xxl">
                                    <span class="avatar-title avatar-alumno rounded-circle border border-white"
                                        width="150">
                                        {{ strtoupper(substr($alumno->user->name, 0, 1)) . strtoupper(substr($alumno->user->last_name, 0, 1)) }}

                                    </span>

                                </div>
                            @endif

                            <h5 class="card-title">{{ $alumno->user->name }} </h5>
                            <h5 class="card-title">{{ $alumno->user->last_name }}</h5>
                            <p class="text-muted">{{ $alumno->curso->name }}</p>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('school.alumnos.index') }}" class="btn btn-primary">Volver a la lista</a>
                        </div>
                    </div>
                </div>

                <!-- Columna de información del alumno -->
                <div class="col-md-9">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <!-- Pestañas -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="datos-tab" data-bs-toggle="tab" href="#datos"
                                        role="tab" aria-controls="datos" aria-selected="true">Datos del Alumno</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="tutor-tab" data-bs-toggle="tab" href="#tutor" role="tab"
                                        aria-controls="tutor" aria-selected="false">Datos del Tutor</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="medicos-tab" data-bs-toggle="tab" href="#medicos" role="tab"
                                        aria-controls="medicos" aria-selected="false">Información Médica</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="movimientos-tab" data-bs-toggle="tab" href="#movimientos"
                                        role="tab" aria-controls="movimientos" aria-selected="false">Últimos
                                        movimientos</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="boletin-tab" data-bs-toggle="tab" href="#boletin" role="tab"
                                        aria-controls="boletin" aria-selected="false">Desempeño / Boletín</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="kpis-tab" data-bs-toggle="tab" href="#kpis" role="tab"
                                        aria-controls="kpis" aria-selected="false">KPIs</a>
                                </li>
                            </ul>

                            <!-- Contenido de las pestañas -->
                            <div class="tab-content" id="myTabContent">
                                <!-- Datos del Alumno -->
                                <div class="tab-pane fade show active" id="datos" role="tabpanel"
                                    aria-labelledby="datos-tab">
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <p><strong>Email:</strong> {{ $alumno->user->email }}</p>
                                            <p><strong>DNI:</strong> {{ $alumno->dni }}</p>
                                            <p><strong>Fecha de Nacimiento:</strong> {{ $alumno->fecha_nacimiento }}</p>
                                            <p><strong>Género:</strong> {{ ucfirst($alumno->genero) }}</p>
                                            <p><strong>Curso:</strong> {{ $alumno->curso->name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Dirección:</strong> {{ $alumno->direccion }}</p>
                                            <p><strong>Teléfono:</strong> {{ $alumno->telefono }}</p>
                                            <p><strong>Nacionalidad:</strong> {{ $alumno->nacionalidad }}</p>
                                            <p><strong>Condición:</strong> {{ ucfirst($alumno->condition) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Datos del Tutor -->
                                <div class="tab-pane fade" id="tutor" role="tabpanel" aria-labelledby="tutor-tab">
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <p><strong>Nombre del Tutor:</strong> {{ $alumno->nombre_tutor }}</p>
                                            <p><strong>Teléfono del Tutor:</strong> {{ $alumno->telefono_tutor }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información Médica -->
                                <div class="tab-pane fade" id="medicos" role="tabpanel" aria-labelledby="medicos-tab">
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <p><strong>Alergias:</strong> {{ $alumno->alergias }}</p>
                                            <p><strong>Seguro Médico:</strong> {{ $alumno->seguro_medico }}</p>
                                            <p><strong>Contacto de Emergencia:</strong> {{ $alumno->contacto_emergencia }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="movimientos" role="tabpanel"
                                    aria-labelledby="movimientos-tab">
                                    <div class="mt-3 table-responsive">
                                        <table class="table table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Materia</th>
                                                    <th>Período</th>
                                                    <th>Nota</th>
                                                    <th>Observación</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($latestMovements as $movement)
                                                    <tr>
                                                        <td>{{ \Illuminate\Support\Carbon::parse($movement->created_at)->format('d/m/Y H:i') }}
                                                        </td>
                                                        <td>{{ $movement->materia ?? '-' }}</td>
                                                        <td>{{ $movement->periodo ?? '-' }}</td>
                                                        <td>{{ $movement->grade_value }}</td>
                                                        <td>{{ $movement->observations ?: '-' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted">Sin movimientos
                                                            registrados.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="boletin" role="tabpanel" aria-labelledby="boletin-tab">
                                    <div class="mt-3 table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Materia</th>
                                                    <th>Período</th>
                                                    <th>Promedio</th>
                                                    <th>Nota mínima</th>
                                                    <th>Nota máxima</th>
                                                    <th>Evaluaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($reportCard as $item)
                                                    <tr>
                                                        <td>{{ $item->materia ?? '-' }}</td>
                                                        <td>{{ $item->periodo ?? '-' }}</td>
                                                        <td>{{ $item->promedio }}</td>
                                                        <td>{{ $item->nota_minima }}</td>
                                                        <td>{{ $item->nota_maxima }}</td>
                                                        <td>{{ $item->evaluaciones }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">No hay notas para
                                                            generar el boletín.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="kpis" role="tabpanel" aria-labelledby="kpis-tab">
                                    <div class="row mt-3">
                                        <div class="col-md-4 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="text-muted">Promedio general</h6>
                                                    <h4>{{ $performanceKpis['promedio_general'] ?? 'N/A' }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="text-muted">Total evaluaciones</h6>
                                                    <h4>{{ $performanceKpis['total_evaluaciones'] }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="text-muted">Última nota</h6>
                                                    <h4>{{ $performanceKpis['ultima_nota'] ?? 'N/A' }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="text-muted">Materias en riesgo (&lt; 6)</h6>
                                                    <h4>{{ $performanceKpis['materias_en_riesgo'] }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="text-muted">% aprobación</h6>
                                                    <h4>{{ $performanceKpis['porcentaje_aprobacion'] }}%</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6 mb-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="mb-0">Evolución de notas</h5>
                                                </div>
                                                <div class="card-body">
                                                    <canvas id="kpiTrendChart" height="140"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="mb-0">Promedio por materia</h5>
                                                </div>
                                                <div class="card-body">
                                                    <canvas id="kpiSubjectChart" height="140"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de navegación -->

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trendLabels = @json($kpiCharts['trend_labels']);
            const trendValues = @json($kpiCharts['trend_values']);
            const subjectLabels = @json($kpiCharts['subject_labels']);
            const subjectValues = @json($kpiCharts['subject_values']);

            if (document.getElementById('kpiTrendChart') && trendValues.length > 0) {
                new Chart(document.getElementById('kpiTrendChart'), {
                    type: 'line',
                    data: {
                        labels: trendLabels,
                        datasets: [{
                            label: 'Nota',
                            data: trendValues,
                            borderColor: '#1572E8',
                            backgroundColor: 'rgba(21, 114, 232, 0.15)',
                            fill: true,
                            tension: 0.25
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    suggestedMax: 10
                                }
                            }]
                        }
                    }
                });
            }

            if (document.getElementById('kpiSubjectChart') && subjectValues.length > 0) {
                new Chart(document.getElementById('kpiSubjectChart'), {
                    type: 'bar',
                    data: {
                        labels: subjectLabels,
                        datasets: [{
                            label: 'Promedio',
                            data: subjectValues,
                            backgroundColor: 'rgba(255, 159, 64, 0.7)',
                            borderColor: '#ff9f40',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    suggestedMax: 10
                                }
                            }]
                        }
                    }
                });
            }
        });
    </script>
@endsection

