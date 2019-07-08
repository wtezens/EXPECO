<?php

namespace App\Http\Controllers\Gerencia;

use Auth;
use App\Models\Credit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationReadyForRegistration;

class GerenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:colaborador','role:secretary_of_management']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('dashboards.secretaria_gerencia')->with('PageTitle','Gerencia');
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id){

        $credito= Credit::find($id);

        $this->authorize('gerencia',$credito);

        return $credito->with('statuses')->with('agency:id,nombre')->with('notary:id,nombre')
            ->with('partner')->where('id',$id)
            ->get();
    }


    public function estatusCinco($idexpediente){
        try {
            $credito=Credit::where('id',$idexpediente)->firstOrFail();

            $this->authorize('gerencia',$credito);

            $credito->statuses()->attach(5);
            return array('estatus'=>'ok','descripcion'=>'Estatus agregado correctamente');

        } catch (\Illuminate\Database\QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                if(request()->wantsJson()){
                    return array('estatus'=>'save_fail','descripcion'=>'Valores duplicados');
                }
            }
        } catch (\Exception $e){
            if(request()->wantsJson()){
                return $e;
            }
        } catch (ModelNotFoundException $ex) {
            return array('estatus'=>'fail','descripcion'=>'Asegurese de que el contrato es el correcto.');
        }
    }

    /**
     * @param $idexpediente
     * @return array|\Exception|\Illuminate\Database\QueryException
     * Estatus 6: Envio a Inscripción Registral
     */
    public function estatusSeis($idexpediente){
        try {
            $credito = Credit::where('id', $idexpediente)->firstOrFail();

            $this->authorize('gerencia', $credito);

            $credito->statuses()->attach(6);

            //Enviar confirmación al correo del notario
            Mail::to($credito->notary->email)
                ->send(new NotificationReadyForRegistration($credito));

            return array('estatus'=>'ok','descripcion'=>'Estatus agregado correctamente');

        } catch (\Illuminate\Database\QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                if(request()->wantsJson()){
                    return array('estatus'=>'save_fail','descripcion'=>'Valores duplicados');
                }
            }
        } catch (\Exception $e){
            if(request()->wantsJson()){
                return $e;
            }
        } catch (ModelNotFoundException $ex) {
            return array('estatus'=>'fail','descripcion'=>'Asegurese de que el contrato es el correcto.');
        }
    }

}
