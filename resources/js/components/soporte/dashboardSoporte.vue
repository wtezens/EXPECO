<template>
    <div>
        <v-layout row justify-center mb-4>
            <v-flex xs12 sm10 md9 lg8 xl8 pa-1>
                <v-card>
                    <v-card-title primary-title
                                  class="diagradient center elevation-4" >
                        <div>
                            <h6 class="headline white--text">SOPORTE TÉCNICO</h6>
                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>
        </v-layout>

        <v-layout row wrap class="d-flex">
            <v-flex xs12 sm6 md4 pa-1 class="d-flex">
                <v-card class="elevation-3 hover bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="purple--text text--darken-4" style="font-size:35px;">account_box</v-icon>
                        </div>
                        <h3 class="title center  mb-0">Usuarios</h3>
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
                                   :to="{name:'usuario.new'}"
                            >
                                <v-icon>add</v-icon>
                            </v-btn>
                            <span>Nuevo usuario</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button blue--text"
                                   :to="{name:'usuario.show'}"
                            >
                                <v-icon>search</v-icon>
                            </v-btn>
                            <span>Ver usuarios</span>
                        </v-tooltip>
                    </v-card-actions>
                </v-card>
            </v-flex>

            <v-flex xs12 sm6 md4 pa-1 class="d-flex">
                <v-card class="elevation-3 hover bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="blue--text text--darken-1" style="font-size:35px;">account_box</v-icon>
                        </div>
                        <h3 class="title center  mb-0">Notarios</h3>
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
                                   :to="{name:'notario.new'}"
                            >
                                <v-icon>add</v-icon>
                            </v-btn>
                            <span>Nuevo notario</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button blue--text"
                                   :to="{name:'notario.show'}"
                            >
                                <v-icon>search</v-icon>
                            </v-btn>
                            <span>Ver notarios</span>
                        </v-tooltip>
                    </v-card-actions>
                </v-card>
            </v-flex>


            <v-flex xs12 sm6 md4 pa-1 class="d-flex">
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
                                   :to="{name:'reporte.new'}"
                            >
                                <v-icon>add</v-icon>
                            </v-btn>
                            <span>Nuevo reporte</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button blue--text"
                                   :to="{name:'reporte.show'}"
                            >
                                <v-icon>search</v-icon>
                            </v-btn>
                            <span>Ver Reportes</span>
                        </v-tooltip>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    export default {
        name: "dashboardSoporte",
        data(){
            return{

            }
        }, created (){

        },
        methods:{
            test:function () {
                alert('mensaje');
            },

        }
    }
</script>
