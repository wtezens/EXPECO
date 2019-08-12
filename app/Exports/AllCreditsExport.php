<?php

namespace App\Exports;

use App\Models\Credit;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AllCreditsExport implements FromQuery, WithHeadings, ShouldAutoSize, ShouldQueue
{
    use Exportable;


    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Credit::query()
            ->join('partners','credits.partner_id','=','partners.id')
            ->join('agencies','credits.agency_id','=','agencies.id')
            ->join('notaries','credits.notary_id','=','notaries.id')
            ->leftJoin('liquidations','credits.liquidation_id','=','liquidations.id')
            ->leftJoin('advances','credits.id','=','advances.credit_id')
            ->leftJoin('comments','credits.id','=','comments.credit_id')
            ->select(
                'credits.id',
                'credits.partner_id as cif',
                'partners.nombre as asociado',
                'credits.monto_credito',
                'credits.monto_ampliacion',
                'credits.monto_cobrado',
                'credits.numero_escritura',
                'credits.fecha_escritura',
                'credits.timbre_notarial',
                'credits.gasto_papeleria',
                'credits.consulta_electronica',
                'credits.honorario_notario',
                DB::raw("credits.honorario_notario * 0.12 as iva"),
                'credits.honorario_registro',
                DB::raw("(credits.timbre_notarial + credits.gasto_papeleria + credits.consulta_electronica + credits.honorario_notario + credits.honorario_registro + (credits.honorario_notario * 0.12)) as total_gastos"),
                'credits.diferencia',
                'credits.ajuste_liquidacion',
                'credits.liquidation_id',
                'credits.cuenta',
                'credits.credito_id',
                DB::raw("DATE_FORMAT(credits.created_at,        '%Y-%m-%d') as fecha_creado"),
                DB::raw("DATE_FORMAT(liquidations.created_at,   '%Y-%m-%d') as liquidacion_creada"),
                'liquidations.fecha_pago',
                DB::raw("DATE_FORMAT(advances.updated_at,       '%Y-%m-%d') as fecha_anticipo"),
                DB::raw("DATE_FORMAT(credits.updated_at,        '%Y-%m-%d') as fecha_actualizado"),
                'advances.cantidad as anticipo',
                DB::raw("GROUP_CONCAT(comments.descripcion SEPARATOR ' *** ') AS comentarios"),
                'agencies.nombre as agencia',
                'notaries.nombre as notario'
            )
            ->where('credits.estado', 1)
            ->groupBy('credits.id', 'credits.partner_id','partners.nombre',
                'credits.monto_credito','credits.monto_ampliacion','credits.monto_cobrado',
                'credits.numero_escritura','credits.fecha_escritura','credits.timbre_notarial',
                'credits.gasto_papeleria','credits.consulta_electronica','credits.honorario_notario',
                'credits.honorario_registro','credits.diferencia','credits.ajuste_liquidacion',
                'credits.liquidation_id','credits.cuenta','credits.credito_id',
                'credits.created_at','liquidations.created_at','liquidations.fecha_pago','advances.updated_at',
                'credits.updated_at','advances.cantidad','agencies.nombre','notaries.nombre'
            )
            ->orderBy('credits.created_at');
    }

    /**
     * @return array
     * Encabezados del reporte
     */
    public function headings(): array
    {
        return [
            '#',
            'Cif',
            'Asociado',
            'Monto credito',
            'Monto ampliacion',
            'Gastos cobrados',
            'No. Escritura',
            'Fecha Escrituracion',
            'Timbre Notarial',
            'Gasto Papeleria',
            'Consultas',
            'Honorarios',
            'Iva',
            'Registro',
            'Total Gastos',
            'Diferencia',
            'Ajuste por Liquid.',
            'Estatus',
            'Cuenta ahorro',
            'No. credito',
            'Creado',
            'Liquidacion creada',
            'Liquidacion Pagada',
            'Fecha anticipo',
            'Actualizado',
            'Anticipo',
            'comentarios',
            'Agencia',
            'Notario'
        ];
    }

}
