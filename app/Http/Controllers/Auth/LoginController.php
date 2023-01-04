<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo       = 'admin/dashboard';
    protected $type_rol_admin   = '1';
    protected $type_rol_school  = '2';
    protected $type_rol_teacher = '3';
    protected $type_rol_student = '4';

    const MESSAGE_ERROR_CREDENTIALS = 'Las credenciales ingresadas no coinciden con nuestros registros.';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Login función 
     *
     * @param Request $request
     * @author Matías
     */
    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email'    => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        if (auth()->attempt(array($fieldType => $input['email'], 'password' => $input['password']))) {
            // Se analiza el tipo de usuario y se define la ruta a donde será redireccionado
            return $this->getRoleUser(auth()->user());
        } else {
            return redirect()->route('login')
                ->with('status', self::MESSAGE_ERROR_CREDENTIALS);
        }
    }

    /**
     * loggedOut
     *
     * @param Request $request
     * @author Matías
     * @access protected
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('login');
    }

    public function getRoleUser($user)
    {
        switch ($user->role->role_id) {
            case $this->type_rol_admin:
                return redirect()->route('admin.dashboard');
                break;

            case $this->type_rol_school:
                return redirect()->route('admin.dashboard');
                break;

            case $this->type_rol_school:
                return redirect()->route('admin.dashboard');
                break;
            case $this->type_rol_student:
                return redirect()->route('admin.dashboard');
                break;
        }
    }
}
