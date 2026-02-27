<div class="form-group">
    <label>Alumno</label>
    <select name="student_enrollment_id" class="form-control" required>
        <option value="">Seleccionar</option>
        @foreach ($enrollments as $enrollment)
            <option value="{{ $enrollment->id }}"
                {{ old('student_enrollment_id', $record->student_enrollment_id ?? '') == $enrollment->id ? 'selected' : '' }}>
                {{ optional($enrollment->student->user)->name }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label>Materia</label>
    <select name="subject_course_id" class="form-control" required>
        <option value="">Seleccionar</option>
        @foreach ($subjects as $subject)
            <option value="{{ $subject->id }}"
                {{ old('subject_course_id', $record->subject_course_id ?? '') == $subject->id ? 'selected' : '' }}>
                {{ $subject->nombre }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label>Fecha</label>
    <input type="date" name="date" class="form-control" value="{{ old('date', $record->date ?? '') }}" required>
</div>
<div class="form-group">
    <label>Estado</label>
    <select name="status" class="form-control" required>
        @foreach (['presente', 'ausente', 'justificado'] as $status)
            <option value="{{ $status }}" {{ old('status', $record->status ?? '') === $status ? 'selected' : '' }}>
                {{ ucfirst($status) }}
            </option>
        @endforeach
    </select>
</div>
<button type="submit" class="btn btn-primary">Guardar</button>
<a href="{{ route('school.attendance.index') }}" class="btn btn-light">Cancelar</a>
