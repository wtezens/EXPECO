<?php

namespace App\Http\Controllers\Soporte;

use App\Http\Requests\EmailRequest;
use App\Http\Requests\NewNotaryRequest;
use App\Http\Requests\NewUserRequest;
use App\Models\Agency;
use App\Models\Notary;
use App\Models\Role;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsuariosController extends Controller
{
    public function getUsers(){
        $users = User::select(['id','email','nombres','apellidos','role_id',
            'estado as active','created_at','updated_at','estado'])->with('role:id,descripcion')->get();
        return response()->json(['datos' => $users, 'total' => $users->count()]);
    }

    public function getRoles(){
        return Role::select('id','nombre','descripcion as desc')->get();
    }

    public function getAgencias(){
        return Agency::select('id','nombre','direccion as dir')->get();
    }

    /**
     * VALIDAMOS QUE EL EMAIL NO EXISTA EN LA BD
     * @param EmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function validateEmail(EmailRequest $request){
        if ($this->verifyEmail($request->email)){
            /*cuando el usuario no existe*/
            return response()->json(['estatus'=>'ok','descripcion'=>'El usuario no existe.'],200);
        } else{
            /*Cuando el usuario existe*/
            return response()->json(['estatus'=>'fail', 'descripcion'=>'El usuario ya existe'],200);
        }
    }

    public function verifyEmail($email)
    {
        $user = User::where('email', $email)->first();
        /**
         * si $user = "" return TRUE
         */
        return empty($user);
    }

    public function storeUser(NewUserRequest $request){
        try{
            if ($this->verifyEmail($request->email)){
                $new_user = User::create([
                    'email' => $request->email,
                    'role_id' => $request->role,
                    'agency_id' => $request->agencia,
                    'nombres' => $request->nombre,
                    'apellidos' => $request->apellido,
                    'password' => bcrypt($request->password),
                    'created_by' => session('id')
                ]);
                return response()->json(['estatus' => 'ok', 'descripcion' => 'Usuario creado correctamente.'], 200);
            }else{
                return response()->json(['estatus' => 'fail', 'descripcion' => 'El correo ya esta registrado.'], 200);
            }
        }catch (\Illuminate\Database\QueryException $e){
            $error_code = $e->errorInfo[1];
            if ($error_code == 1062) {
                if (request()->wantsJson()) {
                    return array('estatus' => 'duplicate key');
                }
            } else if ($error_code == 1452) {
                if (request()->wantsJson()) {
                    return array('estatus' => 'a foreign key constraint fails');
                }
            } else if ($error_code == 1366) {
                if (request()->wantsJson()) {
                    return array('estatus' => 'incorrect type value');
                }
            } else {
                if (request()->wantsJson()) {
                    return $e;
                }
            }
        }catch (\Exception $e) {
            if (request()->wantsJson()) {
                return $e;
            }
        }
    }


/*--------------------- RUTAS NOTARIOS---------------------*/
    public function getNotarios(){
        $notaries = Notary::select(['id', 'email', 'nombre', 'telefono', 'direccion',
            'estado as active', 'created_at', 'updated_at'])->with('role:id,descripcion')->get();
        return response()->json(['datos'=>$notaries, 'total' =>$notaries->count()]);
    }

    public function verifyEmailNotary($email){
        $user=Notary::where('email', $email)->first();
        /*si $user = "" return TRUE*/
        return empty($user);
    }

    public function validateEmailNotary(EmailRequest $request){
        if ($this->verifyEmailNotary($request->email)) {
            //el usuario no existe
            return response()->json(['estatus' => 'ok', 'descripcion' => 'El usuario no existe.'], 200);
        } else {
            //el usuario existe
            return response()->json(['estatus' => 'fail', 'descripcion' => 'El usuario ya existe.'], 200);
        }
    }

    public function storeNotary(NewNotaryRequest $request){
        try {
            if ($this->verifyEmailNotary($request->email)) {
            $new_notary = Notary::create([
                'email' => $request->email,
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'password' => bcrypt($request->password),
                'created_by' => session('id')
            ]);
            return response()->json(['estatus' => 'ok', 'descripcion' => 'Notario creado correctamente.'],200);
        } else {
            return response()->json(['estatus' => 'fail', 'descripcion' => 'El correo ya esta registrado.'], 200);
        }
        }catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
        if ($error_code == 1062) {
            if (request()->wantsJson()) {
                return array('estatus' => 'duplicate key');
            }
        } else if ($error_code == 1452) {
            if (request()->wantsJson()) {
                return array('estatus' => 'a foreign key constraint fails');
            }
        } else if ($error_code == 1366) {
            if (request()->wantsJson()) {
                return array('estatus' => 'incorrect type value');
            }
        } else {
            if (request()->wantsJson()) {
                return $e;
            }
        }
    }catch (\Exception $e) {
            if (request()->wantsJson()) {
            return $e;
            }
        }
    }
}
