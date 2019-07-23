<?php

namespace App\Http\Controllers\Soporte;

use App\Http\Controllers\Controller;
use Auth;

class SoporteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:colaborador', 'role:technical_support']);
    }

    public function home()
    {
        return view('dashboards.soporte')->with('PageTitle', 'Soporte');
    }
}
