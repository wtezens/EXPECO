<?php

Route::get('/', function (){ return view('index'); });
Route::get('/colaborador', function (){ return redirect('/colaborador/login'); });
Route::get('/notario', function (){ return redirect('/notario/login'); });

/*************************************************************************************
 * RUTAS  DEPARTAMENTO DE CREDITOS                                                   *
 ************************************************************************************/
Route::prefix('creditos')->group(function (){

    Route::get('/panel','Creditos\CreditosController@index')->name('creditos.panel');

    //----------------------------DATOS DEL DASHBOARD----------------------------//
    Route::get('/dashboard','Creditos\CreditosController@DatosDashboard')
        ->name('datos.dashboard');

    //----------------------------- NO LIQUIDADOS------------------------------//
    Route::get('/sinliquidar','Creditos\CreditosController@NoLiquidados')
        ->name('sinliquidar');
    Route::get('/reportesinliquidar','Creditos\ExportsController@export')
        ->name('reportesinliquidar');

    //----------------------------RUTAS ASOCIADOS--------------------------------//
    Route::resource('asociados','Creditos\AsociadosController');

    //--------------------Lista de creditos de un asociado-----------------------//
    Route::get('/listado/asociado/{cif}','Creditos\AsociadosController@listOfCredits')
        ->where('cif','^[1-9][0-9]{2,5}$');

    //---------------------VALIDAR SI EXISTE EL ASOCIADO-------------------------//
    Route::get('/nombreAsociado/{cif}','Creditos\AsociadosController@nombreAsociado')
        ->where('cif','^[1-9][0-9]{2,5}$');


    //----------------------------RUTAS CREDITOS---------------------------------//
    Route::post('/expediente/store','Creditos\CreditosController@store')->name('creditos.store');
    Route::get('/expediente/{expediente}','Creditos\CreditosController@show')->name('creditos.show')
        ->where('idexpediente','^\d+$');

    Route::post('/expediente/{expediente}/cuenta','Creditos\CreditosController@updateCuenta')->name('creditos.cuenta.store')
        ->where('idexpediente','^\d+$');

    //--------------------------- AGREGAR ESTATUS 4------------------------------//
    Route::post('/estatus4/expediente/{idexpediente}','Creditos\CreditosController@estatusCuatro')
        ->where('idexpediente','^\d+$');

    //Route::resource('creditos','Creditos\CreditosController');

    //---------------------- Lista de notarios por agencia-----------------------//
    Route::get('/getNotaries', 'Creditos\NotariosController@Notarios');

    //--------------------------- AGREGAR DESEMBOLSO-----------------------------//
    Route::post('/desembolso/expediente/{idexpediente}','Creditos\CreditosController@desembolso')
        ->where('idexpediente','^\d+$');

    //------------------------ RUTAS ENVIOS Y REPORTES--------------------------//
    Route::get('/envio/{notario}','Creditos\EnviosController@envioNotario')
        ->where('notario','^[1-9][0-9]{0,5}$');
    Route::post('/envio/{notario}','Creditos\EnviosController@generarEnvio')
        ->where('notario','^[1-9][0-9]{0,5}$');
    Route::get('/reporte/{correlativo}','Creditos\EnviosController@generarReporte')
        ->where('correlativo','^[0-9]+$');
});


require_once ('Core/accounting.php');

/*************************************************************************************
 * RUTAS SECRETARIA GERENCIA                                                         *
 ************************************************************************************/
Route::prefix('gerencia')->group(function (){
    Route::get('/panel','Gerencia\GerenciaController@index')->name('dashboard.gerencia');

    Route::get('/creditos/{expediente}','Gerencia\GerenciaController@show')->where('expediente','^\d+$');

    //--------------------------- AGREGAR ESTATUS 5------------------------------//
    Route::post('/creditos/estatus5/{idexpediente}','Gerencia\GerenciaController@estatusCinco')
        ->where('idexpediente','^\d+$');

    //--------------------------- AGREGAR ESTATUS 6------------------------------//
    Route::post('/creditos/estatus6/{idexpediente}','Gerencia\GerenciaController@estatusSeis')
        ->where('idexpediente','^\d+$');
});

