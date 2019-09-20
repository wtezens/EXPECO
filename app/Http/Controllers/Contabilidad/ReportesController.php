<?php

namespace App\Http\Controllers\Contabilidad;

use App\Http\Controllers\Controller;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Http\Requests\Contabilidad\ReporteEspecificoRequest;

class ReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:colaborador','role:assistant_accounting']);
    }

    public function ReporteGeneral(){
        $filePath = asset('storage/reporte_general.xlsx');
        $user = auth()->user();

        /**
         * This file is stored on storage/app/public
         * that path is linked to public/storage
         */
        (new \App\Exports\AllCreditsExport())->store('reporte_general.xlsx','public')
            ->chain([
                new NotifyUserOfCompletedExport($user, $filePath)
            ]);

        return array('estatus'=>'ok','descripcion'=>'Se esta generando su reporte.');
    }

    /**
     * Reporte por agencia y notario
     * @param ReporteEspecificoRequest $request
     */
    public function ReporteEspecifico(ReporteEspecificoRequest $request){
        $filePath = asset('storage/reporte_especifico.xlsx');
        $user = auth()->user();

        /**
         * This file is stored on storage/app/public
         * that path is linked to public/storage
         */
        (new \App\Exports\SpecificCreditsExport($request->agencia, $request->notario))
            ->store('reporte_especifico.xlsx','public')
            ->chain([
                new NotifyUserOfCompletedExport($user, $filePath)
            ]);

        return array('estatus'=>'ok','descripcion'=>'Se esta generando su reporte especifico.');
    }
}
