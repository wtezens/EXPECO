<?php

use Illuminate\Database\Seeder;

class AgenciasTableSeeder extends Seeder
{
    /**
     * First Seeder to run
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agencies')
            ->insert(array(
                'id'=>1,
                'nombre'=>'CENTRAL',
                'direccion'=>'6ta. Avenida 2-04 Zona 3, San Juan Sacatepéquez',
                'created_at'=>now(),
                'updated_at'=>now()
            )
        );
        DB::table('agencies')
            ->insert(array(
                    'id'=>2,
                    'nombre'=>'SAN PEDRO SACATEPÉQUEZ',
                    'direccion'=>'6ta. Calle 4-15 Zona 2',
                    'created_at'=>now(),
                    'updated_at'=>now()
                )
            );
        DB::table('agencies')
            ->insert(array(
                    'id'=>3,
                    'nombre'=>'SAN RAYMUNDO',
                    'direccion'=>'1ra. Avenida "A" 4-75 Zona 1',
                    'created_at'=>now(),
                    'updated_at'=>now()
                )
            );
        DB::table('agencies')
            ->insert(array(
                    'id'=>4,
                    'nombre'=>'CHIMALTENANGO',
                    'direccion'=>'4ta. Avenida 2-19 Zona 2',
                    'created_at'=>now(),
                    'updated_at'=>now()
                )
            );
        DB::table('agencies')
            ->insert(array(
                    'id'=>5,
                    'nombre'=>'SUMPANGO',
                    'direccion'=>'Edificio ECOSABA a un costado del parque central',
                    'created_at'=>now(),
                    'updated_at'=>now()
                )
            );
        DB::table('agencies')
            ->insert(array(
                    'id'=>6,
                    'nombre'=>'ANEXA SAN JUAN SACATEPÉQUEZ',
                    'direccion'=>'6ta. Avenida 8-12 zona 4 parque central',
                    'created_at'=>now(),
                    'updated_at'=>now()
                )
            );
        DB::table('agencies')
            ->insert(array(
                    'id'=>8,
                    'nombre'=>'SANTIAGO SACATEPÉQUEZ',
                    'direccion'=>'5ta. Avenida Zona 4, local 7 y 8',
                    'created_at'=>now(),
                    'updated_at'=>now()
                )
            );
        DB::table('agencies')
            ->insert(array(
                    'id'=>7,
                    'nombre'=>'SANTO DOMINGO XENACOJ',
                    'direccion'=>'1ra. calle 1-53 Zona 4',
                    'created_at'=>now(),
                    'updated_at'=>now()
                )
            );
        DB::table('agencies')
            ->insert(array(
                    'id'=>9,
                    'nombre'=>'CHUARRANCHO',
                    'direccion'=>'Frente a la Plaza San Pedro',
                    'created_at'=>now(),
                    'updated_at'=>now()
                )
            );
        DB::table('agencies')
            ->insert(array(
                    'id'=>10,
                    'nombre'=>'CIUDAD QUETZAL',
                    'direccion'=>'C.C. Plaza Quetzal, 8va. Calle bulevar Colona El Edén',
                    'created_at'=>now(),
                    'updated_at'=>now()
                )
            );
        DB::table('agencies')
            ->insert(array(
                    'id'=>11,
                    'nombre'=>'SAN ANDRÉS ITZAPA',
                    'direccion'=>'Canton Santisima Trinidad',
                    'created_at'=>now(),
                    'updated_at'=>now()
                )
            );
        DB::table('agencies')
            ->insert(array(
                    'id'=>12,
                    'nombre'=>'PACHALUM',
                    'direccion'=>'Calle Flores, Avenida las Jacarandas Zona 1',
                    'created_at'=>now(),
                    'updated_at'=>now()
                )
            );
        DB::table('agencies')
            ->insert(array(
                    'id'=>13,
                    'nombre'=>'MINI AG. SAJCAVILLA',
                    'direccion'=>'Aldea Sajcavilla, Sector 4, lote 7, local C, San Juan Sacatepéquez',
                    'created_at'=>now(),
                    'updated_at'=>now()
                )
            );
        $this->command->info('Agencias inserts complete');
    }
}
