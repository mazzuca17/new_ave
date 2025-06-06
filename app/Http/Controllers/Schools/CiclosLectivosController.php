<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\AcademicYears;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CiclosLectivosController extends Controller
{

    public function index()
    {
        return view('school.ciclos.index');
    }

    public function getData(Request $request)
    {
        $data = AcademicYears::where('school_id', Auth::user()->school->id);
        return DataTables::of($data)
            ->addColumn('name', function ($ciclo) {
                return $ciclo->name;
            })
            ->addColumn('status', function ($ciclo) {
                return AcademicYears::getStatus($ciclo->status);
            })
            ->addColumn('start_date', function ($ciclo) {
                return $ciclo->start_date;
            })
            ->addColumn('end_date', function ($ciclo) {
                return $ciclo->end_date;
            })

            ->make(true);
    }

    public function create()
    {
        return view('school.ciclos.create');
    }

    public function store(Request $request)
    {
        // validamos si la fecha de inicio no es posterior a la de cierre
        if ($request->get('start_date') > $request->get('end_date')) {
            return back()->withErrors(['message' => 'Debe seleccionar un curso y una materia para este tipo de evento.']);
        }

        // Guardamos los datos
        $validate_create = AcademicYears::create([
            'school_id'  => Auth::user()->school->id,
            'name'       => $request->get('name'),
            'start_date' => $request->get('start_date'),
            'end_date'   => $request->get('end_date'),
            'status'     => AcademicYears::STATUS_COMMING,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if ($validate_create) {
            return redirect()->route('school.events.view')->with('status', AcademicYears::MESSAGE_CICLOLECTIVO_SUCCESS);
        }
    }
}
