<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditReportTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla Creditos_Reportes
     * tabla intermedia indica que creditos estan en los reportes
     * @return void
     */
    public function up()
    {
        Schema::create('credit_report', function (Blueprint $table) {
            $table->string('correlativo',30);
            $table->unsignedInteger('report_id');
            $table->unsignedInteger('credit_id');
            $table->timestamps();
            $table->foreign('report_id')
                ->references('id')
                ->on('reports')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('credit_id')
                ->references('id')
                ->on('credits')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->engine='InnoDB';
            $table->charset='utf8';
            $table->collation='utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     * Drop tabla Creditos_Reportes
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_reports');
    }
}
