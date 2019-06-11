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
            <v-toolbar flat color="diagradient">
                <v-toolbar-title class="white--text">Expediente</v-toolbar-title>
                <v-divider
                        class="mx-2"
                        inset
                        vertical
                ></v-divider>
                <h6 class="pl-1 subheading white--text" v-text="DatosExpediente.id"></h6>
                <v-spacer></v-spacer>
                <v-btn class="v-btn--small white green--text2"
                       @click.native="siguienteEstatus"> Nuevo Estatus</v-btn
                >
            </v-toolbar>
            <v-data-table
                    :headers="headers"
                    :items="DatosExpediente.statuses"
                    hide-actions
                    class="elevation-1 success"
                    primary
            >
                <template slot="items" slot-scope="props">
                    <td class="text-xl-left font-weight-medium" v-text="props.item.id"></td>
                    <td class="text-xl-left font-weight-medium" v-text="props.item.descripcion"></td>
                    <td class="text-xl-left font-weight-medium" v-text="formatDate(props.item.pivot.created_at)"></td>
                </template>
                <template slot="no-data">
                    <v-alert :value="true" color="error" icon="warning">
                        No hay datos a mostrar :(
                    </v-alert>
                </template>
            </v-data-table>
        </v-flex>
        <v-flex xs12 sm12  md6 lg6 px-2 >
            <v-card>
                <v-layout row wrap>
                    <v-flex xs12 sm6 md6 lg6>
                        <v-card-title>
                            <div>
                                <h3 class="headline mb-0">Asociado</h3>
                                <div class="blue--text" v-text="DatosExpediente.partner_id"></div>
                                <div v-text="DatosExpediente.partner.nombre"></div>
                                <div v-if="DatosExpediente.cuenta">Cuenta No. <span class="blue--text" v-text="DatosExpediente.cuenta"></span></div>
                                <div v-else class="red--text"><span class="red--text">No dispone de una cuenta.</span> Es necesario para liquidar.</div>
                            </div>
                        </v-card-title>
                    </v-flex>
                    <v-flex xs12 sm6 md6 lg6>
                        <v-card-text>
                            <div>
                                <h3 class="headline mb-0">Datos Generales</h3>
                                <div>Monto Crédito Q. <span class="blue--text" v-text="DatosExpediente.monto_credito"></span></div>
                                <div>Desembolso:
                                    <span v-if="DatosExpediente.tipo_desembolso==='Previa Inscripcion'" class="red--text" v-text="DatosExpediente.tipo_desembolso">
                                    </span>
                                    <span v-else class="blue--text" v-text="DatosExpediente.tipo_desembolso">
                                    </span>
                                </div>
                                <div>Garantía: <span class="blue--text" v-text="DatosExpediente.tipo_garantia"></span></div>
                            </div>
                        </v-card-text>
                    </v-flex>
                    <v-flex xs12 sm6 md6 lg6>
                        <v-card-text>
                            <div>
                                <h3 class="headline mb-0">Gastos</h3>
                                <div>Timbre Notarial Q. <span class="blue--text" v-text="TimbreNotarial"></span></div>
                                <div>Honorarios Q. <span class="blue--text" v-text="MontoHonorariosNotario"></span></div>
                                <div>IVA Q. <span class="blue--text" v-text="MontoIVA"></span></div>
                                <div>Hojas Protocolo Q. <span class="blue--text" v-text="GastosProtocolo"></span></div>
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
                    </v-flex>
                    <v-flex xs12>
                        <v-card-text>
                            <div>
                                <div>Agencia: <span class="pink--text text--darken-3" v-text="DatosExpediente.agency.nombre"></span></div>
                            </div>
                        </v-card-text>
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
                <v-card-actions v-else class="blue-grey lighten-5" >
                    <strong>Si corresponde:</strong>
                    <v-spacer></v-spacer>
                    <v-btn flat small color="error"
                           @click.native="modal_rechazo = !modal_rechazo">
                        <v-icon dark left>
                            warning
                        </v-icon>
                        Agregar rechazo
                    </v-btn>
                </v-card-actions>

            </v-card>
        </v-flex>
        <v-dialog v-model="modal_estatus_3"
                  max-width="400"
        >
            <v-card>
                <v-card-title class="headline black--text">
                    Datos requeridos
                    <v-spacer></v-spacer>
                    <button @click="modal_estatus_3=!modal_estatus_3" class="red--text text--darken-1">X</button>
                </v-card-title>
                <v-divider class="blue-darken-2"></v-divider>
                <v-card-text>
                    <app-estatus-tres @agregarEstatus3="modal_estatus_3=$event"
                                      @updated="recibirNuevosDatos" :expediente="DatosExpediente.id"
                                      @errors="errors=$event"
                    ></app-estatus-tres>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog v-model="modal_inscripcion"
                  max-width="400"
        >
            <v-card>
                <v-card-title class="headline black--text">
                    Datos requeridos
                    <v-spacer></v-spacer>
                    <button @click="modal_inscripcion=!modal_inscripcion" class="red--text text--darken-1">X</button>
                </v-card-title>
                <v-divider class="blue-darken-2"></v-divider>
                <v-card-text>
                    <app-incripcion-expediente :expediente="DatosExpediente.id"
                                               :monto_credito="DatosExpediente.monto_credito"
                                               :gastos_cobrados="DatosExpediente.monto_cobrado"
                                               @inscripcion="modal_inscripcion=$event"
                                               @updated="recibirNuevosDatos"
                                               @errors="errors=$event"
                    >

                    </app-incripcion-expediente>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog v-model="modal_rechazo"
                  max-width="400"
        >
            <v-card>
                <v-card-title class="headline black--text">
                    Datos requeridos
                    <v-spacer></v-spacer>
                    <button @click="modal_rechazo=!modal_rechazo" class="red--text text--darken-1">X</button>
                </v-card-title>
                <v-divider class="blue-darken-2"></v-divider>
                <v-card-text>
                    <app-agregar-rechazo @AddRechazo="modal_rechazo=$event"
                                      @updated="recibirNuevosDatos" :expediente="DatosExpediente.id"
                                      @errors="errors=$event"
                    ></app-agregar-rechazo>
                </v-card-text>
            </v-card>
        </v-dialog>
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

                dialog:false,
                idexpediente:'',
                DatosExpediente:[],
                modal_estatus_3:false,
                modal_inscripcion:false,
                modal_rechazo:false,
                headers: [
                    {text:'No.', value:'id'},
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
                        title:'Expediente inválido',
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
            /**
             * Convierte el objeto cadena en un string
             * @param cadena
             * @returns {string}
             */
            convertToString(cadena){
                return cadena.toString();
            },
            getDatosExpediente:function (idexpediente) {
                axios.get('/notario/creditos/'+idexpediente)
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
                        if(error.response.status===403){
                            swal({
                                type:'error',
                                title:'403. Forbidden',
                                text:'No tiene autorización para ver este registro.',
                                buttonsStyling:false,
                                confirmButtonClass:'v-btn primary'
                            })
                        }else if(error.response.status===404){
                            swal({
                                type:'error',
                                title:'Fallo en la operación.',
                                text:'No pudimos completar esta acción.',
                                buttonsStyling:false,
                                confirmButtonClass:'v-btn primary'
                            })
                        }else{
                            swal({
                                text: 'No pudimos obtener el registro, intente nuevamente.',
                                type: 'warning',
                                buttonsStyling:false,
                                confirmButtonClass:'v-btn primary'
                            })
                        }
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
            siguienteEstatus:function () {
                //calcular cual es el siguiente estatus
                let estatus=0;
                this.DatosExpediente.statuses.forEach(function (element) {
                    if(element.descripcion!='Desembolso'){
                        estatus++;
                    }

                })
                switch (estatus){
                    case 1:{
                        swal({
                            type:'info',
                            title:'Estatus 2.',
                            text:'La encargada de créditos debe ingresar el sig. estatus',
                            buttonsStyling:false,
                            confirmButtonClass:'v-btn primary'
                        })
                        estatus=0;
                        break;
                    }
                    case 2:{
                        this.modal_estatus_3=true;
                        estatus=0;
                        break;
                    }
                    case 3:{
                        swal({
                            type:'info',
                            title:'Estatus 4.',
                            text:'La encargada de créditos debe ingresar el sig. estatus',
                            buttonsStyling:false,
                            confirmButtonClass:'v-btn primary'
                        })
                        estatus=0;
                        break;
                    }
                    case 4:{
                        swal({
                            type:'info',
                            title:'Estatus 5.',
                            text:'La secretaria de gerencia debe ingresar el sig. estatus',
                            buttonsStyling:false,
                            confirmButtonClass:'v-btn primary'
                        })
                        estatus=0;
                        break;
                    }
                    case 5:{
                        swal({
                            type:'info',
                            title:'Estatus 6.',
                            text:'La secretaria de gerencia debe ingresar el sig. estatus',
                            buttonsStyling:false,
                            confirmButtonClass:'v-btn primary'
                        })
                        estatus=0;
                        break;
                    }
                    case 6:{
                        this.modal_inscripcion=true;
                    estatus=0;
                    break;
                    }
                    case 7:{
                        window.location.hash = '/liquidacion';
                        estatus=0;
                        break;
                    }
                    default:{
                        swal({
                            type:'info',
                            title:'En proceso de Liquidación.',
                            text:'No se puede realizar más acciones sobre el expediente.',
                            buttonsStyling:false,
                            confirmButtonClass:'v-btn primary'
                        })
                        estatus=0;
                        break;
                    }
                }
            },
            recibirNuevosDatos:function () {
                this.getDatosExpediente(this.DatosExpediente.id);
            },
            roundedNumeric(value, decimals){
                return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
            }
        },
        computed:{
            TimbreNotarial:function () {
                let porcentaje=0.002;
                let monto = parseFloat(this.DatosExpediente.monto_credito) * porcentaje;
                let entero = parseInt(monto);
                let decimal = monto - entero;
                if(monto>300) {
                    return 300;
                }else if(entero<=299 & decimal>0){
                    return entero + 1;
                }else{
                    return entero;
                }
            },MontoHonorariosNotario: function () {
                //Parseamos la cadena a punto Flotante
                let MontoPrestamo=parseFloat(this.DatosExpediente.monto_credito);

                if (MontoPrestamo >=2000 && MontoPrestamo <=5000.99){
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
            }
        }
    }
</script>
