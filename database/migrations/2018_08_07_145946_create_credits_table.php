<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     * Tabla Creditos
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {

            /*1*/       $table->increments('id')->comment('numero de expediente');
            /*2*/       $table->BigInteger('credito_id')->nullable()->comment('numero de credito en el core financiero');
                        $table->unsignedInteger('partner_id');
                        $table->unsignedInteger('agency_id');
                        $table->unsignedInteger('notary_id');
                        $table->unsignedInteger('user_id');
                        $table->unsignedInteger('liquidation_id')->nullable();
            /*3*/       $table->decimal('monto_credito',10,2);
            /*4*/       $table->decimal('monto_ampliacion',10,2);
            /*5*/       $table->decimal('monto_cobrado',10,2)->comment('Gastos Cobrados');
            /*6*/       $table->smallInteger('cantidad_contratos')->comment('Cant. contratos de creditos anteriores');
            /*7*/       $table->smallInteger('cantidad_escrituras')->comment('escrituras presentadas');
            /*8*/       $table->string('tipo_desembolso',20)->default('Normal');
            /*9*/       $table->string('tipo_garantia',20)->default('Registrada');
            /*10*/      $table->string('observaciones',255)->nullable();
            /*11*/      $table->unsignedInteger('numero_escritura')->nullable()->comment('numero de escritura notario');
            /*12*/      $table->date('fecha_escritura')->nullable();
            /*13*/      $table->text('rechazo')->nullable()->comment('Rechazo registral');
            /*14*/      $table->decimal('timbre_notarial',5,2)->nullable()->default(0.00);
            /*15*/      $table->decimal('gasto_papeleria',5,2)->nullable()->default(0.00);
            /*16*/      $table->decimal('consulta_electronica',5,2)->nullable()->default(0.00);
            /*17*/      $table->decimal('honorario_notario',7,2)->nullable()->default(0.00);
            /*18*/      $table->decimal('honorario_registro',7,2)->nullable()->default(0.00)->comment('honorario registral');
            /*19*/      $table->decimal('diferencia',7,2)->nullable()->default(0.00);
            /*20*/      $table->decimal('ajuste_liquidacion',7,2)->nullable()->default(0.00);
                        $table->boolean('nuevo')->nullable();
                        $table->boolean('estado')->default(1)->nullable();

            $table->timestamps();
            $table->unique('credito_id');
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('agency_id')
                ->references('id')
                ->on('agencies')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('notary_id')
                ->references('id')
                ->on('notaries')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('liquidation_id')
                ->references('id')
                ->on('liquidations')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->engine='InnoDB';
            $table->charset='utf8';
            $table->collation='utf8_general_ci';
        });
        DB::statement('ALTER TABLE credits MODIFY COLUMN credito_id BIGINT(11) ZEROFILL');
    }

    /**
     * Reverse the migrations.
     * Drop tabla creditos
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credits');
    }
}