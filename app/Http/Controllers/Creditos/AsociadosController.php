<?php

namespace App\Http\Controllers\Creditos;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAsociadoCuentaRequest;
use App\Http\Requests\NewAsociadoRequest;
use App\Models\Credit;
use App\Models\Partner;
use Auth;

class AsociadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:colaborador');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param NewAsociadoRequest $request
     * @return array|\Exception|\Illuminate\Database\QueryException
     */
    public function store(NewAsociadoRequest $request)
    {
        try{
            /*--- @sin_cuenta : true|false    true == 'no tiene cuenta'    false == 'tiene cuenta' ---*/

            if($request->asociado['sin_cuenta']==false){
                Partner::create([
                    'id'=>$request->asociado['cif'],
                    'nombre'=>strtoupper($request->asociado['nombre']),
                    'cuenta'=>$request->asociado['cuenta'],
                    'user_id'=>session('id')
                ]);
            }else{
                /**
                 * no tiene cuenta,
                 * campo cuenta = null
                 */
                Partner::create([
                    'id'=>$request->asociado['cif'],
                    'nombre'=>strtoupper($request->asociado['nombre']),
                    'user_id'=>session('id')
                ]);
            }

            if(request()->wantsJson()){
                return array('estatus'=>'ok');
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

    /**
     * Actualizar Cuenta Asociado
     * @param UpdateAsociadoCuentaRequest $request
     * @param $cif
     * @return array|\Exception|\Illuminate\Database\QueryException
     */
    public function update(UpdateAsociadoCuentaRequest $request, $cif){

        try{
            $asociado = Partner::where('id',$cif)->whereNull('cuenta')->firstOrFail();

            $asociado->cuenta = $request->cuenta;

            if($asociado->save()){
                return array('estatus'=>'ok','descripcion'=>'Cuenta agregada correctamente.');
            }
            else{
                return array('estatus'=>'save_fail','descripcion'=>'Error al guardar los datos');
            }
        }
        catch (\Illuminate\Database\QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                if(request()->wantsJson()){
                    return array('estatus'=>'duplicate key','descripcion'=>'El número de cuenta ya existe.');
                }
            }else if($error_code==1366){
                if(request()->wantsJson()){
                    return array('estatus'=>'incorrect type value', 'descripcion'=>'Los tipos de datos enviados no coinciden.');
                }
            }
            else{
                if(request()->wantsJson()){
                    return $e;
                }
            }
        }
        catch (NotFoundHttpException $ex) {
            return array('estatus'=>'fail','descripcion'=>'Asegurese de que el registro no contenga ya los datos a guardar.');
        }
    }


    /**
     * Busqueda por cif
     * return nombre asociado|fail
     * @param $cif
     * @return array
     */
    public function nombreAsociado($cif){

        $asociado = Partner::find($cif);

        if(! empty($asociado)){
            return array('status'=>'ok','nombre'=>$asociado->nombre);
        }

        return array('status'=>'fail');
    }


    /**
     * Lista de los creditos de un asociado
     * @param $cif
     * @return Partner|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function listOfCredits($cif){
        $listado = Partner::with('listOfCredits')->where('id', $cif)
            ->select('id','nombre','cuenta')->first();

        return $listado;
    }
}