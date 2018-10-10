<?php

namespace App\Http\Controllers\Soporte;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class SoporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:colaborador');
    }

    public function home(){
        return view('dashboards.soporte');
    }
}
