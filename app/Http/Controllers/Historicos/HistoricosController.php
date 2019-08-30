<?php

namespace App\Http\Controllers\Historicos;

use App\Http\Requests\Historicos\HistoricosRequest;
use App\Models\Agency;
use App\Models\Notary;
use App\Http\Controllers\Controller;
use App\Models\Partner;

class HistoricosController extends Controller
{
    public function index(){
        $notarios = Notary::select('notaries.id','notaries.nombre')->get();
        $agencias = Agency::select('id','nombre')->get();

        return view('historicos.index',compact(['notarios','agencias']));
    }


    public function store(HistoricosRequest $request){
        return $request;
    }

    public function verifyCif($cif){
        $asociado = Partner::find($cif);

        if(! empty($asociado)){
            return array('status'=>'ok','nombre'=>$asociado->nombre);
        }

        return array('status'=>'fail');
    }
}
