<?php

namespace App\Http\Controllers\Notarios;

use Auth;
use App\Models\Credit;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\EstatusTresRequest;
use App\Http\Requests\AddRechazoExpediente;
use App\Http\Requests\AddInscripcionExpedienteRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreditosController extends Controller
{
    private $notario;

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * @param $id
     * @return Credit[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $datos = Credit::find($id);

        /**
         * PoliticaNotarioCredito
         */
        $this->authorize('assigned',$datos);

        return Credit::with('statuses')->with('partner')->with('advance')
            ->with('agency:id,nombre')
            ->where('id',$id)->get();
    }

    public function agregarEstatusTres($idexpediente, EstatusTresRequest $request){
        try {
            $credito = Credit::where('id',$idexpediente)->whereNull('numero_escritura')->whereNull('fecha_escritura')->firstOrFail();

            /**
             * verificamos si puede modificar los datos
             * Politica: el notario solo puede modificar los creditos que tiene asignado
             */
            $this->authorize('assigned',$credito);

            $credito->numero_escritura = $request->escritura;
            $credito->fecha_escritura = $request->fecha_escritura;

            if($credito->save()){
                $credito->statuses()->attach(3);
                return array('estatus'=>'ok','descripcion'=>'Estatus agregado correctamente');
            }
            else{
                return array('estatus'=>'save_fail','descripcion'=>'Error al guardar los datos');
            }

        }catch (\Illuminate\Database\QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                if(request()->wantsJson()){
                    return array('estatus'=>'save_fail','descripcion'=>'Valores duplicados');
                }
            }else if($error_code==1366){
                if(request()->wantsJson()){
                    return array('estatus'=>'incorrect type value','descripcion'=>'Los tipos de datos enviados no coinciden.');
                }
            }
        }catch (ModelNotFoundException $ex) {
            return array('estatus'=>'fail','descripcion'=>'Asegurese de que el registro no contenga ya los datos a guardar.');
        }
    }

    public function inscripcionExpediente($idexpediente, AddInscripcionExpedienteRequest $request){
        try {
            $credito=Credit::where('id',$idexpediente)->where('honorario_registro',0)->firstOrFail();

            $this->authorize('assigned',$credito);

            $credito->honorario_registro=$request->monto_registro;
            $credito->consulta_electronica=$request->consultas;
            $credito->diferencia=$request->diferencia;

            if($credito->save()){
                $credito->statuses()->attach(7);
                return array('estatus'=>'ok','descripcion'=>'Datos agregados correctamente');
            }
            else{
                return array('estatus'=>'save_fail','descripcion'=>'Error al guardar los datos');
            }

        }catch (\Illuminate\Database\QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                if(request()->wantsJson()){
                    return array('estatus'=>'save_fail','descripcion'=>'Valores duplicados');
                }
            }else if($error_code==1366){
                if(request()->wantsJson()){
                    return array('estatus'=>'incorrect type value','descripcion'=>'Los tipos de datos enviados no coinciden.');
                }
            }
        }catch (ModelNotFoundException $ex) {
            return array('estatus'=>'fail','descripcion'=>'Asegurese de que el registro no contenga ya los datos a guardar.');
        }
    }

    public function NoLiquidados(){
        $this->notario = session('identificador');

        $no_liquidados = DB::table('no_liquidados')
            ->where('notary_id', $this->notario)
            ->get();

        return $no_liquidados;
    }

    public function AddRechazo($idexpediente, AddRechazoExpediente $request){
        try {
            $credito = Credit::where('id',$idexpediente)->whereNull('rechazo')->firstOrFail();

            /**
             * verificamos si puede modificar los datos
             * Politica: el notario solo puede modificar los creditos que tiene asignado
             */
            $this->authorize('assigned', $credito);

            $credito->rechazo = $request->rechazo;

            if($credito->save()){
                return array('estatus'=>'ok','descripcion'=>'Rechazo agregado correctamente');
            }
            else{
                return array('estatus'=>'save_fail','descripcion'=>'Error al guardar los datos');
            }

        }catch (\Illuminate\Database\QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code==1366){
                if(request()->wantsJson()){
                    return array('estatus'=>'incorrect type value','descripcion'=>'Los tipos de datos enviados no coinciden.');
                }
            }
        }catch (ModelNotFoundException $ex) {
            return array('estatus'=>'fail','descripcion'=>'Asegurese de que el registro no contenga ya los datos a guardar.');
        }
    }

}
