@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Crear registro de asistencia</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('school.attendance.store') }}">
                        @csrf
                        @include('school.attendance.partials.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
