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
                <v-btn class="v-btn--small"
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
                    <td class="text-xl-left blue--text2  font-weight-bold" v-text="props.item.id"></td>
                    <td class="text-xl-left blue--text2  font-weight-bold" v-text="props.item.descripcion"></td>
                    <td class="text-xl-left blue--text2  font-weight-bold" v-text="formatDate(props.item.created_at)"></td>
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
                                <div>Cuenta No. <span class="blue--text" v-text="DatosExpediente.partner.cuenta"></span></div>
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
                                <div>Notario: <span class="body-2 pink--text text--darken-3" v-text="DatosExpediente.notary.nombre"></span></div>
                                <div>Agencia: <span class="body-2 pink--text text--darken-3" v-text="DatosExpediente.agency.nombre"></span></div>
                            </div>
                        </v-card-text>
                    </v-flex>
                </v-layout>
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

                dialog:false,
                idexpediente:'',
                DatosExpediente:[{"id":''},{"partner":{"nombre":''}}],
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
                axios.get('/gerencia/creditos/'+idexpediente)
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
                        swal({
                            type:'info',
                            title:'Estatus 4.',
                            text:'la encargada de créditos debe ingresar el sig. estatus',
                            buttonsStyling:false,
                            confirmButtonClass:'v-btn primary'
                        })
                        estatus=0;
                        break;
                    }
                    case 4:{
                        const swalWithBootstrapButtons = swal.mixin({
                            confirmButtonClass: 'v-btn info',
                            cancelButtonClass: 'v-btn error',
                            buttonsStyling: false,

                        })

                        swalWithBootstrapButtons({
                            title: '¿Agregar estatus 5?',
                            text:'Recepción y firma representante legal',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Si',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.value) {
                                axios.post('/gerencia/creditos/estatus5/'+this.DatosExpediente.id)
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
                    case 5:{
                        const swalWithBootstrapButtons = swal.mixin({
                            confirmButtonClass: 'v-btn info',
                            cancelButtonClass: 'v-btn error',
                            buttonsStyling: false,

                        })

                        swalWithBootstrapButtons({
                            title: '¿Agregar estatus 6?',
                            text:'Envio a Inscripción registral',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Si',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.value) {
                                axios.post('/gerencia/creditos/estatus6/'+this.DatosExpediente.id)
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
                    default:{
                        swal({
                            type:'info',
                            title:'Créditos',
                            text:'El siguiente estatus le corresponde a la secretaria de créditos.',
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
        }
    }
</script>
