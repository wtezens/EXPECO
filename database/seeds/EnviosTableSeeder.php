<?php

use Illuminate\Database\Seeder;

class EnviosTableSeeder extends Seeder
{
    /**
     * Ninth Seeder to run
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reports')
            ->insert(array(
                'tipo'=>'Envio Notario',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('reports')
            ->insert(array(
                'tipo'=>'Envio Gerencia',
                'created_at'=>now(),
                'updated_at'=>now()
            ));

        $this->command->info('Envios inserts complete');
    }

}
