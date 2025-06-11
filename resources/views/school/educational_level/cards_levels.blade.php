@foreach ($niveles as $nivel)
    <div class="col-md-4 mb-4">
        <div class="card border-0 rounded-lg ">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-1">{{ $nivel->name }}</h5>
                <p class="card-text">{{ $nivel->description ?? 'Sin descripción' }}</p>
                <p class="card-text">
                    <strong>Activo en el colegio:</strong>
                    {{ $nivel->EducationSchoolLevel->isNotEmpty() ? 'Sí' : 'No' }}
                </p>
            </div>
            <div class="card-footer d-flex flex-wrap gap-2 justify-content-between">
                {{-- Botón Activar/Desactivar según estado --}}
                <form action="{{ route('school.educational_level.update_status') }}" method="POST" class="w-100">
                    @csrf
                    <input type="hidden" name="level_id" value="{{ $nivel->id }}">
                    <input type="hidden" name="action"
                        value="{{ $nivel->EducationSchoolLevel->isNotEmpty() ? 'deactivate' : 'activate' }}">

                    <button type="submit"
                        class="btn {{ $nivel->EducationSchoolLevel->isNotEmpty() ? 'btn-outline-danger' : 'btn-outline-success' }} w-100">
                        <i
                            class="fas {{ $nivel->EducationSchoolLevel->isNotEmpty() ? 'fa-toggle-off' : 'fa-toggle-on' }} me-1"></i>
                        {{ $nivel->EducationSchoolLevel->isNotEmpty() ? 'Desactivar' : 'Activar' }}
                    </button>
                </form>


                @if ($nivel->school_id != null)
                    <div class="d-flex flex-grow-1 gap-2 mt-2">
                        <a href="{{ route('school.educational_level.edit', $nivel->id) }}"
                            class="btn btn-outline-primary flex-fill">
                            <i class="fas fa-edit me-1"></i> Editar
                        </a>

                        <form action="{{ route('school.educational_level.destroy', $nivel->id) }}" method="POST"
                            onsubmit="return confirm('¿Eliminar este nivel?');" class="flex-fill">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-1"></i> Eliminar
                            </button>
                        </form>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endforeach

@if ($niveles->isEmpty())
    <div class="col-12">
        <div class="alert alert-info text-center">
            No hay niveles educativos disponibles.
        </div>
    </div>
@endif
