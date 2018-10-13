<?php

namespace App\Http\Controllers\Notarios;

use Auth;
use App\Models\Credit;
use App\Models\Liquidation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddLiquidacionRequest;

class LiquidacionesController extends Controller
{
    private $notario;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $idagencia
     * @return \Illuminate\Support\Collection
     */
    public function showLiquidaciones($idagencia){

        $this->notario = session('identificador');

        $envio=Credit::select('credits.id as expediente','partners.id as cif','partners.nombre as asociado')
            ->Join('credit_status','credits.id','=','credit_status.credit_id')
            ->Join('partners','credits.partner_id','=','partners.id')
            ->whereNotIn('credits.id',function ($subq){
                $subq->from('credit_status')
                    ->selectRaw('credit_id')
                    ->where('status_id','=',8);
            })
            ->where('credit_status.status_id',7)
            ->where('agency_id',$idagencia)
            ->where('notary_id',$this->notario)
            ->orderBy('credits.id')
            ->limit(15)
            ->get();

        return $envio;
    }


    public function generarLiquidacion(AddLiquidacionRequest $request){
        DB::beginTransaction();
        try{

            $liquidacion = Liquidation::create([
                'correlativo'=>$request->liquidacion,
                'agency_id'=>$request->agencia,
            ]);

            foreach ($request->datos as $expediente){

                $credito = Credit::find($expediente);

                $this->authorize('assigned',$credito);

                $credito->statuses()->attach(8);

                $credito->liquidation_id = $liquidacion->id;
                $credito->save();
            }
            DB::commit();
            return array('estatus'=>'ok', 'route'=>$liquidacion->id);
        }
        catch (\Illuminate\Database\QueryException $e){
            DB::rollBack();
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                if(request()->wantsJson()){
                    return array('estatus'=>'duplicate key','error'=>$e);
                }
            }else if($error_code==1366){
                if(request()->wantsJson()){
                    return array('estatus'=>'incorrect type value');
                }
            }else if($error_code==1452){
                if(request()->wantsJson()){
                    return array('estatus'=>'a foreign key constraint fails');
                }
            }
            else{

                if(request()->wantsJson()){
                    return $e;
                }
            }
        }
        catch (\Exception $e){
            DB::rollBack();
            if(request()->wantsJson()){
                return $e;
            }
        }
    }


    public function generarReporteLiquidacion($liquidacion){

        $datos = Credit::where('liquidation_id',$liquidacion)->first();

        /**
         * VERIFICAMOS SI EL NOTARIO TIENE ACCESO PARA VER LA LIQUIDACION REQUERIDA
         */
        $this->authorize('assigned',$datos);

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


    public function ListadoLiquidaciones(){
        $this->notario = session('identificador');

        $liquidaciones=DB::table('credits')
            ->select('credits.liquidation_id as id','liquidations.correlativo','liquidations.created_at as creado','liquidations.fecha_pago')
            ->join('liquidations','credits.liquidation_id','=','liquidations.id')
            ->where('notary_id',$this->notario)
            ->groupby('liquidation_id','liquidations.correlativo','liquidations.created_at','liquidations.fecha_pago')
            ->get();

        return $liquidaciones;
    }
}
