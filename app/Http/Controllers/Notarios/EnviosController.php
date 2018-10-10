<?php

namespace App\Http\Controllers\Notarios;

use Auth;
use App\Models\Credit;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EnvioRequest;
use App\Http\Controllers\Controller;

class EnviosController extends Controller
{
    private $notario;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function envioRevision($agencia){
        $this->notario = session('identificador');

        $envio=Credit::select('credits.id as expediente','partners.id as cif','partners.nombre as asociado')
            ->join('partners','credits.partner_id','=','partners.id')
            ->whereNotIn('credits.id',function ($subq){
                $subq->from('credit_report')
                    ->selectRaw('credit_id')
                    ->where('report_id','=',2);
            })
            ->where('agency_id',$agencia)
            ->whereNotNull('credits.numero_escritura')
            ->where('notary_id',$this->notario)
            ->limit(15)
            ->get();

        return $envio;
    }


    public function generarEnvioRevision($agencia_id, EnvioRequest $request){
        $correlativo=$agencia_id.now()->format('ymdhis');

        DB::beginTransaction();
        try{
            foreach ($request->datos as $expediente){

                $credito = Credit::find($expediente);

                $this->authorize('assigned',$credito);

                $credito->reports()->attach(2,['correlativo'=>$correlativo]);
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
     * @param $correlativo
     * @return stream pdf
     */
    public function generarReporteRevision($correlativo){

        $reporte = Credit::select('credits.id as expediente','partners.nombre as asociado',
                'credits.fecha_escritura as fecha','credits.numero_escritura as escritura','credits.monto_ampliacion')
            ->Join('partners','partners.id','=','credits.partner_id')
            ->Join('credit_report','credit_report.credit_id','=','credits.id')
            ->where('credit_report.correlativo',$correlativo)
            ->get();

        $view=view('reportes.envio_a_revision_pdf',compact('reporte'));
        $pdf=\App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream();
        //return $pdf->download('envio_'.$correlativo.'.pdf');
        //return view('reportes.envio_a_revision_pdf',compact('reporte'));
    }



    public function NotaExpediente($id){

        $nota = Credit::with('partner:id,nombre')->with('agency:id,nombre')
            ->where('id',$id)->firstOrFail();

        $this->authorize('assigned',$nota);

        $view=view('reportes.nota_desembolso_pdf',compact('nota'));
        $pdf=\App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream();
    }
}