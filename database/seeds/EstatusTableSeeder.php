<?php

use Illuminate\Database\Seeder;

class EstatusTableSeeder extends Seeder
{
    /**
     * Tenth Seeder to run
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')
            ->insert(array(
                'descripcion'=>'Asignado a notario',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('statuses')
            ->insert(array(
                'descripcion'=>'Elaboración de contrato',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('statuses')
            ->insert(array(
                'descripcion'=>'Envio a revisión y firma representante legal',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('statuses')
            ->insert(array(
                'descripcion'=>'Recepción y revisión jefe de agencia',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('statuses')
            ->insert(array(
                'descripcion'=>'Recepción y Firma del representante legal',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('statuses')
            ->insert(array(
                'descripcion'=>'Envio a inscripción',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('statuses')
            ->insert(array(
                'descripcion'=>'Inscripción del expediente',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('statuses')
            ->insert(array(
                'descripcion'=>'Listo para revisión de liquidación',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('statuses')
            ->insert(array(
                'descripcion'=>'Liquidado',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('statuses')
            ->insert(array(
                'descripcion'=>'Desembolso',
                'created_at'=>now(),
                'updated_at'=>now()
            ));

        $this->command->info('Estatus inserts complete');
    }
}
