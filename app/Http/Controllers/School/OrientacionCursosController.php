<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\OrientacionCursos;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class OrientacionCursosController extends Controller
{
    public function index()
    {
        return view('school.courses.orientacion.index');
    }

    public function getData(Request $request)
    {
        $orientations = OrientacionCursos::where('school_id', Auth::user()->school->id)
            ->get();

        return DataTables::of($orientations)
            ->editColumn('name', function ($orientation) {
                return $orientation->name;
            })
            // ->addColumn('students_count', function ($orientation) {
            //     return count($orientation->students);
            // })
            ->addColumn('description', function ($orientation) {
                return $orientation->description;
            })
            ->addColumn('last_update', function ($orientation) {
                return $orientation->updated_at;
            })
            ->addColumn('actions', function ($orientation) {
                return '               
                <a href="' . route('school.courses.orientation.edit', $orientation->id) . '" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
            ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create()
    {
        return view('school.courses.orientacion.create');
    }

    public function store(Request $request)
    {
        $data = OrientacionCursos::create([
            'school_id'  => Auth::user()->school->id,
            'name'       => $request->get('name'),
            'description'  => $request->get('description'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if ($data) {
            Session::flash('success', 'Orientación de cursos creada con éxito.');
        } else {
            Session::flash('danger', 'Hubo un problema al crear la orientación.');
        }
        return redirect()->route('school.courses.orientation.create'); // Redirige de nuevo a la página anterior
    }
}
