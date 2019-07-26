<template>
    <v-container fluid fill-height>
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
        <v-layout row align-center justify-center>
            <v-flex xs12 sm12 md10 lg10 xl6>
                <v-toolbar flat class="diagradient">
                    <v-toolbar-title class="white--text">LISTOS A LIQUIDAR</v-toolbar-title>
                    <v-divider
                            class="mx-2"
                            inset
                            vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-data-table
                        primary
                        :headers="headers"
                        :items="liquidaciones"
                        class="elevation-1 success"
                        :pagination.sync="pagination"
                        :rows-per-page-text="RegPorPagina"
                >
                    <template slot="items" slot-scope="props">
                        <td class="text-xl-left font-weight-medium" v-text="props.item.id"></td>
                        <td class="text-xl-left font-weight-medium" v-text="props.item.correlativo"></td>
                        <td class="text-xl-left font-weight-medium" v-text="formatDate(props.item.creado)"></td>
                        <td class="text-xl-left font-weight-medium" v-text="props.item.nombre"></td>
                        <td class="text-xl-left font-weight-medium" v-text="roundedNumeric(props.item.monto,2)"></td>
                        <td class="justify-center layout px-0">
                            <v-icon

                                    class="mr-2 blue--text2"
                                    @click="showItem(props.item.id)"
                            >
                                visibility
                            </v-icon>
                            <v-btn flat outline small class="green--text2" @click="SubmitLiquidar(props.item.id)"
                            >Liquidar</v-btn>
                        </td>
                    </template>
                    <template slot="pageText" slot-scope="props">
                        {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                    </template>
                    <template slot="no-data">
                        <v-alert outline dismissible :value="true" color="error" icon="warning">
                            No hay datos a mostrar :(
                        </v-alert>
                    </template>
                </v-data-table>
            </v-flex>
        </v-layout>
        <v-dialog
                v-model="dialog_liquidar"
                width="320"
        >
            <v-card>
                <v-card-title
                        class="headline black--text"

                >
                    Registrar pago
                </v-card-title>
                <v-divider class="blue-darken-2"></v-divider>
                <v-card-text>
                    <app-realizar-pago-liquidacion
                            :CorrelativoLiquidacion="CorrelativoLiquidacion"
                            @agregarPago="dialog_liquidar=$event"
                            @updated="recibirNuevosDatos"
                            @errors="errors=$event"
                    ></app-realizar-pago-liquidacion>
                </v-card-text>

                <v-divider></v-divider>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
    export default {
        name: "AppPagarLiquidacion",
        data:()=>{
            return {
                //errors
                y:'top',
                snackbarColor:'red lighten-1',
                alertErrors:false,
                errors:[],

                dialog_liquidar:false,
                CorrelativoLiquidacion:0,
                liquidaciones:[],
                pagination: {
                    rowsPerPage: 10
                },
                RegPorPagina:'Registros por página',
                headers: [
                    {text:'No.', value:'id'},
                    {text:'Correlativo.', value:'correlativo'},
                    {text: 'Generado', value:'creado'},
                    {text: 'Notario', value:'nombre'},
                    {text: 'Monto en Q.', value:'monto'},
                    {text: 'Acciones', sortable:false}
                ]
            }
        },
        watch:{
            errors:function () {
                this.alertErrors=true;
            }
        },
        created(){
            this.getLiquidados();
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
            recibirNuevosDatos:function () {
                //this.getLiquidados();

            },
            getLiquidados:function () {
                axios.get('/contabilidad/liquidar')
                    .then(response => {
                        if(response.data){
                            this.liquidaciones = response.data;
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
            roundedNumeric(value, decimals){
                //return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
                return parseFloat(value).toFixed(decimals);
            }
            ,
            showItem(item){
                window.open('/contabilidad/liquidacion/'+item);
            },
            SubmitLiquidar(item){
                this.dialog_liquidar=true;
                this.CorrelativoLiquidacion=item;
            }
        }
    }
</script>