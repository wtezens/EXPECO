<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')
            ->insert(array(
                'nombre'=>'technical_support',
                'descripcion'=>'Soporte Técnico',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('roles')
            ->insert(array(
                'nombre'=>'credit_secretary',
                'descripcion'=>'Secretaria Créditos',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('roles')
            ->insert(array(
                'nombre'=>'credit_assistant',
                'descripcion'=>'Asistente de créditos',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('roles')
            ->insert(array(
                'nombre'=>'assistant_accounting',
                'descripcion'=>'Asistente de contabilidad',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('roles')
            ->insert(array(
                'nombre'=>'secretary_of_management',
                'descripcion'=>'Secretaria de Gerencia',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('roles')
            ->insert(array(
                'nombre'=>'financial_manager',
                'descripcion'=>'Gerente Financiero',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('roles')
            ->insert(array(
                'nombre'=>'general_manager',
                'descripcion'=>'Gerente General',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('roles')
            ->insert(array(
                'nombre'=>'notary_for_private_documents',
                'descripcion'=>'Para documentos privados',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        DB::table('roles')
            ->insert(array(
                'nombre'=>'agency_leader',
                'descripcion'=>'Jefe de Agencia',
                'created_at'=>now(),
                'updated_at'=>now()
            ));
        $this->command->info('Puestos inserts complete');
    }
}
