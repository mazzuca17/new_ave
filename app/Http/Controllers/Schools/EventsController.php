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
    const ROLE_SCHOOL_ADMIN             = 2;
    const ERROR_MESSAGE_VALIDATOR       = 'Error al intentar registrar el eventos. Por favor, intente más tarde';
    const MESSAGE_EVENT_SUCCESS         = 'Evento registrado satisfactoriamente';
    const MESSAGE_UPDATED_EVENT_SUCCESS = 'Evento actualizado satisfactoriamente';

    /**
     * create
     *
     * @author Matías
     */
    public function create()
    {
        return view('school.eventos.create');
    }

    /**
     * store
     *
     * @param Request $request
     * @author Matías
     */
    public function store(Request $request)
    {
        $this->validateData($request);

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

    /**
     * validateData
     *
     * @param  mixed $request
     * @author Matías
     */
    public function validateData($request)
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
    }

    /**
     * edit
     *
     * @param integer $event_id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * @author Matías
     */
    public function edit(int $event_id)
    {
        $data_school = Schools::with('user')->where('user_id', Auth::user()->id)->first();
        $data        = Eventos::where('school_id', $data_school->id)
            ->where('id', $event_id)
            ->first();

        return view('school.eventos.edit')->with('data_event', $data);
    }

    /**
     * updte
     *
     * @param Request $request
     * @author Matías
     */
    public function update(Request $request)
    {
        $this->validateData($request);
        Eventos::where('id', $request->event_id)->update([
            'title'       => $request->title,
            'description' => $request->description,
            'fecha'       => $request->fecha,
            'updated_at'  => Carbon::now(),
        ]);
        return redirect(route('school.events.edit', ['event_id' => $request->event_id]))->with('status', self::MESSAGE_UPDATED_EVENT_SUCCESS);
    }

    /**
     * viewAll
     * 
     * Se muestran todos los eventos del establecimiento
     * que están registrados en la plataforma.
     * 
     * @author Matías
     */
    public function viewAll()
    {
        $data_school = Schools::with('user')->where('user_id', Auth::user()->id)->first();
        $data_events = Eventos::with('materia', 'schools', 'author', 'curso')->where('school_id', $data_school->id)->get();

        return view('school.eventos.listado')->with('events', $data_events);
    }
}
