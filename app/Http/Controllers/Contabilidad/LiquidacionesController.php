<?php

namespace App\Http\Controllers\Contabilidad;

use Auth;
use App\Models\Credit;
use App\Models\Notary;
use App\Models\Liquidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
         * VERIFICAMOS SI TIENE ACCESO PARA VER LA LIQUIDACION REQUERIDA
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

    /**
     * Devuelve un listado de las liquidaciones que aun no han sido pagadas
     * @return mixed
     */
    public function listosParaLiquidar(){

        $listos_a_liquidar = Notary::select('notaries.nombre','liquidations.correlativo','liquidations.id',
            'liquidations.created_at as creado',DB::raw('
            sum(credits.timbre_notarial+credits.gasto_papeleria+credits.consulta_electronica+
            credits.honorario_notario+(credits.honorario_notario*0.12)+credits.honorario_registro) as monto
            '))
            ->join('credits','credits.notary_id','=','notaries.id')
            ->join('liquidations','credits.liquidation_id','=','liquidations.id')
            ->whereNull('liquidations.fecha_pago')
            ->groupBy('liquidations.correlativo','notaries.nombre','liquidations.created_at','liquidations.id')
            ->get();

        return $listos_a_liquidar;
    }


    /**
     * Devuelve un listado de aquillas liquidaciones ya pagadas
     * @return mixed
     */
    public function YaLiquidados(){

        $listos_a_liquidar = DB::table('notaries')->select('notaries.nombre','liquidations.correlativo','liquidations.id',
            'liquidations.created_at as creado','liquidations.fecha_pago as pago','agencies.nombre as agencia'
            ,DB::raw('sum(credits.timbre_notarial+credits.gasto_papeleria+credits.consulta_electronica+
            credits.honorario_notario+(credits.honorario_notario*0.12)+credits.honorario_registro) as monto
            '))
            ->join('credits','credits.notary_id','=','notaries.id')
            ->join('liquidations','credits.liquidation_id','=','liquidations.id')
            ->join('agencies','agencies.id','=','liquidations.agency_id')
            ->whereNotNull('liquidations.fecha_pago')
            ->groupBy('liquidations.correlativo','notaries.nombre','liquidations.created_at',
                'liquidations.id','liquidations.fecha_pago','agencies.nombre')
            ->get();

        return $listos_a_liquidar;
    }



    /**
     * terminar de procesar una liquidación
     * @param Request $request
     * @param $correlativo
     * @return array|\Exception|\Illuminate\Database\QueryException
     */
    public function EfectuarFechaPagoLiquidacion(Request $request, $correlativo){

        $validatedData = $request->validate([
            'fecha_pago' => 'required|date',
        ]);

        $datos_liquidacion = Liquidation::find($correlativo);


        if(!$datos_liquidacion->fecha_pago){
            DB::beginTransaction();

            try{
                $datos_liquidacion->fecha_pago = $request->fecha_pago;

                $datos_liquidacion->save();

                $datos_creditos = Credit::where('liquidation_id', $correlativo)->get();

                foreach ($datos_creditos as $credito){
                    $credito->statuses()->attach(9);
                }

                DB::commit();
                if(request()->wantsJson()){
                    return array('estatus'=>'ok');
                }
            }
            catch (\Illuminate\Database\QueryException $e){
                DB::rollBack();
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
        }else{
            if(request()->wantsJson()){
                return array('estatus'=>'not empty','descripcion'=>'Esta liquidación ya fue procesada.');
            }
        }

    }
}
