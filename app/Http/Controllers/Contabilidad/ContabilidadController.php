<?php

namespace App\Http\Controllers\Contabilidad;

use App\Models\Agency;
use App\Models\Notary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class ContabilidadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:colaborador','role:assistant_accounting']);
    }

    public function home(){
        return view('dashboards.contabilidad')->with('PageTitle','Contabilidad');
    }

    public function Notarios()
    {
        $notarios = Notary::select('notaries.id','notaries.nombre')->get();

        if(request()->wantsJson()) {
            return $notarios;
        }
    }

    public function Agencias()
    {
        $agencias = Agency::select('agencies.id','agencies.nombre')->get();

        if(request()->wantsJson()) {
            return $agencias;
        }
    }

}
