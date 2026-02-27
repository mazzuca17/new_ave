@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Mi perfil</h4>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ $user->image_profile ? asset('storage/' . $user->image_profile) : asset('img/profile.jpg') }}"
                                class="img-fluid rounded-circle mb-3" style="max-width: 180px;">
                            <h5>{{ $user->name }} {{ $user->last_name }}</h5>
                            <p>{{ $user->email }}</p>
                            <form method="POST" action="{{ route('school.profile.photo') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group text-left">
                                    <label>Modificar foto de perfil</label>
                                    <input type="file" name="image_profile" class="form-control" required>
                                </div>
                                <button class="btn btn-primary btn-sm">Actualizar foto</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <p class="card-category">Cantidad de alumnos</p>
                                    <h4 class="card-title">{{ $studentsCount }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <p class="card-category">Cantidad de cursos</p>
                                    <h4 class="card-title">{{ $coursesCount }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <p class="card-category">Desempeño global</p>
                                    <h4 class="card-title">{{ $globalPerformance }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header"><h4 class="card-title">Carga de usuarios</h4></div>
                        <div class="card-body">
                            <p>Total de usuarios del colegio: <strong>{{ $usersCount }}</strong></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header"><h4 class="card-title">Mejores promedios generales</h4></div>
                        <div class="card-body">
                            <ul class="list-group">
                                @forelse ($topStudents as $student)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>{{ optional($student->user)->name }} ({{ optional($student->curso)->name }})</span>
                                        <span>{{ $student->promedio }}</span>
                                    </li>
                                @empty
                                    <li class="list-group-item">Sin alumnos cargados.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
