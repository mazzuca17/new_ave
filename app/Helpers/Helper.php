<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Helper
{

    /**
     * cehckRole
     *
     * @param mixed $data_user
     * @param integer $rol_id
     * @return null | never 
     * @author Matías
     */
    public static function checkRole($data_user, int $rol_id)
    {
        Log::debug($data_user);
        return Auth::user()->role->role_id == $rol_id ? null  : abort(403);
    }
}
