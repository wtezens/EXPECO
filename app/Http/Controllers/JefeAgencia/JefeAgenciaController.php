<?php

namespace App\Http\Controllers\JefeAgencia;

use Auth;
use App\Models\Credit;
use App\Models\Partner;
use App\Http\Controllers\Controller;

class JefeAgenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:colaborador','role:agency_leader']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('dashboards.jefe_agencia')->with('PageTitle','Jefes');
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id){

        $credito= Credit::find($id);

        $this->authorize('jefeAgencia',$credito);

        return $credito->with('statuses')->with('agency:id,nombre')->with('notary:id,nombre')
            ->with('partner')->where('id',$id)
            ->get();
    }


    /**
     * Lista de los creditos de un asociado
     * @param $cif
     * @return Partner|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function listOfCredits($cif){
        $listado = Partner::with('listOfCredits')->where('id', $cif)
            ->select('id','nombre','cuenta')->first();

        return $listado;
    }

}
