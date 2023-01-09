<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\Cursos;
use App\Models\Eventos;
use App\Models\Materias;
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
        $eventos =  Eventos::where('school_id', $id_school)
            ->where('fecha', '>=', now()->subDays(self::RANGO_DIAS_EVENTOS_SHOW))
            ->take(self::CANT_EVENTOS)
            ->get();

        if (isset($eventos[0])) {
            $data_eventos = [];

            foreach ($eventos as $item) {
                $curso   = Cursos::where('id', $item->curso_id)->first();
                $materia = Materias::where('id', $item->materia_id)->first();

                $data_eventos[] = [
                    'title'       => $item->title,
                    'description' => $item->description,
                    'fecha'       => $item->fecha,
                    'curso'       => $curso ? $curso->name : '',
                    'materia'     => $materia ? $materia->nombre : '',
                ];
            }

            return $data_eventos;
        }
        return null;
    }

    public function getCourses(int $id_school)
    {
        return Cursos::where('schoold_id', $id_school)->get();
    }
}
