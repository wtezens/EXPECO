<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla Anticipos
     * @return void
     */
    public function up()
    {
        Schema::create('advances', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('credit_id')->nullable();
            $table->string('clave',255);
            $table->decimal('cantidad',7,2)->nullable();
            $table->timestamps();
            $table->unique('credit_id');
            $table->foreign('credit_id')
                ->references('id')
                ->on('credits')
                ->onUpdate('cascade')
                ->onDelete('restrict');
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
     * Drop tabla Anticipos
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advances');
    }
}
