<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\AcademicYearCourses;
use App\Models\AcademicYearCourseStudent;
use App\Models\AcademicYears;
use App\Models\Cursos;
use App\Models\Eventos;
use App\Models\OrientacionCursos;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class CoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * index
     *
     * @author Matías
     */
    public function index()
    {
        //Log::debug(Auth::user()->school);
        return view('school.courses.index');
    }

    public function getData(Request $request)
    {
        // Obtener el año lectivo actual
        $currentYear = AcademicYears::where('status', AcademicYears::STATUS_ACTIVE)->first();

        // Obtener cursos con orientaciones y materias
        $courses = Cursos::with(['OrientationCourses', 'academicYearCourses'])
            ->where('school_id', Auth::user()->school_id)
            ->get();

        return DataTables::of($courses)
            ->editColumn('level', function ($course) {
                return $course->level;
            })
            ->addColumn('orientation', function ($course) {
                return $course->OrientationCourses->name;
            })
            ->addColumn('students_count', function ($course) use ($currentYear) {
                if (!$currentYear) return 0;

                $academicYearCourse = AcademicYearCourses::where('course_id', $course->id)
                    ->where('academic_year_id', $currentYear->id)
                    ->first();

                if (!$academicYearCourse) return 0;

                return AcademicYearCourseStudent::where('academic_year_course_id', $academicYearCourse->id)->count();
            })
            ->addColumn('materias_count', function ($course) {
                return count($course->materias);
            })

            ->addColumn('actions', function ($course) {
                return '
                    <a href="' . route('school.courses.dashboard', $course->id) . '" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Ver Perfil
                    </a>
                    <a href="' . route('school.courses.edit', $course->id) . '" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <button class="btn btn-danger btn-sm delete-course" data-id="' . $course->id . '">
                        <i class="fas fa-trash-alt"></i> Eliminar
                    </button>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


    public function destroy($id)
    {
        $course = Cursos::findOrFail($id);
        $course->delete();

        return response()->json(['message' => 'Curso eliminado correctamente']);
    }



    /**
     * showFormNew
     *
     * @author Matías
     */
    public function showFormNew()
    {
        // se busca la data de las orientaciones cargadas
        $orientation = OrientacionCursos::where('school_id', Auth::user()->school->id)->get();
        return view('school.courses.create', compact('orientation'));
    }

    /**
     * saveNewCourse
     *
     * @param  Request $request
     * @author Matías
     */
    public function saveNewCourse(Request $request)
    {
        // Validación previa si el nivel es secundaria y no se envió orientación
        if ($request->get('nivel') === 'Secundaria' && !$request->get('orientacion_id')) {
            Session::flash('danger', 'Debes seleccionar una orientación para cursos de secundaria.');
            return redirect()->back()->withInput();
        }

        // Crear el curso
        $curso = Cursos::create([
            'school_id'   => Auth::user()->school->id,
            'name'        => $request->get('curso'),
            'level'       => $request->get('nivel'),
            'orientation' => $request->get('nivel') === 'Secundaria' ? $request->get('orientacion_id') : null,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);

        // Obtener año lectivo actual (esto puede variar según tu sistema)
        $academicYear = AcademicYears::where('status', AcademicYears::STATUS_ACTIVE)->first();

        // Asociar curso al año lectivo
        if ($curso && $academicYear) {
            AcademicYearCourses::create([
                'academic_year_id' => $academicYear->id,
                'course_id'        => $curso->id,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now()
            ]);
        }

        Session::flash('success', 'Curso creado con éxito.');
        return redirect()->route('school.courses.index');
    }


    /**
     * showFormEdit
     *
     * @param integer $course_id
     * @return void
     */
    public function showFormEdit(int $course_id)
    {
        $data = Cursos::find($course_id);
        return view('school.courses.edit', compact('data'));
    }

    /**
     * saveEdit
     *
     * @param Request $request
     * @author Matías
     */
    public function saveEdit(Request $request)
    {
        try {
            // Buscar el curso
            $course = Cursos::find($request->get('course_id'));

            // Verificar si el curso existe
            if (!$course) {
                Session::flash('danger', 'El curso no existe.');
                return redirect()->route('school.courses.index');
            }

            // Actualizar el curso
            $course->update([
                'name'       => $request->get('curso'),
                'modalidad'  => $request->get('modalidad'),
                'updated_at' => now()
            ]);

            Session::flash('success', 'Curso editado con éxito.');
        } catch (\Exception $e) {
            Session::flash('danger', 'Hubo un problema al editar el curso: ' . $e->getMessage());
        }

        return redirect()->route('school.courses.index');
    }


    /**
     * viewDashboard
     *
     * @param integer $course_id
     * @author Matías
     */
    public function viewDashboard(int $course_id)
    {
        // Buscar el curso con relaciones y filtrar eventos de los próximos 7 días
        $course = Cursos::with([
            'materias',
            'students',
            'eventos' => function ($query) {
                $query->whereBetween('fecha', [now(), now()->addDays(7)]);
            }
        ])->find($course_id);

        // Si no existe el curso, registrar y devolver error
        if (!$course) {
            Log::error("Curso con ID {$course_id} no encontrado.");
            return response()->json(['message' => 'Curso no encontrado.'], 404);
        }

        // Registrar el curso encontrado en logs para depuración
        Log::debug('Curso encontrado:', ['course' => $course]);

        // Retornar la vista con el curso y los eventos filtrados
        return view('school.courses.dashboard', compact('course'));
    }

    /**
     * viewEventosById
     *
     * función encargada de retornar los eventos del curso en cuestión.
     * 
     * @param integer $course_id
     * @author Matías
     */
    public function viewEventosById(int $course_id)
    {
        $eventos = Eventos::with('TypeEvent', 'curso', 'materia')->where('curso_id', $course_id)->get();
        $curso = Cursos::find($course_id);
        Log::debug($eventos);

        return view('school.eventos.listado')->with('events', $eventos)->with('curso', $curso);
    }
}
