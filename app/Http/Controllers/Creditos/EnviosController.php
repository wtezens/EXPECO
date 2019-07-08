<?php

namespace App\Http\Controllers\Creditos;

use Auth;
use App\Models\Credit;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EnvioRequest;
use App\Http\Controllers\Controller;

class EnviosController extends Controller
{
    private $Agencia;

    public function __construct()
    {
        $this->middleware(['auth:colaborador','role:credit_secretary']);

    }

    /**
     * Devolvemos todos los creditos listos a envio a notario
     * Requisito haber agregado el estatus 1
     * @param $notario_id
     * @return \Illuminate\Support\Collection
     */
    public function envioNotario($notario_id){

        $this->Agencia = session('agency_id');

        $envio = Credit::select('credits.id as expediente','partners.id as cif','partners.nombre as asociado')
            ->join('partners','credits.partner_id','=','partners.id')
            ->whereNotIn('credits.id',function ($subq){
                $subq->from('credit_status')
                    ->selectRaw('credit_id')
                    ->where('status_id','=',2);
            })
            ->where('agency_id', $this->Agencia)
            ->where('notary_id', $notario_id)
            ->limit(19)
            ->get();

        return $envio;
    }

    /**
     * Recibimos un array con los creditos listos para generar el respectivo envio de notario
     * Validamos si los créditos del array son de la misma agencia del colaborador logueado
     * Generamos un correlativo que queda almacenado en la base de datos
     * @param $notario_id
     * @param EnvioRequest $request
     * @return array|\Exception|\Illuminate\Database\QueryException
     */
    public function generarEnvio($notario_id, EnvioRequest $request){

        $correlativo = $notario_id.now()->format('ymdhis');

        DB::beginTransaction();

        try{
            foreach ($request->datos as $expediente){

                $credito = Credit::find($expediente);

                $this->authorize('same_agency',$credito);

                $credito->statuses()->attach(2);
                $credito->reports()->attach(1,['correlativo'=>$correlativo]);
            }

            DB::commit();
            if(request()->wantsJson()){
                return array('estatus'=>'ok','route'=>$correlativo);
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
    }

    /**
     * Devolvemos un reporte con los datos del correlativo que agrupa los creditos
     * @param $correlativo
     * @return mixed
     */
    public function generarReporte($correlativo){

        $reporte = Credit::select('credits.id as expediente','partners.id as cif','partners.nombre as asociado',
                'credits.cantidad_contratos as contratos','credits.cantidad_escrituras as escrituras')
            ->Join('partners','partners.id','=','credits.partner_id')
            ->Join('credit_report','credit_report.credit_id','=','credits.id')
            ->where('credit_report.correlativo', $correlativo)
            ->get();

        $view=view('reportes.envio_a_notario_pdf', compact('reporte'));
        $pdf=\App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream();

        //return $pdf->download('envio_'.$correlativo.'.pdf');
        //return view('reportes.envio_a_notario_pdf',compact('reporte'));
    }
}
