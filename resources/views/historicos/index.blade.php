<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="ECOSABA R. L.,">
    <meta name="author" content="Super User">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('iconfont/material-icons.css')}}" rel="stylesheet">
    <link href="{{asset('icono.png')}}" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <link href="{{asset('css/vuetify.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/app.css?version=1.0.08')}}" rel="stylesheet">
    <style type="text/css">
        .required {
            color: darkred !important;
        }
    </style>
</head>
<body>
<div id="historicos">
    <v-app id="inspire">

        <v-toolbar class="navbar_default"  clipped-left app fixed>

            <div class="navbar--title">S<span>istema de control de expedientes</span></div>
            <v-spacer></v-spacer>
            <v-btn  class="navbar_button white--text hidden-xs-only" depressed
                    @click.stop="dialog_asociado_create=!dialog_asociado_create"
            >
                <v-icon dark left>add</v-icon>Nuevo Asociado
            </v-btn>
        </v-toolbar>

        <v-dialog v-model="dialog" max-width="500px" persistent>
            <v-card>
                <v-card-title
                        class="headline grey lighten-2"
                >
                    Seleccione una agencia y un notario
                </v-card-title>
                <v-card-text>
                    <v-flex xs12>
                        <v-select
                                validate-on-blur
                                v-bind:items="{{$agencias}}"
                                item-text="nombre"
                                item-value="id"
                                label="Agencia:"
                                v-model="agencia"
                                :rules="requiredOption"
                        ></v-select>
                    </v-flex>
                    <v-flex xs12>
                        <v-select
                                validate-on-blur
                                v-bind:items="{{$notarios}}"
                                item-text="nombre"
                                item-value="id"
                                label="Notario:"
                                v-model="notario"
                                :rules="requiredOption"
                        ></v-select>
                    </v-flex>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            class="warning"
                            text
                            @click="dialog = false"
                    >
                        Aceptar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="dialog_asociado_create" max-width="500px">
            <app-asociado-create></app-asociado-create>
        </v-dialog>



        <!--@ERRORS -->
        <v-snackbar
                v-model="alertErrors"
                :timeout="9500"
                color="white"
                :top="'top'==='top'"
                multi-line
        >
            <ul>
                <li class="red--text" v-for="value in errors" v-text="reemplazarCadena(value)">
                </li>
            </ul>
            <v-btn
                    color="primary"
                    flat
                    @click="alertErrors = false"
            >
                Cerrar
            </v-btn>
        </v-snackbar>
        <!--ENDERRORS -->




        <v-content>
            <v-container>
                <v-layout row align-center justify-center>
                    <v-flex xs12 sm11 md10 lg10 xl3>
                        <v-snackbar
                                v-model="snackbar"
                                :top="'top' === 'top'"
                                :right="'right' === 'right'"
                                :timeout="timeout"
                                :color="color"
                        >
                            <span v-text="'Asociado: '+nombre_asociado"></span>
                            <v-btn
                                    color="white"
                                    flat
                                    @click="snackbar = false"
                            >
                                Cerrar
                            </v-btn>
                        </v-snackbar>

                        <v-card class="pa-2">
                            <v-card-title class="text-center justify-center py-3 diagradient">
                                <h1 class="font-weight-bold headline white--text">CARGA DE HISTORICOS</h1>
                            </v-card-title>
                            <v-form ref="form" v-model="valido" lazy-validation>
                                <v-tabs grow>
                                    <v-tab>
                                        Cr&eacute;dito
                                    </v-tab>
                                    <v-tab>
                                        Estatus
                                    </v-tab>
                                    <v-tab>
                                        Anticipos
                                    </v-tab>

                                    <v-tab-item>
                                        <v-layout row wrap>
                                            <v-flex xs12 md4 pt-4 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        prepend-icon="plus_one"
                                                        ref="credito"
                                                        v-model="credito"
                                                        label="N&uacute;mero de cr&eacute;dito"
                                                        :rules="RulesNumber"
                                                        counter="10"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 pt-4 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        prepend-icon="person"
                                                        ref="cif"
                                                        v-model="cif"
                                                        label="Cif (*)"
                                                        :rules="RulesCif"
                                                        required
                                                        v-on:change="onChangeCif"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 pt-4 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        ref="cuenta"
                                                        label="Numero de cuenta"
                                                        prepend-icon="filter_1"
                                                        v-model="cuenta"
                                                        mask="##########"
                                                        :rules="RulesCuenta"
                                                        counter="10"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs6 sm4 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        ref="monto_prestamo"
                                                        label="Monto pr&eacute;stamo (*)"
                                                        suffix="Q. "
                                                        v-model="monto_prestamo"
                                                        :rules="defaultMontoRules"
                                                        required
                                                        reverse
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs6 sm4 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        ref="monto_ampliacion"
                                                        label=" Monto ampliaci&oacute;n (*)"
                                                        suffix="Q. "
                                                        v-model="monto_ampliacion"
                                                        :rules="defaultMontoRules"
                                                        required
                                                        reverse
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs6 sm4 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        ref="gasto_cobrado"
                                                        label="Gastos cobrados (*)"
                                                        suffix="Q. "
                                                        v-model="gasto_cobrado"
                                                        :rules="defaultMontoRules"
                                                        required
                                                        reverse
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs6 sm4 md3 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        ref="contratos"
                                                        label="No. de contratos (*)"
                                                        v-model="contratos"
                                                        :rules="defaultCantidadRules"
                                                        mask="##"
                                                        required
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs6 sm4 md3 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        ref="escrituras"
                                                        label="No. de escrituras (*)"
                                                        v-model="escrituras"
                                                        :rules="defaultCantidadRules"
                                                        mask="##"
                                                        required
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm4 md2 px-2>
                                                <p>Garantia registrada (*)</p>
                                                <v-radio-group v-model="Registrado" row name="registrado" :rules="requiredOption">
                                                    <v-radio color="info" label="Si" value="Registrada" checked></v-radio>
                                                    <v-radio color="info" label="No" value="No Registrada"></v-radio>
                                                </v-radio-group>
                                            </v-flex>
                                            <v-flex xs12 sm6 md4 px-2>
                                                <p>Tipo desembolso (*)</p>
                                                <v-radio-group v-model="Desembolso" row name="desembolso" :rules="requiredOption">
                                                    <v-radio color="green" label="Sin Previa Ins." value="Normal"></v-radio>
                                                    <v-radio color="green" label="Previa Ins." value="Previa Inscripcion"></v-radio>
                                                </v-radio-group>
                                            </v-flex>
                                            <v-flex xs12 md3 px-4>
                                                <v-text-field validate-on-blur
                                                              ref="numero_de_escritura"
                                                              v-model="numero_de_escritura"
                                                              mask="#####"
                                                              label="No. de escritura"
                                                              :rules="RulesNumberEscritura"
                                                              prepend-icon="filter_1"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md3 px-4>
                                                <v-text-field validate-on-blur
                                                              ref="fecha_de_escrituracion"
                                                              v-model="fecha_de_escrituracion"
                                                              return-masked-value
                                                              mask="##/##/####"
                                                              label="Fecha escritura"
                                                              :rules="requiredOption"
                                                              prepend-icon="chrome_reader_mode"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs6 sm3 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        ref="timbre_notarial"
                                                        label="Timbre notarial"
                                                        suffix="Q. "
                                                        v-model="timbre_notarial"
                                                        :rules="defaultTimbreRules"
                                                        required
                                                        reverse
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs6 sm3 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        ref="gasto_papeleria"
                                                        label="Gasto papeleria"
                                                        suffix="Q. "
                                                        v-model="gasto_papeleria"
                                                        :rules="defaultMontoRules"
                                                        required
                                                        reverse
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        ref="consulta_electronica"
                                                        label="Consulta Elec."
                                                        suffix="Q. "
                                                        v-model="consulta_electronica"
                                                        :rules="defaultMontoRules"
                                                        required
                                                        reverse
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        ref="honorario_notario"
                                                        label="Honorario notario"
                                                        suffix="Q. "
                                                        v-model="honorario_notario"
                                                        :rules="defaultMontoRules"
                                                        required
                                                        reverse
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        ref="honorario_registro"
                                                        label="Honorario reg."
                                                        suffix="Q. "
                                                        v-model="honorario_registro"
                                                        :rules="defaultMontoRules"
                                                        required
                                                        reverse
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        ref="diferencia"
                                                        label="Diferencia"
                                                        suffix="Q. "
                                                        v-model="diferencia"
                                                        :rules="defaultMontoRules"
                                                        required
                                                        reverse
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        ref="ajuste_liquidacion"
                                                        label="Ajuste por liq."
                                                        suffix="Q. "
                                                        v-model="ajuste_liquidacion"
                                                        :rules="defaultMontoRules"
                                                        required
                                                        reverse
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field validate-on-blur
                                                              ref="fecha_creacion"
                                                              v-model="fecha_creacion"
                                                              return-masked-value
                                                              mask="##/##/####"
                                                              label="Fecha creacion"
                                                              :rules="requiredOption"
                                                              prepend-icon="chrome_reader_mode"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-tab-item>
                                    <v-tab-item>
                                        <v-layout row wrap>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field validate-on-blur
                                                              ref="estatus_1"
                                                              v-model="estatus_1"
                                                              return-masked-value
                                                              mask="##/##/####"
                                                              label="Estatus uno"

                                                              prepend-icon="chrome_reader_mode"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field validate-on-blur
                                                              ref="estatus_2"
                                                              v-model="estatus_2"
                                                              return-masked-value
                                                              mask="##/##/####"
                                                              label="Estatus dos"

                                                              prepend-icon="chrome_reader_mode"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field validate-on-blur
                                                              ref="estatus_3"
                                                              v-model="estatus_3"
                                                              return-masked-value
                                                              mask="##/##/####"
                                                              label="Estatus tres"

                                                              prepend-icon="chrome_reader_mode"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field validate-on-blur
                                                              ref="estatus_4"
                                                              v-model="estatus_4"
                                                              return-masked-value
                                                              mask="##/##/####"
                                                              label="Estatus cuatro"

                                                              prepend-icon="chrome_reader_mode"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field validate-on-blur
                                                              ref="estatus_5"
                                                              v-model="estatus_5"
                                                              return-masked-value
                                                              mask="##/##/####"
                                                              label="Estatus cinco"

                                                              prepend-icon="chrome_reader_mode"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field validate-on-blur
                                                              ref="estatus_6"
                                                              v-model="estatus_6"
                                                              return-masked-value
                                                              mask="##/##/####"
                                                              label="Estatus seis"

                                                              prepend-icon="chrome_reader_mode"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field validate-on-blur
                                                              ref="estatus_7"
                                                              v-model="estatus_7"
                                                              return-masked-value
                                                              mask="##/##/####"
                                                              label="Estatus siete"

                                                              prepend-icon="chrome_reader_mode"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field validate-on-blur
                                                              ref="estatus_8"
                                                              v-model="estatus_8"
                                                              return-masked-value
                                                              mask="##/##/####"
                                                              label="Estatus ocho"

                                                              prepend-icon="chrome_reader_mode"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field validate-on-blur
                                                              ref="estatus_9"
                                                              v-model="estatus_9"
                                                              return-masked-value
                                                              mask="##/##/####"
                                                              label="Estatus nueve"

                                                              prepend-icon="chrome_reader_mode"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field validate-on-blur
                                                              ref="estatus_10"
                                                              v-model="estatus_10"
                                                              return-masked-value
                                                              mask="##/##/####"
                                                              label="Estatus diez"

                                                              prepend-icon="chrome_reader_mode"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                        </v-layout>

                                    </v-tab-item>
                                    <v-tab-item>
                                        <v-layout row wrap>
                                            <v-flex xs12 md4 px-4>
                                                <v-text-field
                                                        validate-on-blur
                                                        ref="anticipo"
                                                        label="cantidad"
                                                        suffix="Q. "
                                                        v-model="cantidad_anticipo"
                                                        :rules="defaultMontoRules"
                                                        reverse
                                                >
                                                </v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-tab-item>
                                </v-tabs>
                                <span  class="red--text px-4">* Datos obligatorios</span>
                                <v-layout row justify-center>
                                    <v-flex md4>
                                        <v-btn block flat class="green--text2"
                                               :disabled="!valido"
                                               @click="process"
                                        >
                                            Guardar
                                            <v-icon dark right>send</v-icon>
                                        </v-btn>
                                    </v-flex>
                                </v-layout>
                            </v-form>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>

        <div>
            <p v-text="resultado"></p>
        </div>
    </v-app>
</div>

<script src="{{asset('js/sweetalert2.min.js')}}"></script>
<script src="{{asset('js/historicos.js?version=1.0.17')}}"></script>
</body>
</html>