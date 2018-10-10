<template>
    <div>
        <!--v-layout row justify-center mb-4>
            <v-flex xs12 sm10 md9 lg8 xl8>
                <v-card>
                    <v-card-title primary-title
                                  class="card-home center blue-grey--text text--lighten-5 elevation-4" >
                        <div>
                            <h6 class="headline">SISTEMA DE CONTROL DE EXPEDIENTES</h6>
                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>
        </v-layout-->
        <h4 class="display-1 blue--text2 text-xs-center mb-4">SISTEMA DE CONTROL DE EXPEDIENTES</h4>
        <v-layout justify-center align-center>
            <v-flex xs12 sm10 md8 lg6>
                <v-card class="bt-box-card-black diagradient">
                    <v-img
                            src="/img/50a.png"
                            height="180px"
                    ></v-img>

                    <v-card-title primary-title>
                        <div>
                            <h3 class="headline white--text mb-0">Módulo: Autorización Anticipos</h3>
                        </div>
                    </v-card-title>

                    <v-card-actions>
                        <div>
                            <h3 class="white--text pa-2">Acciones:</h3>
                        </div>
                        <v-btn color="white black--text"
                               :to="{path: 'anticipo/create'}"
                        >Crear nuevo anticipo</v-btn>
                        <v-btn color="white black--text"
                               :to="{path: 'anticipo/show'}"
                        >Ver mis autorizaciones</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    export default {
        name: "dashboardGerencia",

    }
</script>