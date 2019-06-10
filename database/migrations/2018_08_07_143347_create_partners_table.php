<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla Asociados
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->unsignedInteger('id')->comment('CIF');
            $table->string('nombre',200);
            $table->primary('id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->engine='InnoDB';
            $table->charset='utf8';
            $table->collation='utf8_general_ci';
        });

    }

    /**
     * Reverse the migrations.
     * Drop tabla asociados
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partners');
    }
}
