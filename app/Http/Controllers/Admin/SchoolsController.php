<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Schools;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class SchoolsController extends Controller
{
    public function create()
    {
        return view('superadmin.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_school' => 'required|max:255',
            'email'       => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('admin.schools_create'))->with('error', 'Error al intentar generar el establecimiento. Intente más tarde.');
        }

        $input = $request->all();

        $user = User::create([
            'name'       => $input['name_school'],
            'email'      => $input['email'],
            'password'   => bcrypt('123456'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($user) {
            Schools::create([
                'name'        => $user->name,
                'description' => $input['description'],
                'user_id'     => $user->id,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ]);
            return redirect(route('admin.schools_create'))->with('status', 'Establecimiento registrado con éxito!');
        }
        return redirect(route('admin.schools_create'))->with('error', 'Error al intentar generar el establecimiento. Intente más tarde.');
    }

    public function edit()
    {
    }

    public function update(Request $request, int $id)
    {
    }

    public function destroy(int $id)
    {
    }
}
