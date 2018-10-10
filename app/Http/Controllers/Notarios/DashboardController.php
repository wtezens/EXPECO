<?php

namespace App\Http\Controllers\Notarios;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\Credit;

class DashboardController extends Controller
{
    private $notario;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function homepage(){
        return view('dashboards.notarios')->with('PageTitle','Notario');
    }

    /**
     * @return mixed
     * dashboard notario
     */
    public function DatosPanel(){

        $this->notario = session('identificador');

        $total_creditos = Credit::where('notary_id',$this->notario)->count();
        $liquidados = Credit::whereNotNull('liquidation_id')->where('notary_id',$this->notario)->count();
        $pendientes = $total_creditos - $liquidados;

        return array('creditos'=>$total_creditos,'liquidados'=>$liquidados,'pendientes'=>$pendientes);
    }
}
