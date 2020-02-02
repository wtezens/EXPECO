<?php


/*************************************************************************************
 * RUTAS CONTABILIDAD                                                                *
 ************************************************************************************/
Route::prefix('contabilidad')->group(function (){
    Route::get('/panel','Contabilidad\ContabilidadController@home')
        ->name('contabilidad.home');

    //----------------------------MOSTRAR UN EXEDIENTE------------------------------//
    Route::get('/expediente/{expediente}','Contabilidad\CreditosController@show');

    //---------------------------Mostrar reporte liquidacion------------------------------//
    Route::get('/liquidacion/{numero}','Contabilidad\LiquidacionesController@generarReporteLiquidacion')
        ->where('numero','^[0-9]+$');

    //----------------------------VALIDAR SI EXISTE EL EXPEDIENTE----------------//
    Route::get('/verificar/expediente/{expediente}','Contabilidad\CreditosController@validarExpediente')
        ->where('expediente','^\d{1,10}$');

    //---------------------VALIDAR SI EXISTE EL CORRELATIVO DE ANTICIPO-------------//
    Route::get('/verificar/correlativo/{correlativo}','Contabilidad\AnticiposController@validarCorrelativo')
        ->where('correlativo','^\d{1,8}$');

    //---------------------Ingresar los datos del anticipo-------------//
    Route::post('/anticipos/{correlativo}', 'Contabilidad\AnticiposController@update')
        ->where('correlativo','^\d{0,8}$');

    //---------------------Listar los anticipos autorizados-------------//
    Route::get('/anticipos/list','Contabilidad\AnticiposController@show');

    //---------------------Listar las liquidaciones pendientes de pagar-------------//
    Route::get('/liquidar','Contabilidad\LiquidacionesController@listosParaLiquidar');

    //---------------------Listar las liquidaciones ya pagadas-------------//
    Route::get('/liquidados','Contabilidad\LiquidacionesController@YaLiquidados');

    //---------------------Efectuar el pago de una liquidación-------------//
    Route::post('/pagar/liquidacion/{correlativo}',
        'Contabilidad\LiquidacionesController@EfectuarFechaPagoLiquidacion')
        ->where('correlativo','^\d{0,8}$');

    //---------------------- Lista de notarios por agencia-----------------------//
    Route::get('/getNotaries', 'Contabilidad\ContabilidadController@Notarios');

    //---------------------- Lista de agencias-----------------------//
    Route::get('/getAgencies', 'Contabilidad\ContabilidadController@Agencias');


    //---------------------OBTENCION DE REPORTES-------------//
    Route::get('/reporte/general', 'Contabilidad\ReportesController@ReporteGeneral');

    //---------------------REPORTES ESPECIFICOS-------------//
    /**reporte por agencia y notario**/
    Route::post('/reporte/especifico', 'Contabilidad\ReportesController@ReporteEspecifico');

    /**REPORTE DE CASOS POR NOTARIO Y AGENCIA LIQUIDADOS**/
    Route::post('/reporte/casosliquidados', 'Contabilidad\ReportesController@ReporteCasosPorNotarioYAgencia');
});
