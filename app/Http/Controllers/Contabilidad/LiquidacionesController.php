<?php

namespace App\Http\Controllers\Contabilidad;

use Auth;
use App\Models\Credit;
use App\Models\Notary;
use App\Models\Liquidation;
use App\Http\Controllers\Controller;

class LiquidacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:colaborador');
    }

    public function generarReporteLiquidacion($liquidacion){
        $datos = Credit::where('liquidation_id',$liquidacion)->first();

        /**
         * VERIFICAMOS SI EL NOTARIO TIENE ACCESO PARA VER LA LIQUIDACION REQUERIDA
         */
        $this->authorize('contabilidad',$datos);

        $datos_liquidacion = Liquidation::find($liquidacion);

        $datos_credito = Credit::select('credits.id as expediente','credits.credito_id','partners.id as cif',
            'credits.numero_escritura as escritura', 'credits.fecha_escritura','partners.nombre',
            'partners.cuenta','credits.monto_credito','credits.timbre_notarial','credits.gasto_papeleria',
            'credits.consulta_electronica','credits.honorario_notario','credits.honorario_registro',
            'advances.cantidad')
            ->Join('partners','credits.partner_id','=','partners.id')
            ->leftJoin('advances','credits.id','=','advances.credit_id')
            ->where('liquidation_id',$liquidacion)
            ->get();


        //$view=view('reportes.liquidacion_pdf', compact('datos_credito','datos_liquidacion'));
        //$pdf=\App::make('dompdf.wrapper');
        //$pdf->loadHTML($view)->setPaper(array(0,0,612.00, 900.00),'landscape');

        //return $pdf->stream();

        //return $datos_credito;
        return view('reportes.liquidacion_pdf',compact('datos_credito','datos_liquidacion'));
    }

    public function listosParaLiquidar(){

        $listos_a_liquidar = Notary::select('notaries.nombre','liquidations.correlativo','liquidations.id',
            'liquidations.created_at as creado')
            ->join('credits','credits.notary_id','=','notaries.id')
            ->join('liquidations','credits.liquidation_id','=','liquidations.id')
            ->groupBy('liquidations.correlativo','notaries.nombre','liquidations.created_at','liquidations.id')
            ->get();

        return $listos_a_liquidar;
    }
}
