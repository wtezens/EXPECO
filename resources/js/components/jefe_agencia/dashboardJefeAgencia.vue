<template>
    <div>
        <v-layout row justify-center mb-4>
            <v-flex xs12 sm10 md9 lg8 xl8>
                <v-card>
                    <v-card-title primary-title
                                  class="card-home center white--text elevation-4" >
                        <div>
                            <h6 class="headline">SISTEMA DE CONTROL DE EXPEDIENTES</h6>
                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout>
            <v-flex xs12 sm6 offset-sm3>
                <v-card class="bt-box-card">
                    <v-img
                            src="/img/50a.png"
                            height="200px"
                    ></v-img>

                    <v-card-title primary-title>
                        <div>
                            <h3 class="headline mb-0">Módulo: Jefe de Agencia</h3>
                        </div>
                    </v-card-title>

                    <v-card-actions>
                        <div>
                            <h3 class="pa-2">Acciones:</h3>
                        </div>
                        <v-btn flat color="blue"
                               @click="modal_buscar=!modal_buscar"
                        >Buscar por expediente</v-btn>
                        <v-btn flat color="blue"
                               :to="{name:'asociado.show'}"
                        >Buscar por cif</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
        <div class="text-xs-center">
            <v-dialog
                    v-model="modal_buscar"
                    width="300"
            >
                <v-card>
                    <v-card-title
                            class="headline blue white--text"

                    >
                        Buscar expediente
                    </v-card-title>

                    <v-card-text>
                        <v-form ref="numero_expediente" v-model="valid">
                            <v-text-field
                                    v-model="numero_expediente"
                                    label="ingrese el numero"
                                    type="number"
                                    min="0"
                                    required
                                    :rules="reglasExpediente"
                                    counter="10"
                                    validate-on-blur
                            >
                            </v-text-field>
                        </v-form>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                                color="primary"
                                flat
                                @click="buscarExpediente"
                        >
                            Buscar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
    </div>
</template>

<script>
    export default {
        name: "dashboardGerencia",
        data(){
            return{
                modal_buscar:false,
                valid:false,
                numero_expediente:'',
                reglasExpediente:[
                    v => !!v || 'Ingrese un número',
                    v => v.length <=10 || 'ingrese menos de 10 digitos',
                    v => /^[0-9]+$/.test(v)||'el número debe ser válido'
                ]
            }
        },
        methods:{
            buscarExpediente(){
                if(this.ValidarExpediente()){
                    window.location.hash='/expediente/'+this.numero_expediente;
                    this.modal_buscar=false;
                    this.$refs.numero_expediente.reset();
                    this.numero_expediente='';
                }
            },
            ValidarExpediente(){
                if(this.$refs.numero_expediente.validate()){
                    return true;
                }else{
                    return false;
                }
            }

        }
    }
</script>