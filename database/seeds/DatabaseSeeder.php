<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AgenciasTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ColaboradoresTableSeeder::class);
        $this->call(NotariosTableSeeder::class);
        $this->call(AsociadosTableSeeder::class);
        $this->call(EnviosTableSeeder::class);
        $this->call(EstatusTableSeeder::class);
    }
}
