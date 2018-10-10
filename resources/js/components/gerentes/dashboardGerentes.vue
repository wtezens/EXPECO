<template>
    <div>
        <v-layout row justify-center mb-4>
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
        </v-layout>
        <v-layout>
            <v-flex xs12 sm6 offset-sm3>
                <v-card>
                    <v-img
                            src="/img/50a.png"
                            height="200px"
                    ></v-img>

                    <v-card-title primary-title>
                        <div>
                            <h3 class="headline mb-0">Bienvenido</h3>
                        </div>
                    </v-card-title>

                    <v-card-actions>
                        <div>
                            <h3 class="pa-2">Acciones:</h3>
                        </div>
                        <v-btn flat color="orange"
                               :to="{path: 'anticipo/create'}"
                        >Crear nuevo anticipo</v-btn>
                        <v-btn flat color="orange"
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