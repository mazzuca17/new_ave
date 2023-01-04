<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{

    const ADMIN_ROL  = 1;
    const SCHOOL_ROL = 2;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * adminView
     *
     * Función encargada de la definición de vista que van a acceder
     * los usuarios superadmin
     * 
     * @author Matías
     */
    public function adminView()
    {
        if (auth()->user()->role->role_id != self::ADMIN_ROL) {
            $this->showErrorPermission();
        }

        return view('superadmin.dashboard');
    }

    /**
     * showErrorPermission
     *
     * @author Matías
     */
    public function showErrorPermission()
    {
        return abort('403');
    }
}
