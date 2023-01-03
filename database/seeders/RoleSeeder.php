<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\RoleUser;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role               = new Role();
        $role->name         = "Superadmin";
        $role->display_name = ucwords('Superadmin');
        $role->save();

        $role               = new Role();
        $role->name         = "Colegio";
        $role->display_name = ucwords('Colegio');
        $role->save();

        $role               = new Role();
        $role->name         = "Docente";
        $role->display_name = ucwords('Docente');
        $role->save();

        $role               = new Role();
        $role->name         = "Alumno";
        $role->display_name = ucwords('Alumno');
        $role->save();


        $users = User::all();

        foreach ($users as $user) {
            $roleUser = new RoleUser();
            $roleUser->user_id = $user->id;
            $roleUser->role_id = $user->id;
            $roleUser->save();
        }
    }
}
