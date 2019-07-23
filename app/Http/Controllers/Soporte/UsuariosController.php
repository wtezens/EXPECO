<?php

namespace App\Http\Controllers\Soporte;

use App\Http\Requests\EmailRequest;
use App\Http\Requests\FindByEmailRequest;
use App\Http\Requests\FindByNameRequest;
use App\Http\Requests\NewNotaryRequest;
use App\Http\Requests\NewUserRequest;
use App\Models\Agency;
use App\Models\Notary;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;

class UsuariosController extends Controller
{
    public function getUsers(){
        $users = User::select(['id','email','nombres','apellidos','role_id',
            'estado as active','created_at','updated_at'])->with('role:id,descripcion')->get();
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
/*------------ Funcion para obtener los datos del usuario -------*/
    public function show(FindByEmailRequest $request){
        $list = User::select('id','nombres','apellidos','email','estado',
            'created_at','updated_at','agency_id','role_id')
            ->with('Role:id,descripcion')
            ->with('Agency:id,nombre')
            ->where('email', $request->email)->get();
/* Verifica los correos existentes y como ninguno coincide nos devuelve resultado negativo */
        if ($list->count()== 0){
            return response()->json(['resultado'=>'No se encontraron coincidencias.'],200);
        }
        /*Valida que exista por lo menos un dato y que lo muestre*/
        return response()->json(['datos'=>$list[0], 'total'=>$list->count()]);
    }

    /*----Funcion para almacenar el nuevo usuario----*/
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
                    'creado_por' => session('id')
                ]);
                /*Mensaje que el usuario se creo correctamente*/
                return response()->json(['estatus' => 'ok', 'descripcion' => 'Usuario creado correctamente.'], 200);
            }else{
                /*Mensaje que fallo la carga*/
                return response()->json(['estatus' => 'fail', 'descripcion' => 'El correo no pudo ser almacenado.'], 200);
            }
            /*Mensajes de Errores*/
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
/*------- Actualizar el estado del Usuario ---------*/
    public function updateUserState($id, EmailRequest $request)
    {
        $user = User::find($id);
        if ($user->email == $request->get('email')) {
            if ($user->estado === 0) {
                $user->estado = 1;
            } else {
                $user->estado = 0;
            }
            $user->save();
            /*---Mensaje de cambio de estado satisfactorio---*/
            return response()->json(['estado'=>'ok','descripcion'=>'Datos Actualizados.','current_state'=>$user->estado],200); /*'estado'=>$user->estado],200*/
        } else {
            /*--- Mensaje que devuelve error al cambiar el estado ---*/
            return response()->json(['estado' => 'error', 'descripcion' => 'La información no pudo ser procesada.']
                , 200);
        }
    }

/*--------------------- RUTAS NOTARIOS---------------------*/

    public function getNotarios(){
        $notaries = Notary::select(['id', 'email', 'nombre', 'telefono', 'direccion',
            'estado as active', 'created_at', 'updated_at'])->with('role:id,descripcion')->get();
        return response()->json(['datos'=>$notaries, 'total' =>$notaries->count()]);
    }

    public function verifyEmailNotary($email){
        $notary=Notary::where('email', $email)->first();
        /*si $notary = "" return TRUE*/
        return empty($notary);
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
/*---------- Almacenamiento de Nuevo Notario ---------*/
    public function storeNotary(NewNotaryRequest $request){
        try {
            if ($this->verifyEmailNotary($request->email)) {
            $new_notary = Notary::create([
                'email' => $request->email,
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'password' => bcrypt($request->password),
                'creado_por' => session('id')
            ]);
            return response()->json(['estatus' => 'ok', 'descripcion' => 'Notario creado correctamente.'],200);
        } else {
            return response()->json(['estatus' => 'fail', 'descripcion' => 'El correo ya esta registrado.'], 200);
        }
            /*Errores posibles*/
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
/*--- Muestra el notario requerido por medio del email----*/
    public function showNotaries(FindByEmailRequest $request){
        $list = Notary::select('id','nombre','email','telefono','direccion','estado',
            'created_at','updated_at')
            ->where('email', $request->email)->get();
        if ($list->count()== 0){
            /* Valida que el correo exista */
            return response()->json(['resultado'=>'No se encontraron coincidencias.'],200);
        }
        /* Muestra el correo encontrado */
        return response()->json(['datos'=>$list[0], 'total'=>$list->count()]);
    }
/* Actualiza el estado del Notario Creado */
    public function updateNotaryState($id, EmailRequest $request){
        $notary = Notary::find($id);
        if($notary->email == $request->get('email')){
            if($notary->estado === 0) {
                $notary->estado = 1;
            } else {
                $notary->estado = 0;
            }
            $notary->save();
            /* Notario con estado actualizado correctamente, ya sea activo o Inactivo */
            return response()->json(['estado'=>'ok','descripcion'=>'Datos Actualizados.','current_state'=>$notary->estado],200);
        }else{
            /* Error al actualizar el estado del notario */
            return response()->json(['estado'=>'error', 'descripcion'=>'Los datos no coinciden.'],200);
        }
    }
}
