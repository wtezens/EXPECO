<?php

namespace App\Http\Controllers\Creditos;

use App\Http\Controllers\Controller;
use App\Models\Notary;
use Auth;

class NotariosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:colaborador','role:credit_secretary']);
    }

    /**
     * Devolvemos el listado de notarios disponibles
     */
    public function Notarios(){

        $notarios = Notary::select('notaries.id','notaries.nombre')
            ->where('estado','=','1')->get();

        if(request()->wantsJson()) {
            return $notarios;
        }

    }
}