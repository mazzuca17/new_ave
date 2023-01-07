<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\Cursos;
use App\Models\Eventos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $cursos  = Cursos::where('school_id', Auth::user()->id)->first();
        $eventos = Eventos::where('school_id', Auth::user()->id)->first();

        return view('school.index', compact('cursos', 'eventos'));
    }
}
