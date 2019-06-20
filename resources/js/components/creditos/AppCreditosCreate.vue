<template>
    <v-layout row wrap my-1 justify-center>
        <v-flex xs12>
            <v-alert
                    v-model="alertErrors"
                    color="error"
                    icon="warning"
                    dismissible
                    outline
            >
                <li v-for="value in errors">
                    {{ reemplazarCadena(value)}}
                </li>
            </v-alert>
            <v-card>
                <v-card-title primary-title class="center blue-grey lighten-4">
                    <div>
                        <h3 class="headline" v-if="New">DATOS DEL EXPEDIENTE</h3>
                        <h3 class="headline white--text" v-else>Actualizar Registro</h3>
                    </div>
                </v-card-title>
                <v-divider class="green"></v-divider>
                <v-card-text>
                    <v-form id="form_case_file" ref="form" v-model="valido" lazy-validation>
                        <v-layout row wrap>
                            <!--v-flex xs6 sm4 md2 lg2 xl1 px-1 order-xs1 order-sm1 order-md1 order-lg-1 py-1>
                                <v-text-field
                                        validate-on-blur
                                        autofocus
                                        ref="expediente"
                                        v-model="expediente"
                                        v-on:change="onChangeExpediente"
                                        label="No. expediente:"
                                        mask="##########"
                                        required
                                        :rules="expedienteRules"
                                >
                                </v-text-field>
                            </v-flex-->
                            <v-flex xs6 sm4 md1 lg2 xl1 px-1 order-xs2 order-sm3 order-md2 order-lg-2 py-1>
                                <v-text-field
                                        validate-on-blur
                                        ref="cif"
                                        v-model="cif"
                                        v-on:change="onChangeCif"
                                        label="Cif:"
                                        mask="######"
                                        counter="6"
                                        required
                                        :rules="cifRules"
                                >
                                </v-text-field>
                            </v-flex>
                            <v-flex xs12 sm8 md4 lg4 px-1 order-xs3 order-sm4 order-md3 order-lg3 py-1>
                                <v-text-field
                                        ref="nombre"
                                        label="Nombre asociado:"
                                        v-model="nombre_asociado"
                                        readonly
                                >
                                </v-text-field>
                            </v-flex>
                            <v-flex xs12 sm8 md5 lg4 d-flex order-xs4 order-sm2 order-md4 order-lg5 px-1 py-1>
                                <v-select
                                        validate-on-blur
                                        v-bind:items="notarios"
                                        itemText="nombre"
                                        item-value="id"
                                        label="Licenciado:"
                                        v-model="notario"
                                        :rules="requiredOption"
                                ></v-select>
                            </v-flex>
                            <v-flex order-md6 order-sm2 order-xs2 order-lg6 px-1 py-1>
                                <v-checkbox
                                        label="Nuevo"
                                        v-model="nuevo"
                                        color="red darken-4"
                                ></v-checkbox>
                            </v-flex>
                        </v-layout>
                        <v-spacer></v-spacer>
                        <v-layout row wrap>
                            <v-flex xs12 sm12 md6 lg6 xl6 px-1 pt-2>
                                <fieldset class="pl-2">
                                    <legend class="legend--case-file">Desgloce de Gastos</legend>
                                    <v-layout row wrap py-1>
                                        <v-flex xs6 sm4 md4 lg4 xl3 px-1>
                                            <v-text-field
                                                    validate-on-blur
                                                    ref="monto_prestamo"
                                                    label=" Monto"
                                                    suffix="Q. "
                                                    v-model="monto_prestamo"
                                                    :rules="montoRules"
                                                    required
                                                    reverse
                                            >
                                            </v-text-field>
                                        </v-flex>
                                        <v-flex xs6 sm4 md4 lg4 xl3 px-1>
                                            <v-text-field
                                                    validate-on-blur
                                                    ref="avaluo"
                                                    label="Avalúo"
                                                    v-model="avaluo"
                                                    :rules="defaultMontoRules"
                                                    suffix="Q."
                                                    required
                                                    reverse
                                            >
                                            </v-text-field>
                                        </v-flex>
                                        <v-flex xs6 sm4 md4 lg4 xl3 px-1>
                                            <v-text-field
                                                    validate-on-blur
                                                    ref="interes_sp"
                                                    label="Interés S/P:"
                                                    v-model="interes_sp"
                                                    :rules="defaultMontoRules"
                                                    suffix="Q."
                                                    required
                                                    reverse
                                            >
                                            </v-text-field>
                                        </v-flex>
                                        <v-flex xs6 sm4 md4 lg4 xl3 px-1>
                                            <v-text-field
                                                    validate-on-blur
                                                    ref="seguro_vida"
                                                    label="Seguro de vida:"
                                                    v-model="seguro_vida"
                                                    :rules="defaultMontoRules"
                                                    suffix="Q."
                                                    required
                                                    reverse
                                            >
                                            </v-text-field>
                                        </v-flex>
                                        <v-flex xs6 sm4 md4 lg4 xl3 px-1 pb-2>
                                            <v-text-field
                                                    validate-on-blur
                                                    ref="saldo_actual"
                                                    label="Saldo actual:"
                                                    v-model="saldo_actual"
                                                    :rules="defaultMontoRules"
                                                    suffix="Q."
                                                    required
                                                    reverse
                                            >
                                            </v-text-field>
                                        </v-flex>
                                        <v-flex xs6 sm4 md4 lg4 xl3 px-1 pb-2>
                                            <v-text-field
                                                    validate-on-blur
                                                    ref="saldo_ahorro"
                                                    label="Saldo ahorro:"
                                                    v-model="saldo_ahorro"
                                                    :rules="defaultMontoRules"
                                                    suffix="Q."
                                                    required
                                                    reverse
                                            >
                                            </v-text-field>
                                        </v-flex>
                                        <v-flex xs6 sm4 md4 lg4 xl3 px-1 pb-2>
                                            <v-text-field
                                                    validate-on-blur
                                                    ref="saldo_aportacion"
                                                    label="Saldo aportación:"
                                                    v-model="saldo_aportacion"
                                                    :rules="defaultMontoRules"
                                                    suffix="Q."
                                                    required
                                                    reverse
                                            >
                                            </v-text-field>
                                        </v-flex>
                                    </v-layout>
                                </fieldset>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6 xl6 px-1 pt-2>
                                <fieldset class="pl-2">
                                    <legend class="legend--case-file">Datos del contrato</legend>
                                    <v-layout row wrap py-1>
                                        <v-flex xs6 sm4 md4 lg4 xl3 px-1 pb-2>
                                            <v-text-field
                                                    validate-on-blur
                                                    ref="finca_extra"
                                                    label="Fincas extras:"
                                                    v-model="finca_extra"
                                                    :rules="defaultCantidadRules"
                                                    mask="##"
                                                    required
                                            >
                                            </v-text-field>
                                        </v-flex>
                                        <v-flex xs6 sm4 md4 lg4 xl3 px-1>
                                            <v-text-field
                                                    validate-on-blur
                                                    ref="escrituras"
                                                    label="No. de escrituras:"
                                                    v-model="escrituras"
                                                    :rules="defaultCantidadRules"
                                                    mask="##"
                                                    required
                                            >
                                            </v-text-field>
                                        </v-flex>
                                        <v-flex xs6 sm4 md4 lg4 xl3 px-1>
                                            <v-text-field
                                                    validate-on-blur
                                                    ref="contratos"
                                                    label="No. de contratos:"
                                                    v-model="contratos"
                                                    :rules="defaultCantidadRules"
                                                    mask="##"
                                                    required
                                            >
                                            </v-text-field>
                                        </v-flex>
                                        <v-flex xs6 sm4 md4 lg3 xl3 px-1 >
                                            <p>Garantia registrada</p>
                                            <v-radio-group v-model="Registrado" row name="registrado" :rules="requiredOption">
                                                <v-radio color="info" label="Si" value="Registrada" checked></v-radio>
                                                <v-radio color="info" label="No" value="No Registrada"></v-radio>
                                            </v-radio-group>
                                        </v-flex>
                                        <v-flex xs12 sm6 md8 lg6 xl12 px-1 >
                                            <p>Tipo desembolso</p>
                                            <v-radio-group v-model="Desembolso" row name="desembolso" :rules="requiredOption">
                                                <v-radio color="green" label="Sin Previa Ins." value="Normal"></v-radio>
                                                <v-radio color="green" label="Previa Ins." value="Previa Inscripcion"></v-radio>
                                            </v-radio-group>
                                        </v-flex>
                                    </v-layout>
                                </fieldset>
                            </v-flex>
                            <v-layout row justify-center class="pt-2">
                                <v-flex xs3>
                                    <v-btn outline block class="green--text2"
                                           :disabled="!valido"
                                           @click="CalcularDatos"
                                    >
                                        Calcular
                                        <v-icon right dark>done</v-icon>
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </v-layout>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-flex>
        <v-layout row justify-center>
            <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                <v-card>
                    <v-toolbar dark color="primary">
                        <v-btn icon dark @click.native="dialog = false">
                            <v-icon>close</v-icon>
                        </v-btn>
                        <v-toolbar-title>Datos para Escrituración</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn dark flat @click.native="submit">Guardar</v-btn>
                        </v-toolbar-items>
                    </v-toolbar>
                    <v-container fluid>
                        <v-layout row wrap>
                            <v-flex xs12 md4 class="px-3">
                                <v-subheader>Informacion del Financiamiento</v-subheader>
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-layout row wrap>
                                            <v-flex xs6><h1 class="body-2 text-xs-left">Ampliaci&oacute;n</h1></v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(monto_prestamo,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6><h1 class="body-2 text-xs-left">Saldo Actual</h1></v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(saldo_actual,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6><h1 class="body-2 text-xs-left">Sub. Total</h1></v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="SubTotal" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6><h1 class="body-2 text-xs-left">(+) Gastos</h1></v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="TotalGastos" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6><h1 class="body-2 text-xs-left">Nuevo Saldo</h1></v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="NuevoSaldo" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                </v-layout>
                            </v-flex>
                            <v-flex xs12 md4 class="green lighten-5 px-3">
                                <v-subheader>Gastos Administrativos</v-subheader>
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Escrituraci&oacute;n</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(GastosEscrituracion,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Intereses S/P</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(interes_sp,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Avaluo</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(avaluo,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Seguro de vida</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(seguro_vida,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">saldo Aport.</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(saldo_aportacion,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Saldo ahorros</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(saldo_ahorro,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Total</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(TotalGastos,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap class="mt-5">
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Total Ampliaci&oacute;n</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text text--darken-4 mb-2">Q. <span v-text="roundedNumeric(TotalAmpliacion,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                </v-layout>
                            </v-flex>
                            <v-flex xs12 md4 class="px-3">
                                <v-subheader>Gastos de Escrituracion</v-subheader>
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Monto base:</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(monto_prestamo,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Fincas adicionales</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(MontoFincaExtra,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Honorario abogado</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(MontoHonorariosNotario,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Iva 12%</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(MontoIVA,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Gastos (papeleria)</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(GastosPapeleria,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Gastos Protocolo</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(GastosProtocolo,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Timbre Notarial 2.00 0/00</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(TimbreNotarial,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Cuota Arancel</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(CuotaArancel,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Prima Arancel 1.50 0/00</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(PrimaArancel,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Consulta Electr&oacute;nica</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(ConsultaElectronica,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Referencia del registro</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(ReferenciaRGP,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Imprevistos 10%</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(Imprevistos,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Raz&oacute;n: Inscripci&oacute;n de Hip.</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(RazonRegistral,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                        <v-divider class="mx-5"></v-divider>
                                        <v-layout row wrap>
                                            <v-flex xs6>
                                                <h1 class="body-2 text-xs-left">Total</h1>
                                            </v-flex>
                                            <v-flex xs6>
                                                <p class="blue--text mb-2">Q. <span v-text="roundedNumeric(GastosEscrituracion,2)" ></span></p>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                </v-layout>
                            </v-flex>
                        </v-layout>
                    </v-container>

                    <!--v-content>
                        <v-container fluid>
                            <v-layout row wrap>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Monto base</h1>
                                    <p class="blue--text">Q. <span v-text="monto_prestamo" ></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Fincas Adicionales</h1>
                                    <p class="blue--text">Q. <span v-text="MontoFincaExtra" ></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Honorarios Abogado</h1>
                                    <p class="blue--text">Q. <span v-text="MontoHonorariosNotario"></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">IVA 12%</h1>
                                    <p class="blue--text">Q. <span v-text="MontoIVA"></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Gastos(papeleria)</h1>
                                    <p class="blue--text">Q. <span v-text="GastosPapeleria"></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Gastos Protocolo</h1>
                                    <p class="blue--text">Q. <span v-text="GastosProtocolo"></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Timbre Notarial</h1>
                                    <p class="blue--text">Q. <span v-text="TimbreNotarial"></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Cuota Arancel</h1>
                                    <p class="blue--text">Q. <span v-text="CuotaArancel"></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Prima Arancel</h1>
                                    <p class="blue--text">Q. <span v-text="PrimaArancel"></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Consulta Electónica</h1>
                                    <p class="blue--text">Q. <span v-text="ConsultaElectronica"></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Referencia Registro</h1>
                                    <p class="blue--text">Q. <span v-text="ReferenciaRGP"></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Imprevistos 10%</h1>
                                    <p class="blue--text">Q. <span v-text="Imprevistos"></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Razón Registral</h1>
                                    <p class="blue--text">Q. <span v-text="RazonRegistral"></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">N&uacute;mero de Escrituras</h1>
                                    <p class="blue--text"><span v-text="escrituras"></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">N&uacute;mero de Contratos</h1>
                                    <p class="blue--text"><span v-text="contratos"></span></p>
                                </v-flex>
                            </v-layout>

                            <v-divider></v-divider>
                            <v-list three-line subheader>
                                <v-subheader class="pink--text text--darken-3">Totales</v-subheader>
                            </v-list>
                            <v-layout row wrap>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Gastos generados</h1>
                                    <p class="blue--text">Q. <span v-text="TotalGastos" ></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Gastos escrituraci&oacute;n</h1>
                                    <p class="blue--text">Q. <span v-text="GastosEscrituracion"></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Total ampliaci&oacute;n</h1>
                                    <p class="blue--text">Q. <span v-text="TotalAmpliacion"></span></p>
                                </v-flex>
                                <v-flex xs6 sm4 md3 lg3>
                                    <h1 class="subheading">Nuevo saldo</h1>
                                    <p class="blue--text">Q. <span v-text="NuevoSaldo"></span></p>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-content-->
                </v-card>
            </v-dialog>
        </v-layout>

    </v-layout>
</template>

<script>
    export default {
        name: "AppCreditosCreate",
        props:[
            'New'
        ],
        data:()=>{
            return{
                dialog: false,
                valido:true,
                alertErrors:false,
                errors:[],

                //EXPEDIENTE
                cif:'',
                nombre_asociado:'',
                notarios: [],//array of notaries
                notario: '',//notary selected
                monto_prestamo:'',
                nuevo_saldo:'',
                avaluo:'',
                interes_sp:'',
                seguro_vida:'',
                saldo_actual:'',
                saldo_ahorro:'',
                saldo_aportacion:'',
                finca_extra:'',
                escrituras:'',
                contratos: '',
                Registrado:'',
                Desembolso:'',
                nuevo:0,
                //RULES
                expedienteRules:[
                    v => !!v || 'ingrese no. de expediente',
                    v => /^\d{3,10}$/.test(v)||'número no válido'
                ],
                cifRules: [
                    v => !!v || 'ingrese cif',
                    v => /^[1-9]\d{2,5}$/.test(v)||'Min. 3 - Max. 6 dígitos'
                ],
                montoRules: [
                    v => !!v || 'ingrese monto',
                    v => /^[1-9]\d{2,7}\.?\d{1,2}$/.test(v)||'monto inválido',
                    v => v.length <=10 || 'monto excedido',
                    v => v>499.99 || 'monto mínimo no superado'
                ],
                defaultMontoRules:[
                    v => !!v || 'ingrese monto',
                    v => /^\d{0,7}\.?\d{1,2}$/.test(v)||'monto inválido',
                    v => v.length <=10 || 'monto excedido'
                ],
                defaultCantidadRules:[
                    v => !!v || 'ingrese un dato',
                    v => /^\d{0,2}$/.test(v)||'cantidad inválida',
                    v => v.length <=2 || 'cantidad excedida'
                ],
                requiredOption:[
                    v => !!v || 'seleccione una opción',
                ]
            }
        },
        mounted(){
            axios.get('/creditos/getNotaries')
                .then(res => {
                    this.notarios =res.data;
                })
                .catch(error => {
                    swal({
                        title: error.toString()
                    })
                });
        },
        methods:{
            onChangeCif:function () {
                this.nombre_asociado='';
                if(this.ValidateCif(this.cif)){
                    axios.get('/creditos/nombreAsociado/'+this.cif)
                        .then(response => {
                            if(response.data.status === 'ok'){
                                this.nombre_asociado = response.data.nombre;
                            }else{
                                swal({
                                    title: 'El registro no existe',
                                    type: 'warning',
                                    html:
                                    '<strong>Debe registrar al asociado para continuar, </strong>' +
                                    '<b><a href="#/asociado/create">Registrar</a></b>',
                                    showCloseButton:true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }
                        })
                        .catch(error => {
                            swal({
                                title: error.toString(),
                                buttonsStyling:false,
                                confirmButtonClass:'v-btn primary'
                            })
                        });
                }else{
                    swal({
                        title:'cif incorrecto',
                        buttonsStyling:false,
                        confirmButtonClass:'v-btn primary'
                    })
                }
            },
            ValidateCif:function (cif) {
                let expreg = /^[1-9]\d{2,5}$/;

                if(expreg.test(cif)) return true
                else return false;
            },
            CalcularDatos(){
                if(this.$refs.form.validate()){
                    this.dialog=true;
                }
            },
            submit(){
                if(this.$refs.form.validate()){
                    axios.post('/creditos/expediente/store',{
                        cif: this.cif,
                        notario: this.notario,
                        montoCredito: this.monto_prestamo,
                        montoAmpliacion: this.TotalAmpliacion,
                        gastosCobrados:this.GastosEscrituracion,
                        contratos:this.contratos,
                        escrituras:this.escrituras,
                        desembolso:this.Desembolso,
                        garantia: this.Registrado,
                        nuevo:this.CreditoNuevo
                    })
                        .then(response =>{
                            this.dialog=false;
                            if(response.data.estatus==='ok'){
                                this.clear();
                                swal({
                                    type: 'success',
                                    title: 'Datos guardados correctamente.',
                                    html:
                                        '<h4 class="subheading">No. de Expediente: </h4><h3 class="headline blue--text">'
                                        +response.data.correlativo+'</h3>',
                                    showConfirmButton: true,
                                    allowOutsideClick:false,
                                    allowEscapeKey:false,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn success'
                                });

                            } else if(response.data.estatus==='duplicate key'){
                                swal({
                                    type: 'error',
                                    title: 'Datos duplicados.',
                                    text:'El registro ya existe!',
                                    showConfirmButton: true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            } else if(response.data.estatus==='a foreign key constraint fails'){
                                swal({
                                    type: 'error',
                                    title: 'Violación de Integridad.',
                                    text:'No se puede añadir o actualizar una fila secundaria.',
                                    showConfirmButton: true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }else if(response.data.estatus==='incorrect type value'){
                                swal({
                                    type: 'error',
                                    title: 'Valores incorrectos.',
                                    text:'El tipo de valor esperado es incorrecto',
                                    showConfirmButton: true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }
                        })
                        .catch(error=>{
                            this.dialog=false;
                            if(error.response.data.errors){
                                this.errors = error.response.data.errors;
                                this.alertErrors=true;
                            }else{
                                swal({
                                    title:error.toString(),
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }
                        });
                }
            },
            roundedNumeric(value, decimals){
                return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
            },
            reemplazarCadena(cadena){
                return cadena.toString();
            },
            clear () {
                this.$refs.form.reset();
                this.expediente='';
                this.cif='';
                this.notario='';
                this.monto_prestamo='';
                this.avaluo='';
                this.interes_sp='';
                this.seguro_vida='';
                this.saldo_actual='';
                this.finca_extra='';
                this.saldo_ahorro='';
                this.saldo_aportacion='';
                this.escrituras='';
                this.contratos='';
                this.garantia='';
                this.desembolso='';
                this.nuevo=0;
            }
        },
        computed:{
            /**
             * REGLAMENTO DE NOTARIOS REVISADO Y APROBADO POR EL CONSEJO EL 30 DE SEPTIEMBRE DE 2014 Art. 16.2
             */
            MontoFincaExtra: function () {
                let monto=parseInt(this.finca_extra)*50;
                return this.roundedNumeric(monto,2);
            },
            MontoHonorariosNotario: function () {
                //Parseamos la cadena a punto Flotante
                let MontoPrestamo=parseFloat(this.monto_prestamo);

                if (MontoPrestamo >499.99 && MontoPrestamo <=5000.99){
                    return 125.00;
                }else if(MontoPrestamo >=5001 && MontoPrestamo <=9999.99){
                    return 150.00;
                }else if(MontoPrestamo >=10000 && MontoPrestamo <=20000.99){
                    return 225.00;
                }else if(MontoPrestamo >=20001 && MontoPrestamo <=30000.99){
                    return 250.00;
                }else if(MontoPrestamo >=30001 && MontoPrestamo <=50000.99){
                    return 400.00;
                }else if(MontoPrestamo >=50001 && MontoPrestamo <=100000.99){
                    return 500.00;
                }else if(MontoPrestamo >=100001 && MontoPrestamo <=200000.99){
                    return 600.00;
                }else if(MontoPrestamo >=200001 && MontoPrestamo <=300000.99){
                    return 700.00;
                }else if(MontoPrestamo >=300001 && MontoPrestamo <=400000.99){
                    return 800.00;
                }else if(MontoPrestamo >=400001 && MontoPrestamo <=899999.99){
                    return 1000.00;
                }else if(MontoPrestamo >900000) {
                    return 1000.00;
                }
            },
            MontoIVA:function () {
                /**
                 * SOBRE LOS HONORARIOS
                 */
                let iva= 0.12;
                let monto=this.MontoHonorariosNotario*iva
                return this.roundedNumeric(monto,2);
            },
            GastosProtocolo:function () {
                let protocolo=95.00;
                return protocolo;
            },
            GastosPapeleria: function(){
                let papeleria =150.00;
                return papeleria;
            },
            CuotaArancel: function () {
                return 160.00;
            },
            PrimaArancel:function () {
                /**
                 * APLICA CUANDO EL MONTO DEL CRÉDITO O AMPLIACIÓN SUPERA LOS Q.10,000.00
                 * @porcentaje int = 0.0015 sobre la cantidad pasada de los 10,000.00
                 */

                let porcentaje =0.0015;
                let MontoPrestamo = parseFloat(this.monto_prestamo);
                if(MontoPrestamo<10000){
                    return 0;
                }else{
                    let monto=(MontoPrestamo - 10000) * porcentaje;
                    let entero = parseInt(monto);
                    let decimal = monto - entero;
                    if(decimal ===0.5){
                        return monto;
                    }else if(decimal>0.5){
                        return entero + 2;
                    }
                    else if(decimal==0){
                        return monto;
                    }
                    else{
                        return entero+1.5;
                    }
                }
            },
            ConsultaElectronica:function () {
                let monto = 20.00 + (20 * this.finca_extra);

                return this.roundedNumeric(monto,2);
            },
            ReferenciaRGP:function () {
                /**
                 * REGISTRO GENERAL DE LA PROPIEDAD
                 */
                return 10.00;
            },
            Imprevistos:function(){
                /**
                 * @imprevisto int = 0.1
                 * (CuotaArancel + PrimaArancel+ConsultaElectronica+ReferenciaRGP)* Imprevisto(%)
                 */
                let porcentaje = 0.1;
                let monto = (this.CuotaArancel+this.PrimaArancel+this.ConsultaElectronica+this.ReferenciaRGP)*porcentaje;

                return this.roundedNumeric(monto,2);
            },
            RazonRegistral:function () {
                return 50.00;
            },
            GastosEscrituracion:function () {
                /**
                 * MontoFincaExtra + MontoHonorariosNotario + MontoIVA + GastosPapeleria + TimbreNotarial + CuotaArancel
                 * + PrimaArancel + ConsultaElectronica + ReferenciaRGP + Imprevistos + RazonRegistral + GastosPapeleria
                 */
                let monto = this.MontoFincaExtra + this.MontoHonorariosNotario + this.MontoIVA + this.GastosPapeleria
                    + this.TimbreNotarial + this.CuotaArancel + this.PrimaArancel + this.ConsultaElectronica
                    + this.ReferenciaRGP + this.Imprevistos + this.RazonRegistral + this.GastosProtocolo;

                return this.roundedNumeric(monto,2);
            },
            SubTotal() {
                let subtot = parseFloat(this.monto_prestamo) + parseFloat(this.saldo_actual);
                return this.roundedNumeric(subtot,2);
            },
            TotalGastos:function () {
                /**
                 * SeguroSobrePrestamo + InteresSobrePrestamo + SeguroVida + SaldoActual + GastosEscrituracion
                 * + SaldoAportacion + SaldoAhorro
                 */
                let monto = parseFloat(this.avaluo) + parseFloat(this.interes_sp) + parseFloat(this.seguro_vida) +
                    parseFloat(this.saldo_aportacion) + parseFloat(this.saldo_ahorro) + this.GastosEscrituracion;

                return this.roundedNumeric(monto,2);
            },
            TotalAmpliacion:function () {
                /**
                 * Monto_prestamo + TotalGenerado
                 */
                let monto = parseFloat(this.monto_prestamo) + this.TotalGastos;

                return this.roundedNumeric(monto,2);
            },
            NuevoSaldo:function () {
                /**
                 * SaldoActual + TotalAmpliacion
                 */
                let monto = parseFloat(this.saldo_actual) + this.TotalAmpliacion;
                this.nuevo_saldo=this.roundedNumeric(monto,2);
                return this.roundedNumeric(monto,2);
            },
            TimbreNotarial:function () {
                let porcentaje=0.002;
                let monto = parseFloat(this.monto_prestamo) * porcentaje;
                let entero = parseInt(monto);
                let decimal = monto - entero;
                if(monto>300) {
                    return 300;
                }else if(entero<=299 & decimal>0){
                    return entero + 1;
                }else{
                    return entero;
                }
            },
            CreditoNuevo:function () {
                if(this.nuevo){
                    return 1;
                }

                return 0;
            }
        }
    }
</script>