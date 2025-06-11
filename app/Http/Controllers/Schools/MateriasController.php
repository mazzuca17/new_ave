<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\AcademicYearCourseMateria;
use App\Models\AcademicYearCourses;
use App\Models\Cursos;
use App\Models\Materias;
use App\Models\MateriasHorarios;
use App\Models\MateriasProf;
use App\Models\Profesors;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use SubjectTeacher;
use Yajra\DataTables\Facades\DataTables;

class MateriasController extends Controller
{
    public function index()
    {
        return view('materias.index');
    }

    public function getData(Request $request)
    {
        $data = Materias::with('cursos', 'materiasprofesores.teachers.user', 'horarios')
            ->where('school_id', Auth::user()->school->id)
            ->get();


        return DataTables::of($data)
            ->addColumn('code', function ($data) {
                return $data->id;
            })
            ->addColumn('name', function ($data) {
                return $data->nombre;
            })
            ->addColumn('course', function ($data) {
                Log::debug($data);
                return $data->cursos->name;
            })
            ->addColumn('orientation_course', function ($data) {
                return $data->cursos->orientationCourses->name;
            })
            ->addColumn('horarios', function ($data) {
                $items = $data->horarios->map(function ($p) {
                    $start = Carbon::parse($p->start_time)->format('H:i');
                    $end = Carbon::parse($p->end_time)->format('H:i');
                    return '<li>' . MateriasHorarios::getDayWeek($p->day_of_week) . ' de ' . $start . ' a ' . $end . ' hs.</li>';
                })->join('');

                return '<ul>' . $items . '</ul>';
            })

            ->addColumn('profesores', function ($data) {
                return collect($data->materiasprofesores)->flatMap(function ($materiaProf) {
                    return collect($materiaProf['teachers'])->map(function ($teacher) {
                        return optional($teacher['user'])['last_name'] . ' ' . optional($teacher['user'])['name'];
                    });
                })->join(', ');
            })

            ->addColumn('total_horas', function ($data) {
                return collect($data->horarios)->reduce(function ($carry, $horario) {
                    $start = \Carbon\Carbon::parse($horario['start_time']);
                    $end = \Carbon\Carbon::parse($horario['end_time']);
                    return round($carry + $end->diffInMinutes($start) / 60);
                }, 0) . ' hs';
            })
            ->addColumn('actions', function ($data) {
                return '
            <a href="' . route('school.materias.details', $data->id) . '" class="btn btn-info btn-sm">
                <i class="fas fa-eye"></i> Ver Perfil
            </a>
            <a href="' . route('school.materias.edit', $data->id) . '" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <button class="btn btn-danger btn-sm delete-materia" data-id="' . $data->id . '">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
        ';
            })
            ->rawColumns(['actions', 'profesores', 'horarios'])
            ->make(true);
    }

    public function create()
    {
        // Obtener los docentes y cursos
        $cursos    = Cursos::with('OrientationCourses')
            ->where('school_id', Auth::user()->school->id)
            ->get();
        Log::debug($cursos);
        $profesors = Profesors::with('user')
            ->where('school_id', Auth::user()->school->id)
            ->get();

        $show_message = false;
        if (empty($cursos[0]) || empty($profesors[0])) {
            $show_message = true;
        }
        Log::debug($show_message ? 'true' : 'false');
        return view('materias.create', compact('cursos', 'profesors', 'show_message'));
    }

