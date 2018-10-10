<template>
    <v-container fluid fill-height>
        <v-layout row align-center justify-center>
            <v-flex xs12 md10 lg8 xl6>
                <v-toolbar flat color="teal">
                    <v-toolbar-title class="white--text">Listos a Liquidar</v-toolbar-title>
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
                        <td class="text-xl-left" v-text="props.item.correlativo"></td>
                        <td class="text-xl-left" v-text="formatDate(props.item.creado)"></td>
                        <td class="text-xl-left" v-text="props.item.nombre"></td>
                        <td class="justify-center layout px-0">
                            <v-icon

                                    class="mr-2 amber--text text--darken-2"
                                    @click="showItem(props.item.id)"
                            >
                                visibility
                            </v-icon>
                            <v-icon
                                    class="mr-2 green--text text--darken-2"
                                    @click="showItem(props.item.id)"
                            >
                                done_all
                            </v-icon>
                        </td>
                    </template>
                    <template slot="pageText" slot-scope="props">
                        {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                    </template>
                    <template slot="no-data">
                        <v-alert :value="true" color="error" icon="warning">
                            No hay datos a mostrar :(
                        </v-alert>
                    </template>
                </v-data-table>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        name: "AppPagarLiquidacion",
        data:()=>{
            return {
                liquidaciones:[],
                pagination: {
                    rowsPerPage: 10
                },
                RegPorPagina:'Registros por página',
                headers: [
                    {text:'Correlativo.', value:'correlativo'},
                    {text: 'Generado', value:'creado'},
                    {text: 'Notario', value:'nombre'},
                    {text: 'Acciones', sortable:false}
                ]
            }
        },
        created(){
            this.getLiquidados();
        },
        methods:{
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
            showItem(item){
                window.open('/contabilidad/liquidacion/'+item);
            }
        }
    }
</script>