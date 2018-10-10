<template>
    <v-layout row wrap>
        <v-snackbar
                v-model="alertErrors"
                :timeout="4500"
                :color="snackbarColor"
                :top="y==='top'"
        >
            <li v-for="value in errors" v-text="convertToString(value)">
            </li>
            <v-btn
                    color="white"
                    flat
                    @click="alertErrors = false"
            >
                Cerrar
            </v-btn>
        </v-snackbar>
        <v-flex xs12 sm12 md6 lg6 xl4>
            <v-toolbar flat color="teal">
                <v-toolbar-title class="white--text">Crédito</v-toolbar-title>
                <v-divider
                        class="mx-2"
                        inset
                        vertical
                ></v-divider>
                <h6 class="pl-1 subheading white--text" v-text="DatosExpediente.id"></h6>
                <v-spacer></v-spacer>
            </v-toolbar>
            <v-data-table
                    :headers="headers"
                    :items="DatosExpediente.statuses"
                    hide-actions
                    class="elevation-1 success"
                    primary
            >
                <template slot="items" slot-scope="props">
                    <td class="text-xl-left" v-text="props.item.id"></td>
                    <td class="text-xl-left" v-text="props.item.descripcion"></td>
                    <td class="text-xl-left" v-text="formatDate(props.item.created_at)"></td>
                </template>
                <template slot="no-data">
                    <v-alert :value="true" color="error" icon="warning">
                        No hay datos a mostrar :(
                    </v-alert>
                </template>
            </v-data-table>
        </v-flex>
        <v-flex xs12 sm12  md6 lg6 px-2>
            <v-card>
                <v-layout row wrap>
                    <v-flex xs12 sm6 md6 lg6>
                        <v-card-title>
                            <div>
                                <h3 class="headline mb-0">Asociado</h3>
                                <div class="blue--text" v-text="DatosExpediente.partner_id"></div>
                                <div v-text="DatosExpediente.partner.nombre"></div>
                                <div v-if="DatosExpediente.partner.cuenta">Cuenta No. <span class="blue--text" v-text="DatosExpediente.partner.cuenta"></span></div>
                                <div v-else class="red--text"><span class="red--text">No dispone de una cuenta.</span> Es necesario para liquidar.</div>
                            </div>
                        </v-card-title>
                    </v-flex>
                    <v-flex xs12 sm6 md6 lg6>
                        <v-card-text>
                            <div>
                                <h3 class="headline mb-0">Datos Generales</h3>
                                <div>Monto crédito Q. <span class="blue--text" v-text="DatosExpediente.monto_credito"></span></div>
                                <div>Monto ampliación Q. <span class="blue--text" v-text="DatosExpediente.monto_ampliacion"></span></div>
                                <div>Desembolso:
                                    <span v-if="DatosExpediente.tipo_desembolso==='Previa Inscripcion'" class="red--text" v-text="DatosExpediente.tipo_desembolso">
                                    </span>
                                    <span v-else class="blue--text" v-text="DatosExpediente.tipo_desembolso">
                                    </span>
                                </div>
                                <div>Garantía: <span class="blue--text" v-text="DatosExpediente.tipo_garantia"></span></div>
                            </div>
                        </v-card-text>
                    </v-flex >
                    <v-flex xs12 sm6 md6 lg6>
                        <v-card-text>
                            <div>
                                <h3 class="headline mb-0">Detalles</h3>
                                <table class="text-xs-left">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Número de Crédito:</th>
                                        <th><span class="pink--text text--darken-3" v-text="DatosExpediente.credito_id"></span></th>
                                    </tr>
                                    <tr>
                                        <th>Timbres Notariales Q. </th>
                                        <th><span class="blue--text" v-text="DatosExpediente.timbre_notarial"></span></th>
                                    </tr>
                                    <tr>
                                        <th>Gasto Papelería Q. </th>
                                        <th><span class="blue--text" v-text="DatosExpediente.gasto_papeleria"></span></th>
                                    </tr>
                                    <tr>
                                        <th>Consulta Electrónica Q. </th>
                                        <th><span class="blue--text" v-text="DatosExpediente.consulta_electronica"></span></th>
                                    </tr>
                                    <tr>
                                        <th>Honorarios Notario Q. </th>
                                        <th><span class="blue--text" v-text="DatosExpediente.honorario_notario"></span></th>
                                    </tr>
                                    <tr>
                                        <th>IVA Q. </th>
                                        <th><span class="blue--text" v-text="(DatosExpediente.honorario_notario*0.12).toFixed(2)"></span></th>
                                    </tr>
                                    <tr>
                                        <th>Honorarios Registro Q. </th>
                                        <th><span class="blue--text" v-text="DatosExpediente.honorario_registro"></span></th>
                                    </tr>
                                    <hr>
                                    <tr>
                                        <th>(Total Gastos Q.) </th>
                                        <th><span class="blue--text" v-text="(parseFloat(DatosExpediente.timbre_notarial)+parseFloat(DatosExpediente.gasto_papeleria)+parseFloat(DatosExpediente.consulta_electronica)+parseFloat(DatosExpediente.honorario_notario)+parseFloat(DatosExpediente.honorario_notario*0.12)+parseFloat(DatosExpediente.honorario_registro)).toFixed(2)"></span></th>
                                    </tr>
                                    <tr>
                                        <th>Monto cobrado Q. </th>
                                        <th><span class="blue--text" v-text="DatosExpediente.monto_cobrado"></span></th>
                                    </tr>
                                    <hr>
                                    <tr>
                                        <th>Diferencia Q. </th>
                                        <th>
                                            <span v-if="DatosExpediente.diferencia<0" class="red--text" v-text="DatosExpediente.diferencia"></span>
                                            <span v-else class="green--text" v-text="DatosExpediente.diferencia"></span>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </v-card-text>
                    </v-flex>
                    <v-flex xs12 sm6 md6 lg6>
                        <v-card-text v-if="DatosExpediente.advance">
                            <div>
                                <h3 class="headline mb-0">Anticipo</h3>
                                <div>Monto anticipado Q. <span class="blue--text" v-text="DatosExpediente.advance.cantidad"></span></div>
                            </div>
                        </v-card-text>
                        <v-btn v-if="DatosExpediente.liquidation_id"
                               @click="showLiquidation(DatosExpediente.liquidation_id)"
                               class="amber"
                        >
                            <v-icon dark left>visibility</v-icon>
                            Ver Liquidación
                        </v-btn>
                    </v-flex>
                </v-layout>
                <div v-if="DatosExpediente.rechazo">
                    <v-divider ></v-divider>
                    <v-card-title class="blue-grey lighten-5">
                        <v-icon outline color="error">note</v-icon>
                        <h3 class="subheading pl-2"><strong>Rechazo</strong></h3>
                    </v-card-title>
                    <v-alert
                            :value="true"
                            color="red lighten-1"
                            icon="warning"

                            v-text="DatosExpediente.rechazo"
                    >
                    </v-alert>
                </div>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "AppExpedienteShow",

        data:()=>{
            return{
                //errors
                y:'top',
                snackbarColor:'red lighten-1',
                alertErrors:false,
                errors:[],

                DatosExpediente:[],
                headers: [
                    {text:'No.',value:'id'},
                    {text: 'Estatus', sortable: false},
                    { text: 'Fecha', sortable:false}
                ]
            }
        },
        watch:{
            '$route' (to,from){
                if(/^[1-9]\d{0,9}$/.test(this.$route.params.idexpediente)){
                    this.getDatosExpediente(this.$route.params.idexpediente);
                }else{
                    swal({
                        title:'expediente inválido',
                        buttonsStyling:false,
                        confirmButtonClass:'v-btn primary'
                    })
                }
            },
            errors:function () {
                this.alertErrors=true;
            }
        },
        created(){
            if(/^[1-9]\d{0,9}$/.test(this.$route.params.idexpediente)){
                this.getDatosExpediente(this.$route.params.idexpediente);
            }else{
                swal({
                    title:'Expediente inválido',
                    buttonsStyling:false,
                    confirmButtonClass:'v-btn primary'
                })
            }
        },
        methods:{
            roundedNumeric(value, decimals){
                return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
            },

            /**
             * Convierte el objeto cadena en un string
             * @param cadena
             * @returns {string}
             */
            convertToString(cadena){
                return cadena.toString();
            },
            getDatosExpediente:function (idexpediente) {
                axios.get('/contabilidad/expediente/'+idexpediente)
                    .then(response => {
                        if(response.data[0]){
                            this.DatosExpediente = response.data[0];
                        }else{
                            swal({
                                title: 'El registro no existe',
                                type: 'error',
                                buttonsStyling:false,
                                confirmButtonClass:'v-btn primary'
                            })
                        }
                    })
                    .catch(error=>{
                        swal({
                            text: 'No pudimos obtener el registro, intente nuevamente.',
                            type: 'warning',
                            buttonsStyling:false,
                            confirmButtonClass:'v-btn primary'
                        })
                    });
            },
            formatDate:function (date) {
                if(date == null || date == undefined){
                    return '-';
                }else{
                    let only_date=date.split(' ');
                    let fecha = only_date[0].split('-');

                    let monthNames = [
                        "Ene.", "Feb.", "Mar.",
                        "Abr.", "May.", "Jun.", "Jul.",
                        "Ago.", "Sep.", "Oct.",
                        "Nov.", "Dic."
                    ];

                    let day = fecha[2];
                    let monthIndex = fecha[1]-1;
                    let year = fecha[0];

                    return day + ' ' + monthNames[parseInt(monthIndex)] + ' ' + year;
                }
            },
            recibirNuevosDatos:function () {
                this.getDatosExpediente(this.DatosExpediente.id);
            },
            showLiquidation: function (item) {
                window.open('/contabilidad/liquidacion/'+item);
            }
        }
    }
</script>
