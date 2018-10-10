<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotariesTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla Notarios
     * @return void
     */
    public function up()
    {
        Schema::create('notaries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id')->nullable();
            $table->string('nombre',200);
            $table->string('email')->unique();
            $table->string('telefono',50)
                ->nullable();
            $table->string('direccion',255)
                ->nullable();
            $table->string('password',255)
                ->nullable();
            $table->boolean('estado')
                ->default(0)
                ->nullable();
            $table->string('session_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->engine='InnoDB';
            $table->charset='utf8';
            $table->collation='utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     * Drop tabla notarios
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notaries');
    }
}
