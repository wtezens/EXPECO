<?php

namespace App\Http\Controllers\Creditos;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use Auth;

class AgenciasController extends Controller
{
    private $idAgencia;

    public function __construct()
    {
        $this->middleware('auth:colaborador');
    }

    public function Agencia() {
        $this->idAgencia = session('agency_id');

        return Agency::select('nombre_agencia')->where('id',$this->idAgencia)->get();
    }

}
