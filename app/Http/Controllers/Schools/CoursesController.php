<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\Cursos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        Log::debug($request->all());
    }
}
