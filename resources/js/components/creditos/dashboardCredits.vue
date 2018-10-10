<template>
    <div>
        <v-layout row justify-center mb-4>
            <v-flex xs12 sm10 md9 lg8 xl8 pa-1>
                <v-card>
                    <v-card-title primary-title
                                  class="card-home center elevation-4" >
                        <div>
                            <h6 class=" headline white--text">SISTEMA DE CONTROL DE EXPEDIENTES</h6>
                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>
        </v-layout>

        <v-layout row wrap class="d-flex">
            <v-flex xs12 sm6 md3 pa-1 class="d-flex">
                <v-card class="elevation-3 bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="blue--text" style="font-size:40px;">business</v-icon>
                        </div>
                        <h3 class="headline mb-0">Agencia</h3>
                    </v-card-title>
                    <div v-for="agencia in panel.agencia">
                        <v-card-text class="headline center"
                        >
                            <p class="txt-blue-card" v-text="agencia.nombre"></p>
                            <div class="pl-5 pr-5">
                                <v-progress-linear
                                        color="teal accent-4"
                                        :value="100"
                                        class="my-0"
                                        height="3"
                                ></v-progress-linear>
                            </div>
                        </v-card-text>
                    </div>

                    <v-card-actions>

                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md3 pa-1 class="d-flex">
                <v-card class="elevation-3 bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="purple--text text--darken-1" style="font-size:40px;">assignment</v-icon>
                        </div>
                        <h3 class="headline center  mb-0">Cr&eacute;ditos</h3>
                    </v-card-title>
                    <v-card-text class="headline center">
                        <p class="txt-blue-card" v-text="panel.total_creditos"></p>
                        <div class="pl-5 pr-5">
                            <v-progress-linear
                                    color="teal accent-4"
                                    :value="100"
                                    class="my-0"
                                    height="3"
                            ></v-progress-linear>
                        </div>
                    </v-card-text>
                    <v-card-actions>

                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md3 pa-1 class="d-flex">
                <v-card class="elevation-3 bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="green--text" style="font-size:40px;">trending_up</v-icon>
                        </div>
                        <h3 class="headline mb-0 center ">Liquidados</h3>
                    </v-card-title>
                    <v-card-text class="headline center">
                        <p class="txt-blue-card" v-text="panel.total_liquidados"></p>
                        <div class="pl-5 pr-5">
                            <v-progress-linear
                                    color="teal accent-4"
                                    :value="100"
                                    class="my-0"
                                    height="3"
                            ></v-progress-linear>
                        </div>
                    </v-card-text>
                    <v-card-actions>

                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md3 pa-1 class="d-flex">
                <v-card class="elevation-3 bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="red--text text--darken-2" style="font-size:40px;">whatshot</v-icon>
                        </div>
                        <h3 class="headline mb-0 center ">En tr&aacute;mite</h3>
                    </v-card-title>
                    <v-card-text class="headline center">
                        <p class="txt-blue-card" v-text="panel.pendientes"></p>
                        <div class="pl-5 pr-5">
                            <v-progress-linear
                                    color="teal accent-4"
                                    :value="100"
                                    class="my-0"
                                    height="3"
                            ></v-progress-linear>
                        </div>
                    </v-card-text>
                    <v-card-actions>

                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>

        <v-layout row wrap pt-4 v-if="expedientes.length>0">
            <v-flex xs12 md10 lg12 xl12>
                <v-toolbar flat color="green accent-1">
                    <v-toolbar-title class="hidden-xs-only">No liquidados mayores a 2 meses</v-toolbar-title>
                    <v-divider
                            class="mx-2 hidden-xs-only"
                            inset
                            vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <v-text-field
                            class="pt-1"
                            v-model="search"
                            append-icon="search"
                            label="buscar..."
                            single-line
                            solo
                    ></v-text-field>
                    <v-icon large outline color="teal darken-3" class="pl-2"
                    @click="reporte">get_app</v-icon>
                </v-toolbar>
                <v-data-table
                        primary
                        :headers="headers"
                        :items="expedientes"
                        class="elevation-1 success"
                        :pagination.sync="pagination"
                        :rows-per-page-text="RegPorPagina"
                        :search="search"
                >
                    <template slot="items" slot-scope="props">
                        <td class="text-xl-left" v-text="props.item.expediente"></td>
                        <td class="text-xl-left" v-text="props.item.monto_credito"></td>
                        <td class="text-xl-left" v-text="props.item.cif"></td>
                        <td class="text-xl-left" v-text="props.item.asociado"></td>
                        <td class="text-xl-left" v-text="props.item.notario"></td>
                        <td class="text-xl-left" v-text="formatDate(props.item.created_at)"></td>
                        <td class="justify-center layout px-0">
                            <v-icon

                                    class="mr-2 blue--text"
                                    @click="showItem(props.item.expediente)"
                            >
                                visibility
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
    </div>
</template>

<script>
    export default {
        data(){
            return{
                search: '',
                pagination: {
                    rowsPerPage: 10
                },
                RegPorPagina:'Registros por página',
                headers: [
                    {text:'Expediente.', value:'expediente'},
                    {text:'Monto', value:'monto_credito'},
                    {text: 'Cif', value:'cif'},
                    {text: 'Asociado', value:'asociado'},
                    {text: 'Notario', sortable:false},
                    {text: 'Creado', value:'created_at'},
                    {text: 'Acciones', sortable:false}
                ],
                panel:[],
                expedientes:[]
            }
        },
        created(){
            this.getDatosDashboard();
            this.getAtrasados();
        },
        methods:{
            getDatosDashboard:function () {
                axios.get('/creditos/dashboard')
                    .then(response => {
                        this.panel = response.data;
                    })
                    .catch(error => {
                        swal({
                            title: 'No se ha completado la solicitud de datos.'
                        })
                    });
            },
            getAtrasados:function () {
                axios.get('/creditos/sinliquidar')
                    .then(response => {
                        this.expedientes = response.data;
                    })
                    .catch(error => {
                        swal({
                            title: 'No se ha completado la solicitud de datos.'
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
            showItem(item){
                window.open('/creditos/creditos#/expediente/'+item);
            },
            reporte(){
                window.open('/creditos/reportesinliquidar');
            }
        }
    }
</script>