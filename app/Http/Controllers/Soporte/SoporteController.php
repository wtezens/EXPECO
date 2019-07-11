<?php

namespace App\Http\Controllers\Soporte;

use App\Http\Requests\FindByEmailRequest;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class SoporteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:colaborador', 'role:technical_support']);
    }

    public function home()
    {
        return view('dashboards.soporte')->with('PageTitle', 'Soporte');
    }

   /* public function updateUserState($id, EmailRequest $request)
    {
        $user = User::find($id);
        if ($user->email == $request->get('email')) {
            if ($user->state === 0) {
                $user->state = 1;
            } else {
                $user->state = 0;
            }
            $user->save();
            return response()->json(['estatus' => 'ok', 'estado' => $user->estado], 200);
        } else {
            return response()->json(['estatus' => 'error', 'descripcion' => 'Los datos no coinciden.']
                , 200);
        }
    }*/

    public function show(FindByEmailRequest $request){
        $list = User::select(
            'role_id',
            'agency_id',
            'nombres',
            'apellidos',
            'email',
            'estado',
            'created_at',
            'updated_at'
        )
            ->with('role:id,descripcion')
            ->with('agency:id,nombre')
            ->where('email',$request->email)->get();
        if ($list->count()== 0){
            return response()->json(['resultado'=>'No se encontraron coincidencias.'],200);
        }
        return response()->json(['datos'=>$list[0], 'total'=>$list->count()]);
    }

    public function listUsers($email){
        $list = Agency::with('listUsers')->where('id', $email)
            ->select('id','nombre')->first();
        return $list;
    }
}
