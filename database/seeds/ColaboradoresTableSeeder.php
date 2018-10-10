<?php

use Illuminate\Database\Seeder;

class ColaboradoresTableSeeder extends Seeder
{
    /**
     * Fifth Seeder to run
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
            ->insert(array(
                'email'=>'wilmer.tezen@ecosabarl.com',
                'agency_id'=>1,
                'role_id'=>1,
                'nombres'=>'WILMER ISAIAS',
                'apellidos'=>'TEZEN SURUY',
                'password'=>bcrypt('ecosaba123'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('users')
            ->insert(array(
                'email'=>'marco.garcia@ecosabarl.com',
                'agency_id'=>1,
                'role_id'=>1,
                'nombres'=>'MARCO DAVID',
                'apellidos'=>'GARCIA RAXON',
                'password'=>bcrypt('ecosaba123'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('users')
            ->insert(array(
                'email'=>'marina.boror@ecosabarl.com',
                'agency_id'=>1,
                'role_id'=>2,
                'nombres'=>'MARINA DEL ROSARIO',
                'apellidos'=>'BOROR LOCON',
                'password'=>bcrypt('ecosaba123'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('users')
            ->insert(array(
                'email'=>'jorge.tezen@ecosabarl.com',
                'agency_id'=>1,
                'role_id'=>4,
                'nombres'=>'JORGE ARMANDO',
                'apellidos'=>'TEZEN',
                'password'=>bcrypt('ecosaba123'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('users')
            ->insert(array(
                'email'=>'mayra.sequen@ecosabarl.com',
                'agency_id'=>1,
                'role_id'=>5,
                'nombres'=>'MAYRA ESPERANZA',
                'apellidos'=>'SEQUEN JOCOP',
                'password'=>bcrypt('ecosaba123'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('users')
            ->insert(array(
                'email'=>'oscar.rompich@ecosabarl.com',
                'agency_id'=>1,
                'role_id'=>6,
                'nombres'=>'OSCAR RUDIK',
                'apellidos'=>'ROMPICH PIRIR',
                'password'=>bcrypt('ecosaba123'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('users')
            ->insert(array(
                'email'=>'mario.chet@ecosabarl.com',
                'agency_id'=>1,
                'role_id'=>7,
                'nombres'=>'MARIO ALFONSO',
                'apellidos'=>'CHET TURUY',
                'password'=>bcrypt('ecosaba123'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));

        $this->command->info('Colaboradores inserts complete');
    }
}
