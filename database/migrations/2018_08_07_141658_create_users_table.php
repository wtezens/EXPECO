<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla Usuarios/colaboradores
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('agency_id');
            $table->string('nombres',200);
            $table->string('apellidos',200);
            $table->string('password',255)
                ->nullable();
            $table->boolean('estado')
                ->default(0)
                ->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->string('session_id')->nullable();
            $table->foreign('agency_id')
                ->references('id')
                ->on('agencies')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->rememberToken();
            $table->timestamps();
            $table->engine='InnoDB';
            $table->charset='utf8';
            $table->collation='utf8_general_ci';

        });
    }

    /**
     * Reverse the migrations.
     * Drop table usuarios/colaboradores
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
