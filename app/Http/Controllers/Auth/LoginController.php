<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/notario/panel';

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
     * Ruta /notario/login
     * return Vista auth.notario_login
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.notario_login');
    }

    /**
     * Generamos un array únicamente con los datos username(), password, estado=1
     * username()->return email
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials=$request->only($this->username(), 'password');
        /**
         * agregamos el estado 1 para saber si el usuario esta activo o
         * por el contrario estado 0 equivale a no activo y no tendra acceso al sistema
         */
        $credentials['estado']=1;

        return $credentials;
    }

    /**
     * Guardamos el id en la sesión
     * return True && panel_notario
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function authenticated(Request $request, $user)
    {
        if($user->session_id){
            Session::getHandler()->destroy($user->session_id);
        }
        $user->session_id = session()->getId();
        $user->save();

        session(['identificador' => $user->id]);
        if ($request->ajax()){

            return response()->json([
                'auth' => auth()->check(),
                'intended' => $this->redirectPath(),
            ]);

        }
    }

    /**
     * Destruye la sesión y redirect to notario_panel
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/notario/panel');
    }

}