/*************************************************************************************
 * RUTAS GERENTES (GENERAL|FINANCIERO)                                               *
 ************************************************************************************/
Route::prefix('gerentes')->group(function (){
    Route::get('/panel','Gerentes\GerentesController@home')->name('gerentes.home');

    Route::post('/anticipos/store','Gerentes\GerentesController@store');

    Route::get('/anticipos/show','Gerentes\GerentesController@show');
});

/*************************************************************************************
 * RUTAS JEFE DE AGENCIA                                                             *
 ************************************************************************************/
Route::prefix('agencias')->group(function (){
    Route::get('/jefes','JefeAgencia\JefeAgenciaController@index')->name('dashboard.jefes');

    Route::get('/creditos/{expediente}','JefeAgencia\JefeAgenciaController@show')->where('expediente','^\d+$');

    //--------------------Lista de creditos de un asociado-----------------------//
    Route::get('/asociado/{cif}','JefeAgencia\JefeAgenciaController@listOfCredits')
        ->where('cif','^[1-9][0-9]{2,5}$');
});

Route::prefix('colaborador')->group(function (){
    /*************************************************************************************
     * RUTAS LOGIN                                                                       *
     ************************************************************************************/
        Route::get('/login','AuthColaborador\LoginController@showLoginForm')
            ->name('colaborador.login');
        Route::post('/login', 'AuthColaborador\LoginController@login')
            ->name('colaborador.login.submit');
        Route::get('/logout','AuthColaborador\LoginController@logout')
            ->name('colaborador.logout');

    /*************************************************************************************
     * RUTAS PASSWORD                                                                    *
     ************************************************************************************/
        Route::post('/changepassword','AuthColaborador\ChangePasswordController@changePassword')
            ->name('colaborador.change.password');
});

/*************************************************************************************
 * RUTAS SOPORTE                                                                    *
 ************************************************************************************/
