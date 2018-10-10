<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla Agencias
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {

            $table->increments('id');
            $table->string('nombre',75);
            $table->string('direccion',200);
            $table->timestamps();

            $table->engine='InnoDB';
            $table->charset='utf8';
            $table->collation='utf8_general_ci';
        });

    }

    /**
     * Reverse the migrations.
     * Drop table Agencias
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agencies');
    }
}
