<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiquidationsTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla Liquidaciones
     * @return void
     */
    public function up()
    {
        Schema::create('liquidations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('correlativo');
            $table->unsignedInteger('agency_id');
            $table->date('fecha_pago')->nullable();
            $table->timestamps();
            $table->foreign('agency_id')
                ->references('id')
                ->on('agencies')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->unique(['correlativo','agency_id']);
            $table->engine='InnoDB';
            $table->charset='utf8';
            $table->collation='utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     * Drop tabla liquidaciones
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('liquidations');
    }
}
