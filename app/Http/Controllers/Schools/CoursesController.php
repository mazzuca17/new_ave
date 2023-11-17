<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\Cursos;
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
}
