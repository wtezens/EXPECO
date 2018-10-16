<?php

namespace App\Http\Controllers\AuthColaborador;

use Auth;
use App\Models\User;
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
    protected $redirectTo = '/colaborador/creditos';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:colaborador')->except('logout');
    }

    /**
     * Ruta /colaborador/login
     * Return Vista auth.colaborador_login
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.colaborador_login');
    }


    /**
     * Guardamos el id && agencya_id en la sesión
     * return True && redirectPath()
     * redirectPat->return route depending of user role
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

        session(['id' => $user->id]);
        session(['agency_id' => $user->agency_id]);
        if ($request->ajax()){

            return response()->json([
                'auth' => auth('colaborador')->check(),
                'intended' => $this->redirectPath(),
            ]);

        }
    }

    public function redirectPath()
    {
        $role = auth('colaborador')->user()->role()->first();
        switch ($role->nombre){
            case 'technical_support':
                return '/soporte/panel';
                break;
            case 'credit_secretary':
                return '/creditos/panel';
                break;
            case 'credit_assistant':
                return '/asistente/panel';
                break;
            case 'assistant_accounting':
                return '/contabilidad/panel';
                break;
            case 'secretary_of_management':
                return '/gerencia/panel';
                break;
            case 'agency_leader':
                return '/agencias/jefes';
                break;
            default:
                return '/gerentes/panel';
                break;
        }
    }

    /**
     * Generamos un array únicamente con los datos username(), password, estado=1
     * username()->return email
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials=$request->only($this->username(), 'password');
        $credentials['estado']=1;

        return $credentials;
    }

    /**
     * Destruye la sesión y redirect to notario_panel
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $this->guard('colaborador')->logout();

        User::where('session_id',$request->session()->getId())->update(['session_id'=>null]);
        $request->session()->invalidate();


        return redirect('/colaborador/login');
    }

    /**
     * Guardia
     * Evalua al usuario sobre la tabla Users
     * @return mixed
     */
    protected function guard()
    {
        return Auth::guard('colaborador');
    }

}
