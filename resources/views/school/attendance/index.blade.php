@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Asistencias</h4>
                    <a href="{{ route('school.attendance.create') }}" class="btn btn-primary">Crear registro</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form class="form-inline mb-3" method="GET">
                        <input type="date" name="date" class="form-control mr-2" value="{{ request('date') }}">
                        <button type="submit" class="btn btn-secondary">Filtrar</button>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Alumno</th>
                                    <th>Materia</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($records as $record)
                                    <tr>
                                        <td>{{ $record->date }}</td>
                                        <td>{{ optional(optional($record->enrollment)->student->user)->name }}</td>
                                        <td>{{ optional($record->materia)->nombre }}</td>
                                        <td>{{ ucfirst($record->status) }}</td>
                                        <td>
                                            <a href="{{ route('school.attendance.edit', $record->id) }}"
                                                class="btn btn-sm btn-warning">Editar</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Sin registros.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $records->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
