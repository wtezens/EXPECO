<?php

namespace App\Http\Controllers\Soporte;

use App\Models\Agency;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\EmailRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\NewUserRequest;

class SoporteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:colaborador','role:technical_support']);
    }

    public function home()
    {
        return view('dashboards.soporte')->with('PageTitle', 'Soporte');
    }

    public function getUsers(){
        $users = User::select(['id','email','nombres','apellidos','role_id',
            'estado as active','created_at','updated_at'])->with('role:id,descripcion')->get();
        return response()->json(['datos'=>$users,'total'=>$users->count()]);
    }

    public function getOneUser($id){
        return User::select(['id','email','nombres','apellidos','role_id',
            'estado as active','created_at','updated_at'])->with('role:id,descripcion')
            ->where('id',$id)->get();
    }

    public function getRoles(){
        return Role::select('id','nombre','descripcion as desc')->get();
    }

    public function getAgencias(){
        return Agency::select('id','nombre', 'direccion as dir')->get();
    }
    /**
     * VALIDAMOS QUE EL EMAIL NO EXISTA EN LA BD
     * @param EmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function validateEmail(EmailRequest $request){

        if($this->verifyEmail($request->email)){
            //el usuario no existe
            return response()->json(['estatus'=>'ok', 'descripcion'=>'El usuario no existe.'],200);
        }else{
            //el usuario existe
            return response()->json(['estatus'=>'fail', 'descripcion'=>'El usuario ya existe.'],200);
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

        try {
            if($this->verifyEmail($request->email)){

                $new_user = User::create([
                    'email'     => $request->email,
                    'role_id'   => $request->role,
                    'agency_id' => $request->agencia,
                    'nombres'      => $request->nombre,
                    'apellidos'   => $request->apellido,
                    'password'  => bcrypt($request->password),
                    'created_by'=> session('id')
                ]);

                return response()->json(['estatus' => 'ok','descripcion'=>'Usuario creado correctamente.',
                    'user'=>$this->getOneUser($new_user->id)],200);

            } else {

                return response()->json(['estatus'=>'fail', 'descripcion'=>'El correo ya esta registrado.'],200);

            }

        }catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                if(request()->wantsJson()){
                    return array('estatus'=>'duplicate key');
                }
            }
            else if($error_code==1452){
                if(request()->wantsJson()){
                    return array('estatus'=>'a foreign key constraint fails');
                }
            }
            else if($error_code==1366){
                if(request()->wantsJson()){
                    return array('estatus'=>'incorrect type value');
                }
            }
            else{
                if (request()->wantsJson()){
                    return $e;
                }
            }
        }catch (\Exception $e){
            if(request()->wantsJson()){
                return $e;
            }
        }
    }
    public function updateUserState($id, EmailRequest $request){
        $user = User::find($id);

        if($user->email == $request->get('email')){

            if($user->state===0){
                $user->state = 1;
            }else {
                $user->state = 0;
            }

            $user->save();

            return response()->json(['estatus'=>'ok', 'estate'=>$user->state],200);

        } else {

            return response()->json(['estatus'=>'error', 'descripcion'=>'Los datos no coinciden.']
                ,200);

        }

    }


}
