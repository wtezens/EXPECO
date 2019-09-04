<?php

namespace App\Http\Controllers\Historicos;

use App\Http\Requests\Historicos\HistoricosRequest;
use App\Http\Requests\NewAsociadoRequest;
use App\Models\Agency;
use App\Models\Credit;
use App\Models\Notary;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Database\QueryException;

class HistoricosController extends Controller
{
    public function index(){
        $notarios = Notary::select('notaries.id','notaries.nombre')->get();
        $agencias = Agency::select('id','nombre')->get();

        return view('historicos.index',compact(['notarios','agencias']));
    }


    public function store(HistoricosRequest $request){
        //return $request->fecha_de_escrituracion;
        $null = NULL;

        $credit = New Credit();

        //nullable
        if($request->credito>0){
            $credit->credito_id = $request->credito;
        }

        $credit->partner_id = $request->cif;
        $credit->agency_id = $request->agencia;
        $credit->notary_id = $request->notario;
        $credit->user_id = 1;

        //nullable
        if($request->cuenta>0){
            $credit->cuenta = $request->cuenta_ahorro;
        }

        $credit->monto_credito = $request->monto_prestamo;
        $credit->monto_ampliacion = $request->monto_ampliacion;
        $credit->monto_cobrado = $request->gasto_cobrado;
        $credit->cantidad_contratos = $request->contratos;
        $credit->cantidad_escrituras = $request->escrituras;
        $credit->tipo_desembolso = $request->desembolso;
        $credit->tipo_garantia = $request->registrado;


        //nullable
        if($request->numero_de_escritura>0){
            $credit->numero_escritura = $request->numero_de_escritura;
        }

        //nullable
        if($request->fecha_de_escrituracion){
            $credit->fecha_escritura = $request->fecha_de_escrituracion;
        }

        //nullable
        if($request->timbre_notarial){
            $credit->timbre_notarial = $request->timbre_notarial;
        }

        //nullable
        if($request->gasto_papeleria){
            $credit->gasto_papeleria = $request->gasto_papeleria;
        }

        //nullable
        if($request->consulta_electronica){
            $credit->consulta_electronica = $request->consulta_electronica;
        }

        //nullable
        if($request->honorario_notario){
            $credit->honorario_notario = $request->honorario_notario;
        }

        //nullable
        if($request->honorario_registro){
            $credit->honorario_registro = $request->honorario_registro;
        }

        //nullable
        if($request->diferencia){
            $credit->diferencia = $request->diferencia;
        }

        //nullable
        if($request->ajuste_liquidacion){
            $credit->ajuste_liquidacion = $request->ajuste_liquidacion;
        }

        $credit->estado = 2;


        $credit->save();

        $credit->created_at = $request->fecha_creacion;
        $credit->save();

        /**
         * ESTATUS
         */
        //nullable
        if($request->estatus_1){
            $credit->statuses()->attach(1, ['created_at'=>$request->estatus_1]);
        }

        if($request->estatus_2){
            $credit->statuses()->attach(2, ['created_at'=>$request->estatus_2]);
        }

        if($request->estatus_3){
            $credit->statuses()->attach(3, ['created_at'=>$request->estatus_3]);
        }

        if($request->estatus_4){
            $credit->statuses()->attach(4, ['created_at'=>$request->estatus_4]);
        }

        if($request->estatus_5){
            $credit->statuses()->attach(5, ['created_at'=>$request->estatus_5]);
        }

        if($request->estatus_6){
            $credit->statuses()->attach(6, ['created_at'=>$request->estatus_6]);
        }
        if($request->estatus_7){
            $credit->statuses()->attach(7, ['created_at'=>$request->estatus_7]);
        }

        if($request->estatus_8){
            $credit->statuses()->attach(8, ['created_at'=>$request->estatus_8]);
        }

        if($request->estatus_9){
            $credit->statuses()->attach(9, ['created_at'=>$request->estatus_9]);
        }

        if($request->estatus_10){
            $credit->statuses()->attach(10, ['created_at'=>$request->estatus_10]);
        }


        //    'cantidad_anticipo' => 'nullable|numeric'

    }

    public function verifyCif($cif){
        $asociado = Partner::find($cif);

        if(! empty($asociado)){
            return array('status'=>'ok','nombre'=>$asociado->nombre);
        }

        return array('status'=>'fail');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewAsociadoRequest $request
     * @return array|Exception|QueryException
     */
    public function partnerStore(NewAsociadoRequest $request)
    {
        try{

            Partner::create([
                'id'=>$request->asociado['cif'],
                'nombre'=>strtoupper($request->asociado['nombre']),
                'user_id'=>8
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
}
