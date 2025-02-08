<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\Cursos;
use App\Models\Eventos;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
        $courses = Cursos::where('school_id', Auth::user()->school->id)->get();

        return view('school.courses.index')->with([
            'courses' => $courses,
        ]);
    }

    /**
     * showFormNew
     *
     * @author Matías
     */
    public function showFormNew()
    {
        return view('school.courses.create');
    }

    /**
     * saveNewCourse
     *
     * @param  Request $request
     * @author Matías
     */
    public function saveNewCourse(Request $request)
    {
        $data = Cursos::create([
            'school_id' => Auth::user()->school->id,
            'name'      => $request->get('curso') . ' ' . $request->get('modalidad'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if ($data) {
            Session::flash('success', 'Curso creado con éxito.');
        } else {
            Session::flash('danger', 'Hubo un problema al crear el curso.');
        }
        return redirect()->back(); // Redirige de nuevo a la página anterior
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
