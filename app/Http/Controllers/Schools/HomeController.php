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

    const RANGO_DIAS_EVENTOS_SHOW = 7;
    const CANT_EVENTOS            = 10;

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
        $cursos      = Cursos::where('school_id', $data_school->id)->take(5)->get();
        $eventos     = $this->getLastEvents($data_school->id);

        Log::debug($cursos);
        return view('school.index', compact('cursos', 'eventos'));
    }

    /**
     * getLastEvents
     *
     * @param integer $id_school
     * @author Matías
     */
    public function getLastEvents(int $id_school)
    {
        return Eventos::where('school_id', $id_school)
            ->where('fecha', '>=', now()->subDays(self::RANGO_DIAS_EVENTOS_SHOW))
            ->take(self::CANT_EVENTOS)
            ->get();
    }
}
