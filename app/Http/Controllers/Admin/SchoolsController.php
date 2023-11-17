<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Schools;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
            return redirect(route('admin.schools.create'))->with('error', 'Error al intentar generar el establecimiento. Intente más tarde.');
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
            return redirect(route('admin.schools.create'))->with('status', 'Establecimiento registrado con éxito!');
        }
        return redirect(route('admin.schools.create'))->with('error', 'Error al intentar generar el establecimiento. Intente más tarde.');
    }

    /**
     * edit
     *
     * @param integer $id
     * @author Matías
     */
    public function edit(int $id)
    {
        $data_school = Schools::with('user')->where('user_id', $id)->first();

        return view('superadmin.edit')->with('school', $data_school);
    }

    /**
     * update
     *
     * @param Request $request
     * @author Matías
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_school' => 'required|max:255',
            'school_id'  => 'required',
            'email'       => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('admin.schools.edit', ['id' => $request->school_id]))->with('error', 'Error al intentar editar el establecimiento. Intente más tarde.');
        }

        Log::debug($request->all());

        $user = Schools::with('user')->where('user_id', $request->school_id)->first();

        if ($user) {
            $update_user = User::where('id', $user->user->id)->update([
                'name'       => $request->name_school,
                'email'      => $request->email,
                'updated_at' => Carbon::now(),
            ]);

            if ($update_user) {
                Schools::where('user_id', $user->user_id)->update([
                    'name'        => $request->name_school,
                    'description' => $request->description,
                    'updated_at'  => Carbon::now(),
                ]);
                return redirect(route('admin.schools.edit', ['id' => $request->school_id]))->with('status', 'Establecimiento editado con éxito!');
            }
            return redirect(route('admin.schools.edit', ['id' => $request->school_id]))->with('error', 'Error al actualizar el establecimiento ' . $user->name);
        }
    }

    /**
     * destroy
     *
     * @param Request $request
     * @author Matías
     */
    public function destroy(Request $request)
    {
        $input       = $request->all();
        $data_school = Schools::where('user_id', $input['school_id'])->first();
        //Log::debug($data_school);
        $data_school->is_active  = $data_school->is_active ? false : true;
        $data_school->updated_at = Carbon::now();
        $data_school->save();
        return redirect(route('admin.dashboard', ['id' => $request->school_id]))->with('status', 'Establecimiento actualizado con éxito!');
    }
}
