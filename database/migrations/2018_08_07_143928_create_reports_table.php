<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla Envios (notario|agencia)
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo',30)->comment('Notario/Gerencia');
            $table->timestamps();
            $table->engine='InnoDB';
            $table->charset='utf8';
            $table->collation='utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     * Drop tabla envios
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
