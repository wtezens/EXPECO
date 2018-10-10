<?php

namespace App\Http\Controllers\AuthColaborador;

use Auth;
use Hash;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:colaborador');
    }

    /**
     * Cambio de contraseña colaborador
     * @param ChangePasswordRequest $request
     * @return array
     */
    public function changePassword(ChangePasswordRequest $request){

        if (Hash::check($request->mypassword, Auth::user()->password)){

            User::where('email', '=', Auth::user()->email)
                ->update(['password' => bcrypt($request->password)]);

            return array('estatus'=>'ok');
        }else{
            return array('estatus'=>'fail','descripcion'=>'Credenciales incorrectas');
        }
    }
}