    public function store(Request $request)
    {
        try {
            // se valida la data
            $validated = $this->validateData($request);

            // Validar que no exista una materia con el mismo nombre para ese curso
            $existeNombre = Materias::where('curso_id', $request->curso_id)
                ->where('nombre', $request->name)
                ->exists();

            if ($existeNombre) {
                Session::flash('danger',  'Ya existe una materia con ese nombre para el curso seleccionado.');
                return back();
            }

            // Validar que los horarios no se pisen con materias existentes del mismo curso
            $horariosIngresados = $request->get('schedules');
            $materiasCurso = Materias::with('horarios')->where('curso_id', $request->curso_id)->get();

            foreach ($materiasCurso as $materia) {
                $horariosExistentes = $materia->horarios ?? [];

                foreach ($horariosExistentes as $hExistente) {
                    foreach ($horariosIngresados as $nuevo) {
                        if (strtolower($nuevo['day']) === strtolower($hExistente['day_of_week'])) {
                            $desdeExistente = strtotime($hExistente['from']);
                            $hastaExistente = strtotime($hExistente['to']);
                            $desdeNuevo = strtotime($nuevo['from']);
                            $hastaNuevo = strtotime($nuevo['to']);

                            if (
                                ($desdeNuevo < $hastaExistente) &&
                                ($hastaNuevo > $desdeExistente)
                            ) {
                                Session::flash('danger',  'Los horarios ingresados se superponen con otra materia en el curso.');
                                return back();
                            }
                        }
                    }
                }
            }


            // se empieza a cargar la data
            $subject = Materias::create([
                'school_id'    => Auth::user()->school->id,
                'curso_id'     => $request->get('curso_id'),
                'code_materia' => 12,
                'nombre'       => $request->get('name'),
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now()
            ]);

            if (!$subject)
                return back()->with('error', 'Error al registrar la materia, volve a intentar más tarde');

            // se carga la data según ciclo lectivo
            $this->storeAcademicYearCourseMateria($subject);
            // se carga ahora los horarios
            $this->storeSubjecSchedules($subject, $request->get('schedules'));
            // se cargan los docentes
            $this->storeSubjectTeachers($subject->id, $request->get('teachers'));

            return back()->with('success', 'Materia cargada con éxito');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::debug($e);
            Log::debug($e->getMessage());
            return back()->with('error', 'Ocurrió un error inesperado.');
        }
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name'       => 'required|max:255',
            'curso_id'   => 'required|integer',
            'teachers'   => 'required|array|min:1',
            'schedules'  => 'required|array|min:1',
            'schedules.*.day'  => 'required|string',
            'schedules.*.from' => 'required|date_format:H:i',
            'schedules.*.to'   => 'required|date_format:H:i|after:schedules.*.from',
        ], [
            'name.required'       => 'El nombre es obligatorio.',
            'name.max'            => 'El nombre no puede superar los 255 caracteres.',
            'curso_id.required'   => 'El curso es obligatorio.',
            'teachers.required'   => 'Debe seleccionar al menos un profesor.',
            'teachers.array'      => 'El campo de profesores debe ser un arreglo.',
            'teachers.*.integer'  => 'Cada profesor debe tener un ID válido.',
            'schedules.required'  => 'Debe definir al menos un horario.',
            'schedules.array'     => 'El campo de horarios debe ser un arreglo.',
            'schedules.*.day.required'  => 'El día del horario es obligatorio.',
            'schedules.*.from.required' => 'La hora de inicio es obligatoria.',
            'schedules.*.to.required'   => 'La hora de fin es obligatoria.',
            'schedules.*.from.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
            'schedules.*.to.date_format'   => 'La hora de fin debe tener el formato HH:MM.',
            'schedules.*.to.after'         => 'La hora de fin debe ser posterior a la hora de inicio.',
        ]);
    }

    /**
     * storeAcademicYearCourseMateria
     * 
     * Se carga la relación entre el curso del ciclo lectivo y la materia
     *
     * @param  Materia $subject
     * @return void
     * @author Matías
     */
    private function storeAcademicYearCourseMateria(Materias $subject)
    {
        $academic_year_course_id = AcademicYearCourses::where('course_id', $subject->curso_id)->first();
        AcademicYearCourseMateria::create([
            'academic_year_course_id' => $academic_year_course_id->id,
            'materia_id'              => $subject->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * storeSubjecSchedules
     * 
     * Se cargarn y relacionan los horarios con la materia registrada
     *
     * @param Materias $subject
     * @param array $schedules
     * @return void
     * @author Matías
     */
    private function storeSubjecSchedules(Materias $subject, array $schedules)
    {
        foreach ($schedules as $item) {
            Log::debug($item);
            MateriasHorarios::create([
                'subject_course_id' => $subject->id,
                'day_of_week'       => MateriasHorarios::getNumberDayWeek($item['day']),
                'start_time'        => $item['from'],
                'end_time'          => $item['to'],
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);
        }
    }

    /**
     *storeSubjectTeachers
     *
     * @param integer $subject_id
     * @param array $teachers
     * @author Matías
     */
    private function storeSubjectTeachers(int $subject_id, array $teachers)
    {
        foreach ($teachers as $item) {
            MateriasProf::create([
                'subject_courses_id' => $subject_id,
                'teacher_id'         => $item,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);
        }
    }



    public function showFormEdit() {}

    public function saveEdit() {}

    /**
     * showDetail
     *
     * función destinada a mostrar la información básica de la materia.
     * @param integer $id
     * @author Matías
     */
    public function showDetail($id)
    {
        $materia = Materias::with([
            'cursos.orientationCourses',
            'horarios',
            'materiasprofesores.teachers.user'
        ])->where('school_id', Auth::user()->school->id)
            ->findOrFail($id);
        Log::debug($materia);
        // Obtener horarios en formato legible
        $horarios = $materia->horarios->map(function ($h) {
            $day = MateriasHorarios::getDayWeek($h->day_of_week);
            $start = Carbon::parse($h->start_time)->format('H:i');
            $end = Carbon::parse($h->end_time)->format('H:i');
            return "$day de $start a $end hs.";
        });

        // Obtener profesores con nombre completo
        $profesores = collect($materia->materiasprofesores)->flatMap(function ($materiaProf) {
            return collect($materiaProf['teachers'])->map(function ($teacher) {
                return optional($teacher->user)->last_name . ' ' . optional($teacher->user)->name;
            });
        });

        // Total de horas semanales
        $totalHoras = $materia->horarios->reduce(function ($carry, $horario) {
            $start = Carbon::parse($horario->start_time);
            $end = Carbon::parse($horario->end_time);
            return round($carry + $end->diffInMinutes($start) / 60);
        }, 0);

        return view('materias.detail', compact('materia', 'horarios', 'profesores', 'totalHoras'));
    }
}
