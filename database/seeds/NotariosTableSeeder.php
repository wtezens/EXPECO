<?php

use Illuminate\Database\Seeder;

class NotariosTableSeeder extends Seeder
{
    /**
     * Seventh Seeder to run
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1
        DB::table('notaries')
            ->insert(array(
                'nombre'=>'Lilian Esperanza Mencos Calderon',
                'email'=>'lilianmencos@hotmail.com',
                'telefono'=>'56360587',
                'direccion'=>'3a. Calle 1-81 Zona 1, Villanueva, Guatemala',
                'password'=>bcrypt('ecosaba8102'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        //2
        DB::table('notaries')
            ->insert(array(
                'nombre'=>'Rodolfo Israel Mencos Calderon',
                'email'=>'rodolfocuc73@gmail.com',
                'telefono'=>'31441816',
                'direccion'=>'12 calle 0-11 Zona 4, San Juan Sacatepéquez, Guatemala',
                'password'=>bcrypt('ecosaba8102'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        //3
        DB::table('notaries')
            ->insert(array(
                'nombre'=>'William Alexander Mansilla Jimenez',
                'email'=>'licmansilla@hotmail.es',
                'telefono'=>'66308946/40954766',
                'direccion'=>'3ra. Calle 3-00 zona 1 San Raymundo',
                'password'=>bcrypt('ecosaba8102'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        //4
        DB::table('notaries')
            ->insert(array(
                'nombre'=>'Vilma Leonor Ligorria Lara',
                'email'=>'ligorrialara2009@gmail.com',
                'telefono'=>'66308726 / 58262200',
                'direccion'=>'4ta. Avenida 5-20 Zona 1, San Raymundo',
                'password'=>bcrypt('ecosaba8102'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        //5
        DB::table('notaries')
            ->insert(array(
                'nombre'=>'Edson Weisman Sales Corzo',
                'email'=>'edson.corzo@gmail.com',
                'telefono'=>'66763562',
                'direccion'=>'10 calle 1-23 Zona 4, San Raymundo, Guatemala',
                'password'=>bcrypt('ecosaba8102'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        //6
        DB::table('notaries')
            ->insert(array(
                'nombre'=>'José Dolores Bor Sequén',
                'email'=>'lic_josebor@yahoo.com',
                'telefono'=>'66303221',
                'direccion'=>'11 calle 6-16 Nivel 2 Zona 1 San Juan Sacatepéquez',
                'password'=>bcrypt('ecosaba8102'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        //7
        DB::table('notaries')
            ->insert(array(
                'nombre'=>'Sonia Victoria Pirir Zet',
                'email'=>'soniapirir@gmail.com',
                'telefono'=>'66302047 / 66303046',
                'direccion'=>'7 Av. 3-08 Zona 2, San Juan Sacatepéquez',
                'password'=>bcrypt('ecosaba8102'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        //8
        DB::table('notaries')
            ->insert(array(
                'nombre'=>'Edelfo Matias Barrios Maldonado',
                'email'=>'licembm@hotmail.com',
                'telefono'=>'22517541',
                'direccion'=>'10 Av. 13-58 Zona 1 Oficina 307, Ciudad de Guatemala',
                'password'=>bcrypt('ecosaba8102'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        //9
        DB::table('notaries')
            ->insert(array(
                'nombre'=>'Rosa Lidia Castellanos Romero',
                'email'=>'crosalidia29@gmail.com',
                'telefono'=>'24781238 / 56367156',
                'direccion'=>'10 av 13-58 Zona 1 oficina 307 3er. nivel edificio Duarte',
                'password'=>bcrypt('ecosaba8102'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        //10
        DB::table('notaries')
            ->insert(array(
                'nombre'=>'Rolando Alberto Morales Garcia',
                'email'=>'mrolando63@gmail.com',
                'telefono'=>'66402761 / 54816047',
                'direccion'=>'9a. calle 6-54 Zona 1, San Juan Sacatepéquez, Guatemala',
                'password'=>bcrypt('ecosaba8102'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        //11
        DB::table('notaries')
            ->insert(array(
                'nombre'=>'Sandra Elizabeth Acan Guerrero',
                'email'=>'licacanguerrero@hotmail.com',
                'telefono'=>'56594670 / 78404732',
                'direccion'=>'02 Avenida 2-97 Zona 3, Chimaltenango',
                'password'=>bcrypt('ecosaba8102'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        //12
        DB::table('notaries')
            ->insert(array(
                'nombre'=>'Luis Armando Canel Monroy',
                'email'=>'luiscanel@yahoo.com',
                'telefono'=>'57156421',
                'direccion'=>'3 calle 4-28 zona 2 San Pedro Sacatepéquez, Guatemala',
                'password'=>bcrypt('ecosaba8102'),
                'created_at'=>now(),
                'updated_at'=>now()
            ));

        $this->command->info('Abogados inserts complete');
    }
}