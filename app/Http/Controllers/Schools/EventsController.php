<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\Cursos;
use App\Models\Eventos;
use App\Models\Materias;
use App\Models\Schools;
use App\Models\TypeEvent as ModelsTypeEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class EventsController extends Controller
{
    private const ROLE_SCHOOL_ADMIN = 2;
    private const ERROR_MESSAGE_VALIDATOR = 'Error al intentar registrar el evento. Por favor, intente más tarde.';
    private const MESSAGE_EVENT_SUCCESS = 'Evento registrado satisfactoriamente.';
    private const MESSAGE_UPDATED_EVENT_SUCCESS = 'Evento actualizado satisfactoriamente.';

    /**
     * Mostrar formulario de creación de evento.
     */
    public function create()
    {
        return view('school.eventos.create');
    }

    /**
     * Guardar un nuevo evento.
     */
    public function store(Request $request)
    {
        // Validar datos
        $validatedData = $this->validateData($request);

        // Obtener la escuela asociada al usuario
        $school = Schools::where('user_id', Auth::id())->firstOrFail();
        Log::debug($request->all());

        // Validar si el tipo de evento requiere curso y materia
        if (in_array($request->get('tipo_evento'), ['evaluacion', 'entrega_tp'])) {
            if (!$request->get('curso_id') || !$request->get('materia_id')) {
                return back()->withErrors(['message' => 'Debe seleccionar un curso y una materia para este tipo de evento.']);
            }
        }
        $type_event = ModelsTypeEvent::where('name', $request->get('tipo_evento'))->first();
        // Crear evento
        Eventos::create([
            'school_id'   => $school->id,
            'user_id'     => Auth::id(),
            'title'       => $validatedData['title'],
            'description' => $validatedData['description'],
            'fecha'       => $validatedData['fecha'],
            'type_event'  => $type_event->id,
            'curso_id'    => $request->get('curso_id') ?? null,
            'materia_id'  => $validatedData['materia_id'] ?? null,
        ]);

        return redirect()->route('school.events.view')->with('status', self::MESSAGE_EVENT_SUCCESS);
    }


    /**
     * Validar datos del evento.
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'title'       => 'required|max:255',
            'description' => 'required',
            'fecha'       => 'required|date',
        ], [
            'title.required'       => 'El título es obligatorio.',
            'title.max'            => 'El título no puede superar los 255 caracteres.',
            'description.required' => 'La descripción es obligatoria.',
            'fecha.required'       => 'La fecha es obligatoria.',
            'fecha.date'           => 'La fecha debe ser válida.',
        ]);
    }

    /**
     * Mostrar formulario de edición de evento.
     */
    public function edit(int $event_id)
    {
        $school = Schools::where('user_id', Auth::id())->firstOrFail();
        $event = Eventos::where('school_id', $school->id)
            ->where('id', $event_id)
            ->firstOrFail();

        return view('school.eventos.edit', compact('event'));
    }

    /**
     * Actualizar un evento existente.
     */
    public function update(Request $request)
    {
        $validatedData = $this->validateData($request);

        $event = Eventos::where('id', $request->event_id)->firstOrFail();
        $event->update($validatedData);

        return redirect()->route('school.events.edit', ['event_id' => $request->event_id])
            ->with('status', self::MESSAGE_UPDATED_EVENT_SUCCESS);
    }

    /**
     * Listar todos los eventos del establecimiento.
     */
    public function viewAll()
    {
        $curso    = null;
        $school   = Schools::where('user_id', Auth::id())->firstOrFail();
        $events   = Eventos::with(['materia', 'schools', 'author', 'curso', 'TypeEvent'])
            ->where('school_id', $school->id)
            ->get();
        Log::debug($events);
        return view('school.eventos.listado', compact('events', 'curso'));
    }

    /**
     * Obtener todos los cursos disponibles
     */
    public function getCursos()
    {
        $school = Schools::where('user_id', Auth::id())->firstOrFail();
        $cursos = Cursos::where('school_id', $school->id)->get(['id', 'name']);

        return response()->json($cursos);
    }


    /**
     * Obtener materias según el curso seleccionado
     */
    public function getMaterias(Request $request)
    {
        $materias = Materias::where('curso_id', $request->curso_id)->get(['id', 'nombre']);
        return response()->json($materias);
    }

    public function getEventByID(int $id_event)
    {
        $event = Eventos::with('materia', 'curso', 'TypeEvent')->find($id_event);
        Log::debug($event);
        return response()->json($event);
    }


    /**
     * updateEventByID
     *
     * @param Request $request
     * @param integer $event_id
     * @return JsonResponse
     * @author Matías
     */
    public function updateEventByID(Request $request, int $event_id): JsonResponse
    {
        try {
            // Validación de los datos
            $validatedData = $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'date'        => 'required|date',
                'id_materia'  => 'required|integer|exists:materias,id',
                'id_curso'    => 'required|integer|exists:cursos,id',
            ]);

            // Buscar el evento antes de actualizar
            $event = Eventos::find($event_id);

            if (!$event) {
                return response()->json([
                    'success' => false,
                    'message' => 'Evento no encontrado'
                ], 404);
            }
            $type_event = Eventos::getType($request->get('type'));
            // Actualizar el evento
            $event->update([
                'title'       => $validatedData['title'],
                'description' => $validatedData['description'] ?? null,
                'fecha'       => $validatedData['date'],
                'materia_id'  => $validatedData['id_materia'],
                'curso_id'    => $validatedData['id_curso'],
                'type_event'     => $type_event->id,
                'updated_at'  => Carbon::now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Evento actualizado correctamente',
                'data'    => $event
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * deleteEventByID
     *
     * @param Request $request
     * @param integer $event_id
     * @return JsonResponse
     * @author Matías
     */
    public function deleteEventByID(Request $request, int $event_id): JsonResponse
    {
        try {
            $event = Eventos::find($event_id);

            // Verificar si el evento existe
            if (!$event) {
                return response()->json([
                    'success' => false,
                    'message' => 'El evento no existe'
                ], 404);
            }

            $event->delete();

            return response()->json([
                'success' => true,
                'message' => 'Evento eliminado correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
