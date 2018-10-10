<template>
    <div>
        <v-layout row wrap>
            <v-flex xs12>
                <v-snackbar
                        v-model="alertErrors"
                        :timeout="4500"
                        :color="snackbarColor"
                        :top="y==='top'"
                >
                    <li class="white--text" v-for="value in errors" v-text="convertToString(value)">
                    </li>
                    <v-btn
                            flat
                            @click="alertErrors = false"
                    >
                        Cerrar
                    </v-btn>
                </v-snackbar>
                <v-snackbar
                        v-model="success"
                        :timeout="4500"
                        :color="snackbarColorSuccess"
                        :top="y==='top'"
                >
                    <li class="white--text">Registro creado correctamente</li>
                    <v-btn
                            flat
                            @click="success = false"
                    >
                        Cerrar
                    </v-btn>
                </v-snackbar>
                <v-card>
                    <v-card-title primary-title class="center blue-grey lighten-4">
                        <div>
                            <h3 class="headline">Nuevo anticipo</h3>
                        </div>
                    </v-card-title>
                    <v-divider class="green"></v-divider>
                    <v-card-text>
                        <v-layout row wrap>
                            <v-flex xs12 sm5>
                                <v-form id="form_case_file" ref="form" v-model="valido" lazy-validation>
                                    <v-flex xs12 sm12 md6 lg6>
                                        <v-text-field
                                                validate-on-blur
                                                ref="clave"
                                                v-model="clave"
                                                label="Ingrese una palabra clave:"
                                                required
                                                :rules="RulesKey"
                                        >
                                        </v-text-field>
                                    </v-flex>
                                    <v-layout row class="pt-2">
                                        <v-flex xs12 sm6>
                                            <v-btn block color="primary"
                                                   :disabled="!valido"
                                                   @click="nuevo_anticipo"
                                            >
                                                Generar anticipo
                                            </v-btn>
                                        </v-flex>
                                    </v-layout>
                                </v-form>
                            </v-flex>
                            <v-flex xs12 sm7>
                                <div class="display-1">Recuerde:</div>
                                <div>
                                    <v-alert
                                            :value="true"
                                            color="info"
                                            outline
                                    >
                                        <li class="subheading">Escriba una clave sin espacios.</li>
                                        <li class="subheading">Guarde la clave utilizada para el registro.</li>
                                        <li class="subheading">Clave y correlativo deben ser entregados a contabilidad.</li>
                                    </v-alert>
                                </div>
                            </v-flex>
                        </v-layout>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 sm12 md5 mt-3>
                <v-card>
                    <v-divider class="amber darken-4"></v-divider>
                    <v-card-title primary-title class="blue-grey lighten-5">
                        <div>
                            <div class="headline teal--text">Datos importantes</div>
                            <span class="black--text subheading">Entregar a contabilidad para su procesamiento</span>
                        </div>
                    </v-card-title>
                    <v-divider class="amber darken-4"></v-divider>
                    <v-card-text>
                        <div>Correlativo:</div> <div class="blue--text title" v-text="correlativo"></div>
                        <div>Clave de validación:</div> <div class="blue--text title" v-text="key"></div>
                        <!--div>Token de validación:</div> <div class="blue--text body-2" v-text="ciph"></div-->
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </div>

</template>

<script>
    export default {
        name: "AppAnticipoCreate",
        data:()=>{
            return {
                success:false,
                snackbarColorSuccess:'success',
                y:'top',                //ubicacion snackbar
                snackbarColor:'red',  //color snackbar
                valido: true,
                alertErrors:false,
                errors:[],
                clave:'',
                RulesKey: [
                    v => !!v || 'ingrese una clave',
                    v => /^\S*$/.test(v)|| 'la clave no puede contener espacios'
                ],

                //datos anticipo
                key:'',
                correlativo:'',
                ciph:''
            }
        },
        methods:{
            convertToString(cadena){
                return cadena.toString();
            },
            nuevo_anticipo(){
                if(this.$refs.form.validate()){
                    axios.post('/gerentes/anticipos/store',{
                        clave:this.clave
                    })
                        .then(response =>{
                            if(response.data.estatus=='ok'){
                                this.key=this.clave;
                                this.correlativo = response.data.anticipo.id;
                                this.success=true;
                                this.$refs.clave.reset();
                                this.clave='';
                            }
                        })
                        .catch(error=>{
                            if(error.response.data.errors){
                                this.errors = error.response.data.errors;
                                this.alertErrors=true;
                            }else{
                                swal({
                                    title:error.toString(),
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }
                        })
                }
            },
        }
    }
</script>