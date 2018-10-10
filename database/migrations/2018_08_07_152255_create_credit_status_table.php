<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditStatusTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla Creditos_Estatus
     * indica los estatus que va alcanzando un expediente
     * @return void
     */
    public function up()
    {
        Schema::create('credit_status', function (Blueprint $table) {
            $table->unsignedInteger('credit_id');
            $table->unsignedInteger('status_id');
            $table->timestamps();
            $table->unique(['credit_id','status_id']);
            $table->foreign('credit_id')
                ->references('id')
                ->on('credits')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->engine='InnoDB';
            $table->charset='utf8';
            $table->collation='utf8_general_ci';
        });


    }

    /**
     * Reverse the migrations.
     * Drop tabla Creditos_Estatus
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_statuses');
    }
}
