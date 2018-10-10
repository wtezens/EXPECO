<?php

namespace App\Http\Controllers\Creditos;

use Auth;
use App\Models\Credit;
use App\Models\Agency;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewCreditoRequest;
use App\Http\Requests\AddDesembolsoRequest;
use Illuminate\Support\Facades\DB;

class CreditosController extends Controller
{
    private $idAgencia;

    public function __construct()
    {
        $this->middleware('auth:colaborador');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboards.creditos')->with('PageTitle','Créditos');
    }

    /**
     * return Datos sobre creditos y el nombre de la agencia del colaborador
     * @return array
     */
    public function DatosDashboard(){

        $this->idAgencia = session('agency_id');

        $total_creditos = Credit::where('agency_id',$this->idAgencia)->count();
        $total_liquidados = Credit::whereNotNull('liquidation_id')->where('agency_id',$this->idAgencia)->count();
        $pendientes = $total_creditos - $total_liquidados;
        $agencia = Agency::select('nombre')->where('id',$this->idAgencia)->get();

        return array('total_creditos'=>$total_creditos,'total_liquidados'=>$total_liquidados,
            'pendientes'=>$pendientes, 'agencia'=>$agencia);
    }


    /**
     * Store a newly created resource in storage.
     * @param NewCreditoRequest $request
     * @return array|\Exception|\Illuminate\Database\QueryException
     */
    public function store(NewCreditoRequest $request)
    {
        try{
            $new_credito = Credit::create([
                'partner_id' => $request->cif,
                'agency_id' => session('agency_id'),
                'notary_id' => $request->notario,
                'user_id' => session('id'),
                'monto_credito' => $request->montoCredito,
                'monto_ampliacion' => $request->montoAmpliacion,
                'monto_cobrado' => $request->gastosCobrados,
                'cantidad_contratos' => $request->contratos,
                'cantidad_escrituras' => $request->escrituras,
                'tipo_desembolso' => $request->desembolso,
                'tipo_garantia' => $request->garantia,
                'nuevo' => $request->nuevo
            ]);

            /**
             * IF THE NEW RECORD IS CREATED INSERT A NEW STATUS NO.1
             */
            $new_credito->statuses()->attach(1);
            if(request()->wantsJson()){
                return array('estatus' => 'ok','correlativo'=>$new_credito->id);
            }

        }catch (\Illuminate\Database\QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                if(request()->wantsJson()){
                    return array('estatus'=>'duplicate key');
                }
            }
            else if($error_code==1452){
                if(request()->wantsJson()){
                    return array('estatus'=>'a foreign key constraint fails');
                }
            }
            else if($error_code==1366){
                if(request()->wantsJson()){
                    return array('estatus'=>'incorrect type value');
                }
            }
            else{
                if (request()->wantsJson()){
                    return $e;
                }
            }
        }catch (\Exception $e){
            if(request()->wantsJson()){
                return $e;
            }
        }

    }

    /**
     * Mostrar el detalle del expediente
     * Display the specified resource.
     *
     * @param  int $id
     * @return Credit[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function show($id)
    {
        $credito = Credit::with('statuses')->with('notary:id,nombre')
            ->with('partner')->where('id', $id)
            ->get();

        return $credito;
    }

    /**
     * Agrega el respectivo desembolso
     * @param $idexpediente
     * @param AddDesembolsoRequest $request
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function desembolso($idexpediente, AddDesembolsoRequest $request){
        try {
            $credito = Credit::where('id', $idexpediente)->whereNull('credito_id')->firstOrFail();

            $this->authorize('same_agency', $credito);

            $credito->credito_id=$request->credito;
            $credito->timbre_notarial=$request->timbres;
            $credito->gasto_papeleria=$request->gastos;
            $credito->honorario_notario=$request->honorarios;

            if($credito->save()){
                $credito->statuses()->attach(10);
                return array('estatus'=>'ok','descripcion'=>'Desembolso agregado correctamente');
            }
            else{
                return array('estatus'=>'save_fail','descripcion'=>'Error al guardar los datos');
            }

        }catch (\Illuminate\Database\QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                if(request()->wantsJson()){
                    return array('estatus'=>'save_fail','descripcion'=>'Valores duplicados');
                }
            }else if($error_code==1366){
                if(request()->wantsJson()){
                    return array('estatus'=>'incorrect type value','descripcion'=>'Los tipos de datos enviados no coinciden.');
                }
            }
        }
        catch (ModelNotFoundException $ex) {
            return array('estatus'=>'fail','descripcion'=>'Asegurese de que el registro no contenga ya los datos a guardar.');
        }

    }

    /***
     * Agrega el estatus 4 = 'Recepción y Revisión Jefe de agencia
     * @param $idexpediente
     * @return array|\Exception|\Illuminate\Database\QueryException
     */
    public function estatusCuatro($idexpediente){
        try{
            $credito = Credit::where('id', $idexpediente)->firstOrFail();

            $this->authorize('same_agency',$credito);

            $credito->statuses()->attach(4);

            return array('estatus'=>'ok','descripcion'=>'Estatus agregado correctamente');

        }catch (\Illuminate\Database\QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                if(request()->wantsJson()){
                    return array('estatus'=>'save_fail','descripcion'=>'Valores duplicados');
                }
            }
        }catch (\Exception $e){
            if(request()->wantsJson()){
                return $e;
            }
        }catch (ModelNotFoundException $ex) {
            return array('estatus'=>'fail','descripcion'=>'Asegurese de que el contrato es el correcto.');
        }
    }

    public function NoLiquidados(){
        $this->idAgencia = session('agency_id');

        $no_liquidados = DB::table('no_liquidados')
            ->where('agency_id', $this->idAgencia)
            ->get();

        return $no_liquidados;
    }
}