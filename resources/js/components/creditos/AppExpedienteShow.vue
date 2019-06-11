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
        <v-flex xs12 sm12  md6 lg6 px-2>
            <v-card>
                <v-layout row wrap>
                    <v-flex xs12 sm6 md6 lg6>
                        <v-card-title>
                            <div>
                                <h3 class="headline mb-0">Asociado</h3>
                                <div class="blue--text" v-text="DatosExpediente.partner_id"></div>
                                <div v-text="DatosExpediente.partner.nombre"></div>
                                <div v-if="DatosExpediente.credito_id">No. Prestamo. <span class="blue--text" v-text="DatosExpediente.credito_id"></span></div>
                                <div v-if="DatosExpediente.cuenta">Cuenta No. <span class="blue--text" v-text="DatosExpediente.cuenta"></span></div>
                                <div v-else>
                                    <v-btn flat small color="error" class="pl-0 ml-0"
                                           @click="modal_cuenta=!modal_cuenta"
                                    >
                                        <v-icon dark left>warning</v-icon>
                                        Agregar número de cuenta
                                    </v-btn>
                                </div>
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
                    </v-flex>
                    <v-flex xs12>
                        <v-card-text>
                            <div>
                                <div>Notario: <span class="pink--text text--darken-3" v-text="DatosExpediente.notary.nombre"></span></div>
                            </div>
                        </v-card-text>
                    </v-flex>
                    <v-flex>
                        <v-divider class="green"></v-divider>
                        <v-card-actions>
                            <v-btn v-if="desembolso" class="amber darken-1"
                                   @click="modal_desembolso=!modal_desembolso"
                            >
                                Agregar Desembolso
                            </v-btn>
                        </v-card-actions>
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
        <v-dialog v-model="modal_desembolso"
                  max-width="400"
        >
            <v-card>
                <v-card-title class="headline black--text">
                    Datos requeridos
                    <v-spacer></v-spacer>
                    <button @click="modal_desembolso=!modal_desembolso" class="red--text text--darken-1">X</button>
                </v-card-title>
                <v-divider class="blue-darken-2"></v-divider>
                <v-card-text>
                    <app-agregar-desembolso @agregarDesembolso="modal_desembolso=$event"
                                            @updated="recibirNuevosDatos" :expediente="DatosExpediente.id"
                                            :monto_ampliacion="DatosExpediente.monto_credito"
                                            @errors="errors=$event"
                    ></app-agregar-desembolso>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog v-model="modal_cuenta"
                  max-width="400"
        >
            <v-card>
                <v-card-title class="headline blue-grey lighten-4 black--text">
                    Dato requerido
                    <v-spacer></v-spacer>
                    <button @click="modal_cuenta=!modal_cuenta" class="red--text text--darken-1">X</button>
                </v-card-title>
                <v-card-text>
                    <app-update-cuenta-asociado @updateCuenta="modal_cuenta=$event"
                                                :expediente="DatosExpediente.id"
                                                @updated="recibirNuevosDatos"
                                                @errors="errors=$event"
                    >

                    </app-update-cuenta-asociado>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    import AppAgregarDesembolso from "./AppAgregarDesembolso";
    import AppUpdateCuentaAsociado from "./AppUpdateCuentaAsociado";
    export default {
        name: "AppExpedienteShow",
        components: {AppUpdateCuentaAsociado, AppAgregarDesembolso},
        data:()=>{
            return{
                //errors
                y:'top',
                snackbarColor:'red lighten-1',
                alertErrors:false,
                errors:[],

                dialog:false,
                idexpediente:'',
                modal_desembolso:false,
                modal_cuenta:false,
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
                axios.get('/creditos/expediente/'+idexpediente)
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
                        window.location.hash = '/envios';
                        estatus=0;
                        break;
                    }
                    case 2:{
                        swal({
                            type:'info',
                            title:'Estatus 3.',
                            text:'El notario debe ingresar el sig. estatus',
                            buttonsStyling:false,
                            confirmButtonClass:'v-btn primary'
                        })
                        estatus=0;
                        break;
                    }
                    case 3:{
                        const swalWithBootstrapButtons = swal.mixin({
                            confirmButtonClass: 'v-btn info',
                            cancelButtonClass: 'v-btn error',
                            buttonsStyling: false,

                        })

                        swalWithBootstrapButtons({
                            title: '¿Agregar estatus 4?',
                            text:'Recepción y revisión jefe de agencia',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Si',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.value) {
                                axios.post('/creditos/estatus4/expediente/'+this.DatosExpediente.id)
                                    .then(response=>{
                                        if(response.data.estatus==='fail'){
                                            swal({
                                                title:response.data.descripcion,
                                                buttonsStyling:false,
                                                confirmButtonClass:'v-btn primary'
                                            })
                                        }else if(response.data.estatus==='ok'){
                                            swal({
                                                type: 'success',
                                                title: 'Datos guardados correctamente.',
                                                showConfirmButton: true,
                                                buttonsStyling:false,
                                                confirmButtonClass:'v-btn primary'
                                            });
                                            this.getDatosExpediente(this.DatosExpediente.id);
                                        }else{
                                            swal({
                                                title:response.data.descripcion,
                                                buttonsStyling:false,
                                                confirmButtonClass:'v-btn primary'
                                            })
                                        }
                                    })
                                    .catch(error=>{
                                        if(error.response.data.errors){
                                            this.error = error.response.data.errors;
                                            this.alertErrors = true;
                                        }else{
                                            swal({
                                                title:error.toString(),
                                                buttonsStyling:false,
                                                confirmButtonClass:'v-btn primary'
                                            })
                                        }
                                    })
                            } else if (
                                // Read more about handling dismissals
                                result.dismiss === swal.DismissReason.cancel
                            ) {
                            }
                        })
                        estatus=0;
                        break;
                    }
                    case 4:{
                        swal({
                            type:'info',
                            title:'Estatus 5.',
                            text:'El sig. estatus debe ser ingresado por gerencia.',
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
                            text:'El sig. estatus debe ser ingresado por gerencia.',
                            buttonsStyling:false,
                            confirmButtonClass:'v-btn primary'
                        })
                        estatus=0;
                        break;
                    }
                    case 6:{
                        swal({
                            type:'info',
                            title:'Estatus 7.',
                            text:'El notario debe ingresar el sig. estatus',
                            buttonsStyling:false,
                            confirmButtonClass:'v-btn primary'
                        })
                        estatus=0;
                        break;
                    }
                    case 7:{
                        swal({
                            type:'info',
                            title:'Estatus 8.',
                            text:'El notario debe ingresar el sig. estatus',
                            buttonsStyling:false,
                            confirmButtonClass:'v-btn primary'
                        })
                        estatus=0;
                        break;
                    }
                    case 8:{
                        swal({
                            type:'info',
                            title:'Estatus 9.',
                            text:'El expediente esta en proceso de liquidación.',
                            buttonsStyling:false,
                            confirmButtonClass:'v-btn primary'
                        })
                        estatus=0;
                        break;
                    }
                    case 9:{
                        swal({
                            type:'error',
                            title:'Expediente Liquidado',
                            text:'No es posible realizar acciones sobre el expediente.',
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
            }
        },
        computed:{
            desembolso:{
                //calcular si ya tiene desembolso
                //por el contrario mostrar un boton de desembolso
                get:function(){
                    let status=this.DatosExpediente.statuses;
                    let valor=0;
                    status.forEach(function (elem) {
                        if(elem.descripcion==='Desembolso'){
                            valor++;
                        }
                    });

                    return valor>0?false:true;

                },
                set:function (newValue) {
                    this.desembolso=newValue;
                }
            }
        }
    }
</script>
