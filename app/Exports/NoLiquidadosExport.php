<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NoLiquidadosExport implements FromCollection, Responsable, WithHeadings, ShouldAutoSize, WithEvents
{
   use Exportable;

    public $idAgency;

    private $fileName = 'no_liquidados.xlsx';

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $this->idAgency=session('agency_id');

        return DB::table('no_liquidados')
            ->select('expediente','monto_credito','cif','asociado','notario','created_at')
            ->where('agency_id',$this->idAgency)
            ->get();

        //TODO SE QUITO OBSERVACIONES Y DIFERENCIA DEL REPORTE
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:H1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }

    public function headings(): array {
        return [
            'Expediente',
            'Monto',
            'Cif',
            'Asociado',
            'Notario',
            'Creado',
            'Observaciones',
            'Diferencia dias'
        ];
    }



}
