<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\Cursos;
use App\Models\Profesors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MateriasController extends Controller
{
    public function index()
    {
        return view('materias.index');
    }

    public function getData(Request $request) {}

    public function create()
    {
        // Obtener los docentes y cursos
        $cursos    = Cursos::where('school_id', Auth::user()->school->id)->get();
        $profesors = Profesors::with('user')->where('school_id', Auth::user()->school->id)->get();
        $show_message = false;
        if (empty($cursos[0]) || empty($profesors[0])) {
            $show_message = true;
        }
        Log::debug($show_message ? 'true' : 'false');
        return view('materias.create', compact('cursos', 'profesors', 'show_message'));
    }

    public function store(Request $request) {}

    public function showFormEdit() {}

    public function saveEdit() {}
}
