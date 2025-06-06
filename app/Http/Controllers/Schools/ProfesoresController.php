<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\Profesors;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;


class ProfesoresController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->user =  $user;
    }

    public function index()
    {
        return view('school.profesors.index');
    }

    public function getData()
    {
        $profesors = Profesors::with('user', 'subjects')->where('school_id', Auth::user()->school->id);

        return DataTables::of($profesors)
            ->addColumn('name', function ($prof) {
                return $prof->user->name;
            })
            ->addColumn('last_name', function ($prof) {
                return $prof->user->last_name;
            })
            ->addColumn('email', function ($prof) {
                return $prof->user->email;
            })
            ->addColumn('count_materias', function ($prof) {
                return $prof->subjects->count(); // Cuenta las materias asociadas
            })
            ->addColumn('actions', function ($prof) {
                return '
            <a href="' . route('school.docentes.profile', $prof->id) . '" class="btn btn-info btn-sm">
                <i class="fas fa-eye"></i> Ver Perfil
            </a>
            <a href="' . route('school.docentes.edit', $prof->id) . '" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <button class="btn btn-danger btn-sm delete-docente" data-id="' . $prof->id . '">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
        ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function showFormNew()
    {
        return view('school.profesors.create');
    }

    public function saveNewDocente(Request $request)
    {
        // Validación de los datos
        $validated = $request->validate([
            'last_name'        => 'required|string|max:255',
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'dni'              => 'required|string|max:20|unique:profesors,dni',
            'fecha_nacimiento' => 'nullable|date',
            'genero'           => 'nullable|string|in:masculino,femenino,otro',
            'direccion'        => 'nullable|string|max:255',
            'telefono'         => 'nullable|string|max:20',
            'nacionalidad'     => 'nullable|string|max:50',
            'profile_photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::create([
            'name'       => $validated['name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'password'   => bcrypt('Soporte2011'),
            'school_id'  => Auth::user()->school->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // Subir foto de perfil si existe
        if ($request->hasFile('profile_photo')) {

            $imagePath = $request->file('profile_photo')->store('profile_images', 'public');
            $user->image_profile = $imagePath;
            $user->save(); // Guardar la foto de perfil en users
        }

        // Creación del nuevo docente
        $prof = new Profesors();
        $prof->user_id          = $user->id;
        $prof->school_id        = Auth::user()->school->id;
        $prof->dni              = $validated['dni'];
        $prof->fecha_nacimiento = $validated['fecha_nacimiento'];
        $prof->genero           = $validated['genero'];
        $prof->direccion        = $validated['direccion'];
        $prof->telefono         = $validated['telefono'];
        $prof->nacionalidad     = $validated['nacionalidad'];



        // Guardar el docente en la base de datos
        $prof->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('school.docentes.index')->with('success', 'Docente creado con éxito');
    }

    public function showFormEdit(int $docente_id)
    {
        $docente = Profesors::with('user')->findOrFail($docente_id);

        // Retornar la vista con los datos del docente
        return view('school.profesors.edit', compact('docente'));
    }

    public function saveEdit(Request $request)
    {

        try {
            $prof = Profesors::findOrFail($request->get('profesor_id'));
            $user = User::findOrFail($prof->user_id);
            // Validación
            $validated = $request->validate([
                'last_name'        => 'required|string|max:255',
                'name'             => 'required|string|max:255',
                'email'            => 'required|email|unique:users,email,' . $user->id,
                'dni'              => 'required|string|max:20|unique:profesors,dni,' . $prof->id,
                'fecha_nacimiento' => 'nullable|date',
                'genero'           => 'nullable|string|in:masculino,femenino,otro',
                'direccion'        => 'nullable|string|max:255',
                'telefono'         => 'nullable|string|max:20',
                'nacionalidad'     => 'nullable|string|max:50',
                'profile_photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::debug($e->getMessage());
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Errores de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }

        Log::debug("DFSDSD");

        // Asignar datos al usuario
        $user->fill([
            'last_name' => $request->last_name,
            'name'      => $request->name,
            'email'     => $request->email,
        ]);

        // Asignar datos al profesor
        $prof->fill([
            'dni'                 => $request->dni,
            'fecha_nacimiento'    => $request->fecha_nacimiento,
            'genero'              => $request->genero,
            'direccion'           => $request->direccion,
            'telefono'            => $request->telefono,
            'nacionalidad'        => $request->nacionalidad,
            'curso_id'            => $request->curso_id,
            'condition'           => $request->condition,
            'nombre_tutor'        => $request->nombre_tutor,
            'telefono_tutor'      => $request->telefono_tutor,
            'alergias'            => $request->alergias,
            'seguro_medico'       => $request->seguro_medico,
            'contacto_emergencia' => $request->contacto_emergencia,
        ]);

        // Procesar imagen si se carga
        if ($request->hasFile('profile_photo')) {
            $imagePath = $request->file('profile_photo')->store('profile_images', 'public');
            $user->image_profile = $imagePath;
        }

        // Guardar ambos modelos
        $user->save();
        $prof->save();

        return redirect()->route('school.docentes.index')
            ->with('success', 'Docente actualizado correctamente.');
    }



    /**
     * destroy
     *
     * @param integer $id
     * @return void
     */
    public function destroy(int $id)
    {
        $prof = Profesors::findOrFail($id);
        $user_prof_id = $prof->user_id;
        $prof->delete();

        $user = User::findOrFail($user_prof_id);
        $user->delete();


        return response()->json(['message' => 'Docente eliminado correctamente']);
    }

    public function showProfile(int $user_prof_id)
    {
        // Buscar el  por ID
        $prof = Profesors::with('user')->findOrFail($user_prof_id);
        Log::debug($prof);
        // Devolver la vista con los datos del pro$prof
        return view('school.profesors.profile.index', compact('prof'));
    }
}
