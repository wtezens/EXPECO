<?php

namespace App\Exports\Contabilidad;

use App\Models\Credit;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CasosPorNotarioExport implements FromQuery, WithHeadings, ShouldAutoSize, ShouldQueue
{
    /****
     * DEVUELVE EL TOTAL DE CASOS Y SUS GASTOS POR LICENCIADO Y POR AGENCIA.
     */


    use Exportable;

    public $fecha_inicial;
    public $fecha_final;

    public function __construct($fec_in, $fec_fin)
    {
        $this->fecha_inicial = $fec_in;
        $this->fecha_final = $fec_fin;
    }

    public function query()
    {
        return Credit::query()
            ->join('agencies','credits.agency_id','=','agencies.id')
            ->join('notaries','credits.notary_id','=','notaries.id')
            ->select('agency_id','agencies.nombre','notaries.nombre',
                DB::raw("count(notary_id"),
                DB::raw("(credits.timbre_notarial + credits.gasto_papeleria + credits.consulta_electronica + credits.honorario_notario + credits.honorario_registro + (credits.honorario_notario * 0.12))"))
            ->whereBetween('credits.created_at', [$this->fecha_inicial, $this->fecha_final])
            ->whereNotNull('liquidation_id')
            ->where('credits.estado','<>',0)
            ->groupBy('notary_id', 'agency_id');
    }

    /**
     * @return array
     * Encabezados del reporte
     */
    public function headings(): array
    {
        return [
            'Agencia',
            'Descripcion',
            'Notario',
            'Casos',
            'Total Gastos'
        ];
    }
}
