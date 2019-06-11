<?php

namespace App\Http\Controllers\Creditos;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCreditoCuentaRequest;
use App\Http\Requests\NewAsociadoRequest;
use \Illuminate\Database\QueryException;
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
     * @return array|Exception|QueryException
     */
    public function store(NewAsociadoRequest $request)
    {
        try{

            Partner::create([
                'id'=>$request->asociado['cif'],
                'nombre'=>strtoupper($request->asociado['nombre']),
                'user_id'=>session('id')
            ]);

            if(request()->wantsJson()){
                return array('estatus'=>'ok');
            }
        }
        catch (QueryException $e){
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
            ->select('id','nombre')->first();

        return $listado;
    }
}