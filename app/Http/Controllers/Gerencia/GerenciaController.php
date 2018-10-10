<?php

namespace App\Http\Controllers\Gerencia;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use Auth;

class GerenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:colaborador');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('dashboards.secretaria_gerencia')->with('PageTitle','Gerencia');
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id){

        $credito= Credit::find($id);

        $this->authorize('gerencia',$credito);

        return $credito->with('statuses')->with('agency:id,nombre')->with('notary:id,nombre')
            ->with('partner')->where('id',$id)
            ->get();
    }


    public function estatusCinco($idexpediente){
        try {
            $credito=Credit::where('id',$idexpediente)->firstOrFail();

            $this->authorize('gerencia',$credito);

            $credito->statuses()->attach(5);
            return array('estatus'=>'ok','descripcion'=>'Estatus agregado correctamente');

        } catch (\Illuminate\Database\QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                if(request()->wantsJson()){
                    return array('estatus'=>'save_fail','descripcion'=>'Valores duplicados');
                }
            }
        } catch (\Exception $e){
            if(request()->wantsJson()){
                return $e;
            }
        } catch (ModelNotFoundException $ex) {
            return array('estatus'=>'fail','descripcion'=>'Asegurese de que el contrato es el correcto.');
        }
    }


    public function estatusSeis($idexpediente){
        try {
            $credito=Credit::where('id',$idexpediente)->firstOrFail();

            $this->authorize('gerencia',$credito);

            $credito->statuses()->attach(6);
            return array('estatus'=>'ok','descripcion'=>'Estatus agregado correctamente');

        } catch (\Illuminate\Database\QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                if(request()->wantsJson()){
                    return array('estatus'=>'save_fail','descripcion'=>'Valores duplicados');
                }
            }
        } catch (\Exception $e){
            if(request()->wantsJson()){
                return $e;
            }
        } catch (ModelNotFoundException $ex) {
            return array('estatus'=>'fail','descripcion'=>'Asegurese de que el contrato es el correcto.');
        }
    }

}
