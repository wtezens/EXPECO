<template>
    <div>
        <v-layout row justify-center mb-4>
            <v-flex xs12 sm10 md9 lg8 xl8 pa-1>
                <v-card>
                    <v-card-title primary-title
                                  class="diagradient center elevation-4" >
                        <div>
                            <h6 class="headline white--text">SISTEMA DE CONTROL DE EXPEDIENTES</h6>
                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>
        </v-layout>

        <v-layout row wrap class="d-flex">
            <v-flex xs12 sm6 md3 pa-1 class="d-flex">
                <v-card class="elevation-3 hover bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="purple--text text--darken-4" style="font-size:35px;">payment</v-icon>
                        </div>
                        <h3 class="title center  mb-0">Anticipos</h3>
                    </v-card-title>
                    <v-card-text class="headline center">
                        <p ></p>
                        <div class="pl-1 pr-1">
                            <v-progress-linear
                                    color="blue-grey lighten-4"
                                    :value="100"
                                    class="my-0"
                                    height="2"
                            ></v-progress-linear>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button green--text2"
                                   :to="{name:'anticipo.new'}"
                            >
                                <v-icon>add</v-icon>
                            </v-btn>
                            <span>Nuevo anticipo</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button green--text2"
                                   :to="{name:'anticipo.show'}"
                            >
                                <v-icon>visibility</v-icon>
                            </v-btn>
                            <span>Ver anticipos</span>
                        </v-tooltip>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md3 pa-1 class="d-flex">
                <v-card class="elevation-3 hover bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="blue--text text--darken-1" style="font-size:35px;">attach_money</v-icon>
                        </div>
                        <h3 class="title center  mb-0">Pago Liquidación</h3>
                    </v-card-title>
                    <v-card-text class="headline center">
                        <p ></p>
                        <div class="pl-1 pr-1">
                            <v-progress-linear
                                    color="blue-grey lighten-4"
                                    :value="100"
                                    class="my-0"
                                    height="2"
                            ></v-progress-linear>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button blue--text"
                                   :to="{name:'liquidar.create'}"
                            >
                                <v-icon>add</v-icon>
                            </v-btn>
                            <span>Pagar Liquidacion</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button blue--text"
                                   :to="{name:'liquidar.show'}"
                            >
                                <v-icon>visibility</v-icon>
                            </v-btn>
                            <span>Ver liquidados</span>
                        </v-tooltip>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md3 pa-1 class="d-flex">
                <v-card class="elevation-3 hover bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="red--text text--darken-1" style="font-size:35px;">assessment</v-icon>
                        </div>
                        <h3 class="title center  mb-0">Reportes</h3>
                    </v-card-title>
                    <v-card-text class="headline center">
                        <p ></p>
                        <div class="pl-1 pr-1">
                            <v-progress-linear
                                    color="blue-grey lighten-4"
                                    :value="100"
                                    class="my-0"
                                    height="2"
                            ></v-progress-linear>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button blue--text"
                                   :to="{name:'liquidar.show'}"
                            >
                                <v-icon>add</v-icon>
                            </v-btn>
                            <span>Nuevo anticipo</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button blue--text"
                                   @click="test"
                            >
                                <v-icon>visibility</v-icon>
                            </v-btn>
                            <span>Ver anticipos</span>
                        </v-tooltip>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md3 pa-1 class="d-flex">
                <v-card class="elevation-3 hover bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="green--text text--darken-1" style="font-size:35px;">done</v-icon>
                        </div>
                        <h3 class="title center  mb-0">Ajuste por Liquidación</h3>
                    </v-card-title>
                    <v-card-text class="headline center">
                        <p ></p>
                        <div class="pl-1 pr-1">
                            <v-progress-linear
                                    color="blue-grey lighten-4"
                                    :value="100"
                                    class="my-0"
                                    height="2"
                            ></v-progress-linear>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button blue--text"
                                   @click="test"
                            >
                                <v-icon>add</v-icon>
                            </v-btn>
                            <span>Nuevo anticipo</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button blue--text"
                                   @click="test"
                            >
                                <v-icon>visibility</v-icon>
                            </v-btn>
                            <span>Ver anticipos</span>
                        </v-tooltip>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    export default {
        name: "dashboardContabilidad",
        data(){
            return{

            }
        },
        created(){

        },
        methods:{
            test:function(){
              alert('hola');
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
                window.open('/colaborador/creditos#/expediente/'+item);
            },
            reporte(){
                window.open('/colaborador/reportesinliquidar');
            }
        }
    }
</script>

<style scoped>
    /*.hover{
        cursor: pointer;
    }*/
</style>