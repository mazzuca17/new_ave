<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\Alumnos;
use App\Models\Cursos;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Yajra\DataTables\Facades\DataTables;

class AlumnosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('school.alumnos.index');
    }

    public function getData()
    {
        $students = Students::with('user', 'curso')->where('school_id', Auth::user()->school->id);

        return DataTables::of($students)
            ->addColumn('name', function ($student) {
                return $student->user->name;
            })
            ->addColumn('last_name', function ($student) {
                return $student->user->last_name;
            })
            ->addColumn('modalidad', function ($student) {
                return $student->modalidad;
            })
            ->addColumn('curso_name', function ($student) {
                return $student->curso->name;
            })
            ->addColumn('modalidad', function ($student) {
                return $student->curso->modalidad;
            })
            ->addColumn('condition', function ($student) {
                return ucfirst($student->condition);
            })
            ->addColumn('actions', function ($student) {
                return '
                <a href="' . route('school.alumnos.profile', $student->id) . '" class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i> Ver Perfil
                </a>
                <a href="' . route('school.alumnos.edit', $student->id) . '" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <button class="btn btn-danger btn-sm delete-alumno" data-id="' . $student->id . '">
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
            ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function showFormNew()
    {
        $cursos = Cursos::where('school_id', Auth::user()->school->id)->get();

        return view('school.alumnos.create', compact('cursos'));
    }

    public function store(HttpRequest $request)
    {
        // Validación de los datos
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'dni' => 'required|string|max:20|unique:students,dni',
            'fecha_nacimiento' => 'nullable|date',
            'genero' => 'nullable|string|in:masculino,femenino,otro',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'nacionalidad' => 'nullable|string|max:50',
            'curso_id' => 'required',
            'condition' => 'required|string|in:regular,aprobado,finales',
            'image_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nombre_tutor' => 'nullable|string|max:255',
            'telefono_tutor' => 'nullable|string|max:20',
            'alergias' => 'nullable|string|max:500',
            'seguro_medico' => 'nullable|string|max:255',
            'contacto_emergencia' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name'       => $validated['name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'password'   => bcrypt('Soporte2011'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // Creación del nuevo alumno
        $student = new Students();
        $student->user_id          = $user->id;
        $student->school_id        = Auth::user()->school->id;
        $student->dni              = $validated['dni'];
        $student->fecha_nacimiento = $validated['fecha_nacimiento'];
        $student->genero           = $validated['genero'];
        $student->direccion        = $validated['direccion'];
        $student->telefono         = $validated['telefono'];
        $student->nacionalidad     = $validated['nacionalidad'];
        $student->curso_id         = $validated['curso_id'];
        $student->condition        = $validated['condition'];

        // Subir foto de perfil si existe
        if ($request->hasFile('image_profile')) {
            $imagePath = $request->file('image_profile')->store('profile_images', 'public');
            $student->image_profile = $imagePath;
        }

        $student->anio_ingreso = $request->get('anio_ingreso');
        $student->estado_matricula = $request->get('estado_matricula');

        // Datos del tutor
        $student->nombre_tutor = $validated['nombre_tutor'];
        $student->telefono_tutor = $validated['telefono_tutor'];

        // Información médica
        $student->alergias = $validated['alergias'];
        $student->seguro_medico = $validated['seguro_medico'];
        $student->contacto_emergencia = $validated['contacto_emergencia'];

        // Guardar el alumno en la base de datos
        $student->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('school.alumnos.index')->with('success', 'Alumno creado con éxito');
    }


    public function showFormEdit(int $alumno_id)
    {
        $alumno = Students::with('user', 'curso')->findOrFail($alumno_id);

        // Obtener todos los cursos para mostrarlos en el select
        $cursos = Cursos::all();

        // Retornar la vista con los datos del alumno y los cursos
        return view('school.alumnos.edit', compact('alumno', 'cursos'));
    }

    public function saveEdit(HttpRequest $request)
    {
        // Validación de los datos
        $request->validate([
            'last_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'dni' => 'required|string|max:20',
            'fecha_nacimiento' => 'nullable|date',
            'genero' => 'nullable|string|in:masculino,femenino,otro',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'nacionalidad' => 'nullable|string|max:50',
            'curso_id' => 'required|exists:cursos,id',
            'condition' => 'required|string|in:regular,aprobado,finales',
            'image_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nombre_tutor' => 'nullable|string|max:255',
            'telefono_tutor' => 'nullable|string|max:20',
            'alergias' => 'nullable|string',
            'seguro_medico' => 'nullable|string|max:255',
            'contacto_emergencia' => 'nullable|string|max:255',
        ]);

        // Obtener el alumno por su ID
        $alumno = Students::findOrFail($request->get('student_id'));
        $user   = User::findOrFail($alumno->user_id);

        // Actualizar los datos del alumno
        $user->last_name = $request->last_name;
        $user->name = $request->name;
        $user->email = $request->email;

        $alumno->dni = $request->dni;
        $alumno->fecha_nacimiento = $request->fecha_nacimiento;
        $alumno->genero = $request->genero;
        $alumno->direccion = $request->direccion;
        $alumno->telefono = $request->telefono;
        $alumno->nacionalidad = $request->nacionalidad;
        $alumno->curso_id = $request->curso_id;
        $alumno->condition = $request->condition;
        $alumno->nombre_tutor = $request->nombre_tutor;
        $alumno->telefono_tutor = $request->telefono_tutor;
        $alumno->alergias = $request->alergias;
        $alumno->seguro_medico = $request->seguro_medico;
        $alumno->contacto_emergencia = $request->contacto_emergencia;

        // Si se sube una nueva foto de perfil, la guardamos
        if ($request->hasFile('image_profile')) {
            $imageName = time() . '.' . $request->image_profile->extension();
            $request->image_profile->move(public_path('images/alumnos'), $imageName);
            $alumno->image_profile = $imageName;
        }

        // Guardamos los cambios
        $alumno->save();
        $user->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('school.alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    /**
     * destroy
     *
     * @param integer $id
     * @return void
     */
    public function destroy(int $id)
    {
        $student = Students::findOrFail($id);
        $user_student_id = $student->user_id;
        $student->delete();

        $user = User::findOrFail($user_student_id);
        $user->delete();


        return response()->json(['message' => 'Alumno eliminado correctamente']);
    }

    public function showProfile(int $user_student_id)
    {
        // Buscar el alumno por ID
        $alumno = Students::findOrFail($user_student_id);

        // Devolver la vista con los datos del alumno
        return view('school.alumnos.profile', compact('alumno'));
    }
}
