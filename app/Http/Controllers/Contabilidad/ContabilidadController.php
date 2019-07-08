<?php

namespace App\Http\Controllers\Contabilidad;

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


}
