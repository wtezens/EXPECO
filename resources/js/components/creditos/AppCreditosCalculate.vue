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
                        <h3 class="headline">INGRESE LOS DATOS CORRESPONDIENTES</h3>
                    </div>
                </v-card-title>
                <v-divider class="green"></v-divider>
                <v-card-text>
                    <v-form id="form_case_file" ref="form" v-model="valido" lazy-validation>
                        <v-layout row wrap>
                            <v-flex xs12 px-1 pt-2>
                                <fieldset class="pl-2">
                                    <legend class="legend--case-file">Desgloce de Gastos</legend>
                                    <v-layout row wrap py-1>
                                        <v-flex xs6 sm4 md4 lg3 xl3 px-1>
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
                                        <v-flex xs6 sm4 md4 lg3 xl3 px-1>
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
                                        <v-flex xs6 sm4 md4 lg3 xl3 px-1>
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
                                        <v-flex xs6 sm4 md4 lg3 xl3 px-1>
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
                                        <v-flex xs6 sm4 md4 lg3 xl3 px-1 pb-2>
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
                                        <v-flex xs6 sm4 md4 lg3 xl3 px-1 pb-2>
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
                                        <v-flex xs6 sm4 md4 lg3 xl3 px-1 pb-2>
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
                                        <v-flex xs6 sm4 md4 lg3 xl3 px-1 pb-2>
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
                                    </v-layout>
                                </fieldset>
                            </v-flex>
                            <v-layout row justify-center class="pt-2">
                                <v-flex xs3 class="mr-4">
                                    <v-btn block color="primary"
                                           :disabled="!valido"
                                           @click="CalcularDatos"
                                    >
                                        Calcular
                                    </v-btn>
                                </v-flex>
                                <v-flex xs12 sm2 class="ml-4">
                                    <v-btn block color="error"
                                           @click="clear"
                                    >
                                        Limpiar
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

                    </v-toolbar>
                    <v-content>
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
                    </v-content>
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
                monto_prestamo:'',
                nuevo_saldo:'',
                avaluo:'',
                interes_sp:'',
                seguro_vida:'',
                saldo_actual:'',
                saldo_ahorro:'',
                saldo_aportacion:'',
                finca_extra:'',

                //RULES
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
                ]
            }
        },
        mounted(){

        },
        methods:{
            CalcularDatos(){
                if(this.$refs.form.validate()){
                    this.dialog=true;
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
                this.monto_prestamo='';
                this.avaluo='';
                this.interes_sp='';
                this.seguro_vida='';
                this.saldo_actual='';
                this.finca_extra='';
                this.saldo_ahorro='';
                this.saldo_aportacion='';
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
            }
        }
    }
</script>