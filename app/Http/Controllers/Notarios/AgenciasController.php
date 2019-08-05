<?php

namespace App\Http\Controllers\Notarios;

use App\Models\Agency;
use App\Http\Controllers\Controller;
use Auth;

class AgenciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Agencias(){
        /**
         * obtenemos el identificador del notario
         */
        $idlic = session('identificador');

        $agencias = Agency::select('agencies.id as numero','agencies.nombre as descripcion')
            ->get();

        return $agencias;
    }
}
