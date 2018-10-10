<template>
    <div>
        <!--v-layout row justify-center mb-4>
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
        </v-layout-->
        <h4 class="display-1 blue--text2 text-xs-center mb-4">SISTEMA DE CONTROL DE EXPEDIENTES</h4>
        <v-layout justify-center align-center>
            <v-flex xs12 sm10 md8 lg6>
                <v-card class="bt-box-card-black diagradient">
                    <v-img
                            src="/img/50a.png"
                            height="180px"
                    ></v-img>
                    <!-- alto anterior 200px -->
                    <v-card-title primary-title>
                        <div>
                            <h3 class="headline mb-0 white--text">Módulo: Jefe de Agencia</h3>
                        </div>
                    </v-card-title>

                    <v-card-actions>
                        <div>
                            <h3 class="pa-2 white--text">Acciones:</h3>
                        </div>
                        <v-btn class="white black--text"
                               @click="modal_buscar=!modal_buscar"
                        >Buscar Expediente</v-btn>
                        <!-- clase anterior green-2 white--text -->
                        <v-btn class="white black--text"
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
                            class="headline black--text text-xs-center"

                    >
                        Buscar expediente
                    </v-card-title>
                    <v-divider class="blue-darken-2"></v-divider>
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
                                class="green--text2"
                                flat
                                @click="buscarExpediente"
                        >
                            <!--color ="primary" flat -->
                            Buscar
                            <v-icon right dark>send</v-icon>
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