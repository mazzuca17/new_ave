<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $data = User::role('Docente')->get();
        
        return view('school.docentes.index')->with([
            'data' => $data
        ]);
    }

    public function showFormNew()
    {
    }

    public function saveNewDocente(Request $request)
    {
    }

    public function editById(int $id)
    {
    }

    public function saveEdit(Request $request)
    {
    }
}
