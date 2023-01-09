<?php

namespace App\Http\Controllers\Schools;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Cursos;
use App\Models\Eventos;
use App\Models\Schools;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class EventsController extends Controller
{
    const ROLE_SCHOOL_ADMIN       = 2;
    const ERROR_MESSAGE_VALIDATOR = 'Error al intentar registrar el eventos. Por favor, intente más tarde';
    const MESSAGE_EVENT_SUCCESS   = 'Evento registrado satisfactoriamente';

    /**
     * create
     *
     * @author Matías
     */
    public function create()
    {
        return view('school.eventos.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|max:255',
            'description' => 'required',
            'fecha'       => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(
                route('school.events.create')
            )->with('error', self::ERROR_MESSAGE_VALIDATOR);
        }

        $data_school = Schools::with('user')->where('user_id', Auth::user()->id)->first();

        if ($data_school) {
            Eventos::create([
                'school_id'   => $data_school->id,
                'user_id'     => Auth::user()->id,
                'title'       => $request->title,
                'description' => $request->description,
                'fecha'       => $request->fecha,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ]);

            return redirect(route('school.events.create'))->with('status', self::MESSAGE_EVENT_SUCCESS);
        }
    }
}
