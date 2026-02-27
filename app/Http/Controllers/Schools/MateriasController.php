<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\AcademicYearCourseMateria;
use App\Models\AcademicYearCourses;
use App\Models\Cursos;
use App\Models\Eventos;
use App\Models\Materias;
use App\Models\MateriasHorarios;
use App\Models\MateriasProf;
use App\Models\Notas;
use App\Models\Profesors;
use App\Models\Students;
use App\Models\SubjectActivities;
use App\Models\SubjectContents;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class MateriasController extends Controller
{
    public function index()
    {
        return view('materias.index');
    }

    public function getData(Request $request)
    {
        $data = Materias::with('cursos.orientationCourses', 'materiasprofesores.teachers.user', 'horarios')
            ->where('school_id', Auth::user()->school->id)
            ->get();

        return DataTables::of($data)
            ->addColumn('code', fn($data) => $data->id)
            ->addColumn('name', fn($data) => $data->nombre)
            ->addColumn('course', fn($data) => optional($data->cursos)->name ?? '-')
            ->addColumn('orientation_course', fn($data) => optional(optional($data->cursos)->orientationCourses)->name ?? '-')
            ->addColumn('horarios', function ($data) {
                $items = $data->horarios->map(function ($p) {
                    $start = Carbon::parse($p->start_time)->format('H:i');
                    $end = Carbon::parse($p->end_time)->format('H:i');
                    return '<li>' . MateriasHorarios::getDayWeek((int) $p->day_of_week) . ' de ' . $start . ' a ' . $end . ' hs.</li>';
                })->join('');

                return '<ul class="mb-0">' . $items . '</ul>';
            })
            ->addColumn('profesores', function ($data) {
                return collect($data->materiasprofesores)
                    ->map(fn($materiaProf) => optional(optional($materiaProf->teachers)->user)->last_name . ' ' . optional(optional($materiaProf->teachers)->user)->name)
                    ->filter()
                    ->join(', ');
            })
            ->addColumn('total_horas', function ($data) {
                return collect($data->horarios)->reduce(function ($carry, $horario) {
                    $start = Carbon::parse($horario['start_time']);
                    $end = Carbon::parse($horario['end_time']);
                    return $carry + ($end->diffInMinutes($start) / 60);
                }, 0) . ' hs';
            })
            ->addColumn('actions', function ($data) {
                return '
                    <a href="' . route('school.materias.details', $data->id) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Ver Perfil</a>
                    <a href="' . route('school.materias.edit', $data->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</a>
                    <button class="btn btn-danger btn-sm delete-materia" data-id="' . $data->id . '"><i class="fas fa-trash-alt"></i> Eliminar</button>
                ';
            })
            ->rawColumns(['actions', 'profesores', 'horarios'])
            ->make(true);
    }

    public function create()
    {
        $cursos = Cursos::with('OrientationCourses')->where('school_id', Auth::user()->school->id)->get();
        $profesors = Profesors::with('user')->where('school_id', Auth::user()->school->id)->get();

        return view('materias.create', [
            'cursos' => $cursos,
            'profesors' => $profesors,
            'show_message' => empty($cursos[0]) || empty($profesors[0]),
        ]);
    }

    public function store(Request $request)
    {
        try {
            $this->validateData($request);

            $existeNombre = Materias::where('curso_id', $request->curso_id)
                ->where('nombre', $request->name)
                ->exists();

            if ($existeNombre) {
                return back()->with('danger', 'Ya existe una materia con ese nombre para el curso seleccionado.');
            }

            $this->validateSchedulesAgainstCourse((int) $request->curso_id, $request->get('schedules', []));

            DB::transaction(function () use ($request) {
                $subject = Materias::create([
                    'school_id' => Auth::user()->school->id,
                    'curso_id' => $request->get('curso_id'),
                    'code_materia' => (string) now()->timestamp,
                    'nombre' => $request->get('name'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                $this->storeAcademicYearCourseMateria($subject);
                $this->storeSubjecSchedules($subject, $request->get('schedules', []));
                $this->storeSubjectTeachers($subject->id, $request->get('teachers', []));
            });

            return redirect()->route('school.materias.index')->with('success', 'Materia cargada con éxito');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Throwable $e) {
            Log::error('Error al crear materia', ['exception' => $e]);
            return back()->with('error', 'Ocurrió un error inesperado.');
        }
    }

    public function showFormEdit(int $id_materia)
    {
        $materia = Materias::with(['horarios', 'materiasprofesores'])
            ->where('school_id', Auth::user()->school->id)
            ->findOrFail($id_materia);

        return view('materias.edit', [
            'materia' => $materia,
            'cursos' => Cursos::with('OrientationCourses')->where('school_id', Auth::user()->school->id)->get(),
            'profesors' => Profesors::with('user')->where('school_id', Auth::user()->school->id)->get(),
        ]);
    }

    public function saveEdit(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
                'name' => 'required|max:255',
                'curso_id' => 'required|integer',
                'teachers' => 'required|array|min:1',
                'schedules' => 'required|array|min:1',
                'schedules.*.day' => 'required|string',
                'schedules.*.from' => 'required|date_format:H:i',
                'schedules.*.to' => 'required|date_format:H:i|after:schedules.*.from',
            ]);

            $materia = Materias::where('school_id', Auth::user()->school->id)->findOrFail($request->id);

            $duplicada = Materias::where('curso_id', $request->curso_id)
                ->where('nombre', $request->name)
                ->where('id', '!=', $materia->id)
                ->exists();

            if ($duplicada) {
                return back()->with('danger', 'Ya existe una materia con ese nombre para el curso seleccionado.');
            }

            $this->validateSchedulesAgainstCourse((int) $request->curso_id, $request->get('schedules', []), $materia->id);

            DB::transaction(function () use ($request, $materia) {
                $materia->update([
                    'nombre' => $request->name,
                    'curso_id' => $request->curso_id,
                    'updated_at' => Carbon::now(),
                ]);

                MateriasHorarios::where('subject_course_id', $materia->id)->delete();
                MateriasProf::where('subject_courses_id', $materia->id)->delete();

                $this->storeSubjecSchedules($materia, $request->get('schedules', []));
                $this->storeSubjectTeachers($materia->id, $request->get('teachers', []));
            });

            return redirect()->route('school.materias.index')->with('success', 'Materia actualizada con éxito.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }
    }

    public function destroy(int $id)
    {
        $materia = Materias::where('school_id', Auth::user()->school->id)->findOrFail($id);

        DB::transaction(function () use ($materia) {
            MateriasHorarios::where('subject_course_id', $materia->id)->delete();
            MateriasProf::where('subject_courses_id', $materia->id)->delete();
            AcademicYearCourseMateria::where('materia_id', $materia->id)->delete();
            $materia->delete();
        });

        return response()->json(['message' => 'Materia eliminada correctamente.']);
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $handle = fopen($request->file('csv_file')->getRealPath(), 'r');
        $header = fgetcsv($handle, 0, ',');
        $created = 0;

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $record = array_combine($header, $row);
            if (empty($record['nombre']) || empty($record['curso_id'])) {
                continue;
            }

            $exists = Materias::where('school_id', Auth::user()->school->id)
                ->where('curso_id', $record['curso_id'])
                ->where('nombre', $record['nombre'])
                ->exists();

            if ($exists) {
                continue;
            }

            Materias::create([
                'school_id' => Auth::user()->school->id,
                'curso_id' => $record['curso_id'],
                'code_materia' => (string) now()->timestamp . $created,
                'nombre' => $record['nombre'],
            ]);
            $created++;
        }

        fclose($handle);
        return back()->with('success', "Carga masiva finalizada. Materias creadas: {$created}.");
    }

    public function storeActivity(Request $request, int $id_materia)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        SubjectActivities::create([
            'subject_course_id' => $id_materia,
            'title' => $request->title,
            'instructions' => $request->instructions,
            'due_date' => $request->due_date,
        ]);

        return back()->with('success', 'Actividad cargada correctamente.');
    }

    public function storeContent(Request $request, int $id_materia)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'link' => 'nullable|url',
            'file' => 'nullable|file|max:10240',
        ]);

        $filePath = $request->hasFile('file') ? $request->file('file')->store('subject_contents', 'public') : null;

        SubjectContents::create([
            'subject_course_id' => $id_materia,
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'link' => $request->link,
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'Contenido cargado correctamente.');
    }

    public function showDetail($id)
    {
        $materia = Materias::with(['cursos.orientationCourses', 'horarios', 'materiasprofesores.teachers.user'])
            ->where('school_id', Auth::user()->school->id)
            ->findOrFail($id);

        $horarios = $materia->horarios->map(function ($h) {
            $day = MateriasHorarios::getDayWeek((int) $h->day_of_week);
            $start = Carbon::parse($h->start_time)->format('H:i');
            $end = Carbon::parse($h->end_time)->format('H:i');
            return "$day de $start a $end hs.";
        });

        $profesores = collect($materia->materiasprofesores)
            ->map(fn($materiaProf) => optional(optional($materiaProf->teachers)->user)->last_name . ' ' . optional(optional($materiaProf->teachers)->user)->name)
            ->filter();

        $totalHoras = $materia->horarios->reduce(function ($carry, $horario) {
            return $carry + Materias::calculateHours($horario->start_time, $horario->end_time);
        }, 0);

        $students = Students::with('user')->where('curso_id', $materia->curso_id)->get();
        $studentIds = $students->pluck('id');
        $grades = Notas::where('subject_course_id', $materia->id)
            ->whereIn('student_enrollment_id', $studentIds)
            ->orderBy('term')
            ->get();

        $termAverages = $grades->groupBy('term')->map(fn($items) => round($items->avg('grade'), 2));
        $approvalRate = $grades->count() > 0 ? round(($grades->where('grade', '>=', 6)->count() / $grades->count()) * 100, 1) : 0;

        $studentGrades = $students->map(function ($student) use ($grades) {
            $items = $grades->where('student_enrollment_id', $student->id);
            return [
                'student' => optional($student->user)->last_name . ' ' . optional($student->user)->name,
                'promedio' => $items->count() ? round($items->avg('grade'), 2) : null,
                'estado' => ($items->count() && $items->avg('grade') >= 6) ? 'Aprobado' : 'En proceso',
            ];
        });

        $events = Eventos::where('materia_id', $materia->id)->orderByDesc('fecha')->take(20)->get();
        $activities = SubjectActivities::where('subject_course_id', $materia->id)->orderByDesc('created_at')->get();
        $contents = SubjectContents::where('subject_course_id', $materia->id)->orderByDesc('created_at')->get();

        return view('materias.detail', compact(
            'materia',
            'horarios',
            'profesores',
            'totalHoras',
            'termAverages',
            'approvalRate',
            'studentGrades',
            'events',
            'activities',
            'contents'
        ));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => 'required|max:255',
            'curso_id' => 'required|integer',
            'teachers' => 'required|array|min:1',
            'schedules' => 'required|array|min:1',
            'schedules.*.day' => 'required|string',
            'schedules.*.from' => 'required|date_format:H:i',
            'schedules.*.to' => 'required|date_format:H:i|after:schedules.*.from',
        ]);
    }

    private function validateSchedulesAgainstCourse(int $courseId, array $newSchedules, ?int $ignoreMateriaId = null): void
    {
        $materiasCurso = Materias::with('horarios')->where('curso_id', $courseId)
            ->when($ignoreMateriaId, fn($q) => $q->where('id', '!=', $ignoreMateriaId))
            ->get();

        foreach ($materiasCurso as $materia) {
            foreach ($materia->horarios as $hExistente) {
                foreach ($newSchedules as $nuevo) {
                    if (MateriasHorarios::getNumberDayWeek($nuevo['day']) !== (int) $hExistente->day_of_week) {
                        continue;
                    }

                    $desdeExistente = strtotime($hExistente->start_time);
                    $hastaExistente = strtotime($hExistente->end_time);
                    $desdeNuevo = strtotime($nuevo['from']);
                    $hastaNuevo = strtotime($nuevo['to']);

                    if (($desdeNuevo < $hastaExistente) && ($hastaNuevo > $desdeExistente)) {
                        throw ValidationException::withMessages([
                            'schedules' => 'Los horarios ingresados se superponen con otra materia del curso.',
                        ]);
                    }
                }
            }
        }
    }

    private function storeAcademicYearCourseMateria(Materias $subject)
    {
        $academicYearCourse = AcademicYearCourses::where('course_id', $subject->curso_id)->first();

        if (!$academicYearCourse) {
            return;
        }

        AcademicYearCourseMateria::create([
            'academic_year_course_id' => $academicYearCourse->id,
            'materia_id' => $subject->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    private function storeSubjecSchedules(Materias $subject, array $schedules)
    {
        foreach ($schedules as $item) {
            MateriasHorarios::create([
                'subject_course_id' => $subject->id,
                'day_of_week' => MateriasHorarios::getNumberDayWeek($item['day']),
                'start_time' => $item['from'],
                'end_time' => $item['to'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    private function storeSubjectTeachers(int $subject_id, array $teachers)
    {
        foreach ($teachers as $item) {
            MateriasProf::create([
                'subject_courses_id' => $subject_id,
                'teacher_id' => $item,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