Route::prefix('soporte')->group(function (){

    Route::get ('/panel','Soporte\SoporteController@home')->name('soporte.home');

//---------------------------RUTAS ROLES Y AGENCIAS ------------------------------//
    Route::get ( '/list/roles',             'Soporte\UsuariosController@getRoles')->name('listado_roles');
    Route::get ( '/list/agencias',          'Soporte\UsuariosController@getAgencias')->name('listado_agencias');

//---------------------------RUTAS PARA VALIDAR EMAIL ------------------------------//
    Route::post( '/validar/email',          'Soporte\UsuariosController@validateEmail')->name('validar_email');

//---------------------------RUTAS PARA NUEVO USUARIO------------------------------//
    Route::get ( '/usuarios',               'Soporte\UsuariosController@getUsers')->name('usuarios');
    Route::post( '/usuario/store',          'Soporte\UsuariosController@storeUser')->name('nuevo_usuario');

    /*----------------------- RUTAS PARA VER LOS USUARIOS --------------------------*/
    Route::post('/user/show',               'Soporte\UsuariosController@show');
    Route::post('user/{user}/estado',       'Soporte\UsuariosController@updateUserState')
        ->where( 'user','[0-9]+')->name('cambiar_estado');

/*------------------------------RUTAS NOTARIOS-----------------------------------*/
    Route::post( '/validar/emailNotary',    'Soporte\UsuariosController@validateEmailNotary')->name('validar_email');
    Route::get ( '/notarios',               'Soporte\UsuariosController@getNotarios')->name('notarios');
    Route::post( '/notarios/store',         'Soporte\UsuariosController@storeNotary')->name('nuevo_usuario');
    Route::post( '/notario/show',           'Soporte\UsuariosController@showNotaries');
    Route::post( '/notario/{notary}/estado','Soporte\UsuariosController@updateNotaryState')
    ->where('notary','[0-9]+')->name('cambiar_estado');

});
Route::prefix('notario')->group(function (){
    /**************************************************************************
     * LOGIN NOTARIO                                                          *
     **************************************************************************/
    Route::get('/login','Auth\LoginController@showLoginForm')
        ->name('login');
    Route::post('login','Auth\LoginController@login')
        ->name('notario.login.submit');
    Route::get('logout','Auth\LoginController@logout')
        ->name('notario.logout');

    /*************************************************************************************
     * RUTAS PASSWORD                                                                    *
     ************************************************************************************/
    Route::post('/changepasswordnotario','Auth\ChangePasswordController@changePassword')
        ->name('change.password');

    /*************************************************************************************
     * PANEL PRINCIPAL                                                                   *
     ************************************************************************************/
    Route::get('/panel','Notarios\DashboardController@homepage');

    //----------------------------MOSTRAR UN EXEDIENTE------------------------------//
    Route::get('/creditos/{expediente}','Notarios\CreditosController@show');

    //-----------------------------DATOS DEL DASHBOARD----------------------------------//
    Route::get('/dashboard','Notarios\DashboardController@DatosPanel')
        ->name('datos.dashboard.notario');

    //------------------------------ NO LIQUIDADOS-------------------------------------//
    Route::get('/sinliquidar','Notarios\CreditosController@NoLiquidados')
        ->name('sinliquidar');
    //Route::get('/reportesinliquidar','Creditos\ExportsController@export')
        //->name('reportesinliquidar');

    //---------------------------RUTAS PARA LIQUIDACION------------------------------//
    Route::get('/creditos/liquidacion/{agencia}','Notarios\LiquidacionesController@showLiquidaciones')->where('agencia','^[1-9][0-9]{0,5}$');
    Route::post('/creditos/liquidacion','Notarios\LiquidacionesController@generarLiquidacion');

    //---------------------------Mostrar reporte liquidacion------------------------------//
    Route::get('/liquidacion/{numero}','Notarios\LiquidacionesController@generarReporteLiquidacion')
        ->where('numero','^[0-9]+$');

                                //Descargar una liquidación//
    Route::get('/liquidacion/download/{numero}','Notarios\LiquidacionesController@generarReporteLiquidacion')
        ->name('descarga.liquidacion')
        ->where('numero','^[0-9]+$');

    //---------------------- Lista de agencias por notario-------------------------//
    Route::get('/getAgencias','Notarios\AgenciasController@Agencias');

    //------------------------ Rutas para generar envios--------------------------//
    Route::get('/revision/{agencia}','Notarios\EnviosController@envioRevision')->where('agencia','^[1-9][0-9]{0,5}$');
    Route::post('/revision/{agencia}','Notarios\EnviosController@generarEnvioRevision');
    Route::get('/reporte/{correlativo}','Notarios\EnviosController@generarReporteRevision')
        ->where('correlativo','^[0-9]+$');

    //-------------------------------- ESTATUS 3---------------------------------//
    Route::post('/creditos/estatus3/{expediente}','Notarios\CreditosController@agregarEstatusTres')
        ->where('expediente','^[0-9]+$');

    //--------------------------ESTATUS INSCRIPCION REGISTRAL--------------------//
    Route::post('/creditos/inscripcion/{expediente}','Notarios\CreditosController@inscripcionExpediente')
        ->where('expediente','^[0-9]+$');

    //-------------------------------LISTAR NO LIQUIDADOS-----------------------//
    Route::get('/liquidaciones','Notarios\LiquidacionesController@ListadoLiquidaciones');

    //
    Route::get('/nota/expediente/{expediente}','Notarios\EnviosController@NotaExpediente')
    ->where('expediente','^[0-9]+$');
});


Route::prefix('forms')->group( function () {
    Route::get('history','Historicos\HistoricosController@index');
    Route::post('store','Historicos\HistoricosController@store');
    Route::get('partner/{id}','Historicos\HistoricosController@verifyCif');
    Route::post('asociado/store','Historicos\HistoricosController@partnerStore');
    Route::get('/expediente/{expediente}','Historicos\HistoricosController@show')
        ->where('idexpediente','^\d+$');
});
