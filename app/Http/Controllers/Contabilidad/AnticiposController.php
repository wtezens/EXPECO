<?php

namespace App\Http\Controllers\Contabilidad;

use Auth;
use Hash;
use App\Models\Advance;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAnticipoRequest;

class AnticiposController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:colaborador');
    }

    /**
     * Validar si el correlativo de anticipo ya existe
     * @param $correlativo
     * @return array
     */
    public function validarCorrelativo($correlativo){
        $anticipo = Advance::find($correlativo);

        if(empty($anticipo)){
            return array('status'=>'fail');
        }

        return array('status'=>'ok');
    }

    public function update($correlativo, UpdateAnticipoRequest $request)
    {
        $anticipo = Advance::where('id', $correlativo)->whereNull('credit_id')->firstOrFail();

        try {
            if (Hash::check($request->clave, $anticipo->clave)) {

                Advance::where('id', '=', $correlativo)
                    ->update(['credit_id' => $request->expediente,
                        'cantidad' => $request->monto]);

                return array('estatus' => 'ok');
            } else {
                return array('estatus' => 'fail', 'descripcion' => 'Credenciales incorrectas');
            }
        }
        catch (\Illuminate\Database\QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                if(request()->wantsJson()){
                    return array('estatus'=>'duplicate key');
                }
            }else if($error_code==1366){
                if(request()->wantsJson()){
                    return array('estatus'=>'incorrect type value');
                }
            }
            else{
                if(request()->wantsJson()){
                    return $e;
                }
            }
        }
        catch (\Exception $e){
            if(request()->wantsJson()){
                return $e;
            }
        }
    }

    public function show(){
        return Advance::all();
    }
}
