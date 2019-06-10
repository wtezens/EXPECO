<?php

use Illuminate\Database\Seeder;

class AsociadosTableSeeder extends Seeder
{
    /**
     * Sixth Seeder to run
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partners')
            ->insert(array(
                'id' => 6632,
                'nombre' => 'MARCO DAVID GARCIA RAXON',
                //'cuenta' => 100017035,
                'user_id'=>1,
                'created_at' => now(),
                'updated_at'=>now()
            ));
        DB::table('partners')
            ->insert(array(
                'id' => 13563,
                'nombre' => 'MARVIN JOEL PATZAN ITZOL',
                //'cuenta' => 100032764,
                'user_id'=>1,
                'created_at' => now(),
                'updated_at'=>now()
            ));
        DB::table('partners')
            ->insert(array(
                'id' => 17114,
                'nombre' => 'EDY ALFONSO CHAVEZ YAZ',
                //'cuenta' => 100042671,
                'user_id'=>1,
                'created_at' => now(),
                'updated_at'=>now()
            ));

        $this->command->info('Asociados inserts complete');
    }
}