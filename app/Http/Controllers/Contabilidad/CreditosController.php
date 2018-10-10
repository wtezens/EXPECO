<?php

namespace App\Http\Controllers\Contabilidad;

use Auth;
use App\Models\Credit;

use App\Http\Controllers\Controller;

class CreditosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:colaborador');
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
        $this->authorize('contabilidad', $datos);

        return Credit::with('statuses')->with('partner')->with('advance')
            ->where('id',$id)->get();
    }

    /**
     * Validar si el número de expediente ya existe
     * @param $expediente
     * @return array
     */
    public function validarExpediente($expediente){
        $credito = Credit::find($expediente);

        if(empty($credito)){
            return array('status'=>'fail');
        }

        return array('status'=>'ok');
    }


}
