<?php

namespace App\Console\Commands;

use App\Models\AcademicYearCourseStudent;
use App\Models\AcademicYears;
use App\Models\Cursos;
use App\Models\Students;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ProcessAcademicYearTransition extends Command
{
    protected $signature = 'academic-year:process-transition {--school_id=}';

    protected $description = 'Actualiza alumnos al siguiente curso y adapta cursos/materias para el nuevo ciclo lectivo.';

    public function handle(): int
    {
        $schoolId = $this->option('school_id');

        $years = AcademicYears::query()
            ->when($schoolId, fn($q) => $q->where('school_id', $schoolId))
            ->whereDate('end_date', '<=', now()->toDateString())
            ->where('status', AcademicYears::STATUS_ACTIVE)
            ->get();

        if ($years->isEmpty()) {
            $this->info('No hay ciclos activos finalizados para procesar.');
            return self::SUCCESS;
        }

        foreach ($years as $year) {
            DB::transaction(function () use ($year) {
                $this->promoteStudents($year->school_id);
                $year->update(['status' => AcademicYears::STATUS_DESACTIVE]);

                AcademicYears::where('school_id', $year->school_id)
                    ->where('status', AcademicYears::STATUS_COMMING)
                    ->whereDate('start_date', '<=', now()->toDateString())
                    ->update(['status' => AcademicYears::STATUS_ACTIVE]);
            });

            $this->info("Transición procesada para school_id={$year->school_id}.");
        }

        return self::SUCCESS;
    }

    private function promoteStudents(int $schoolId): void
    {
        $courses = Cursos::where('school_id', $schoolId)->orderBy('id')->get()->values();
        if ($courses->count() < 2) {
            return;
        }

        $map = [];
        for ($i = 0; $i < $courses->count() - 1; $i++) {
            $map[$courses[$i]->id] = $courses[$i + 1]->id;
        }

        $students = Students::where('school_id', $schoolId)->get();
        foreach ($students as $student) {
            if (isset($map[$student->curso_id])) {
                $student->update(['curso_id' => $map[$student->curso_id]]);
            }
        }

        AcademicYearCourseStudent::whereHas('student', function ($query) use ($schoolId) {
            $query->where('school_id', $schoolId);
        })->update(['status' => 'aprobado']);
    }
}
