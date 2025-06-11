@extends('layouts.app_system')

@section('content')
    <div class="content">
        <div class="page-inner mt--20">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if (Session::has('danger'))
                            <div class="alert alert-danger">
                                {{ Session::get('danger') }}
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="page-header">
                                <h4 class="page-title">Niveles Educativos</h4>
                            </div>
                            <div>
                                <!-- Botón para abrir modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#nuevoNivelModal">
                                    Nuevo Nivel
                                </button>

                            </div>
                        </div>

                        <div class="row">
                            @include('school.educational_level.cards_levels')
                        </div>

                        @include('school.educational_level.modal_new_level')

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
@endsection
