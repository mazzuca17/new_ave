<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\Cursos;
use App\Models\Eventos;
use App\Models\Schools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * index
     * 
     * Listado de cursos
     * Listado de últimos eventos
     * Tabla con data de cursos
     * 
     * @author Matías
     */
    public function index()
    {
        $data_school = Schools::where('user_id', Auth::user()->id)->first();
        $cursos  = Cursos::where('school_id', $data_school->id)->take(5)->get();
        $eventos = Eventos::where('school_id', $data_school->id)->take(10)->get();
        Log::debug($cursos);
        return view('school.index', compact('cursos', 'eventos'));
    }
}
