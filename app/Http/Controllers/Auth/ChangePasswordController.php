<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Hash;
use App\Models\Notary;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Cambio de contraseña del notario
     * @param ChangePasswordRequest $request
     * @return array
     */
    public function changePassword(ChangePasswordRequest $request){

        if (Hash::check($request->mypassword, Auth::user()->password)){

            Notary::where('email', '=', Auth::user()->email)
                ->update(['password' => bcrypt($request->password)]);

            return array('estatus'=>'ok');
        }else{
            return array('estatus'=>'fail','descripcion'=>'Credenciales incorrectas');
        }
    }
}