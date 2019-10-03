<?php

namespace App\Http\Controllers\Contabilidad;

use App\Http\Controllers\Controller;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Exports\Contabilidad\AllCreditsExport;
use App\Exports\Contabilidad\CasosPorNotarioExport;
use App\Exports\Contabilidad\SpecificCreditsExport;
use App\Http\Requests\Contabilidad\ReporteEspecificoRequest;
use App\Http\Requests\Contabilidad\ReporteCasosPorNotarioRequest;

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
        (new AllCreditsExport())->store('reporte_general.xlsx','public')
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
        (new SpecificCreditsExport($request->agencia, $request->notario))
            ->store('reporte_especifico.xlsx','public')
            ->chain([
                new NotifyUserOfCompletedExport($user, $filePath)
            ]);

        return array('estatus'=>'ok','descripcion'=>'Se esta generando su reporte especifico.');
    }

    /**
     * @param ReporteCasosPorNotarioRequest $request
     * @return array
     * Genera un reporte específico de el total de casos por notario y por agencia más gastos.
     */
    public function ReporteCasosPorNotarioYAgencia(ReporteCasosPorNotarioRequest $request){
        $filePath = asset('storage/report_casos_por_notario.xlsx');
        $user = auth()->user();


        /**
         * This file is stored on storage/app/public
         * that path is linked to public/storage
         */
        (new CasosPorNotarioExport($request->fecha_inicial, $request->fecha_final))
            ->store('report_casos_por_notario.xlsx','public')
            ->chain([
                new NotifyUserOfCompletedExport($user, $filePath)
            ]);

        return array('estatus'=>'ok','descripcion'=>'Se esta generando su reporte especifico.');
    }

}
