<template>
    <v-layout row wrap my-4 justify-center>
        <v-flex xs12 sm8 md6  lg5 xl4>
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
            <v-card>
                <v-card-title primary-title class="center diagradient">
                    <!-- class = blue-grey lighten-4 -->
                    <div>
                        <h3 class="headline white--text">Cambiar contraseña</h3>
                    </div>
                </v-card-title>
                <v-divider class="green"></v-divider>
                <v-card-text>
                    <v-form ref="form" v-model="valido" lazy-validation>
                        <v-flex xs12 pb-2>
                            <v-text-field
                                    validate-on-blur
                                    prepend-icon="lock"
                                    :append-icon="visualizar ? 'visibility_off' : 'visibility'"
                                    ref="cpassword"
                                    v-model="password_actual"
                                    label="Contraseña actual"
                                    :rules="passwordRules"
                                    required
                                    :type="visualizar ? 'text' : 'password'"
                                    @click:append="visualizar = !visualizar"
                            >
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 pb-2>
                            <v-text-field
                                    validate-on-blur
                                    prepend-icon="lock"
                                    ref="cpassword"
                                    v-model="password_nuevo"
                                    label="Nueva contraseña"
                                    :rules="passwordRules"
                                    required
                                    :type="visualizar ? 'text' : 'password'"
                                    @click:append="visualizar = !visualizar"
                            >
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 pb-2>
                            <v-text-field
                                    validate-on-blur
                                    prepend-icon="lock"
                                    ref="cpassword"
                                    v-model="password_confirm"
                                    label="Confirmar contraseña"
                                    :rules="passwordRules"
                                    required
                                    :type="visualizar ? 'text' : 'password'"
                                    @click:append="visualizar = !visualizar"
                            >
                            </v-text-field>
                        </v-flex>
                        <br>
                        <v-btn block outline class=" green--text2"
                               :disabled="!valido"
                               @click="submit"
                        >
                            <!-- color="primary white--text"-->
                            guardar cambios
                            <v-icon right dark>send</v-icon>
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "AppChangePassword",
        props:[
            'colaborador'
        ],
        data:()=>{
            return {
                y:'top',
                snackbarColor:'red lighten-1',
                visualizar:false,
                valido:true,
                alertErrors:false,
                errors:[],

                password_actual:'',
                password_nuevo:'',
                password_confirm:'',
                passwordRules:[
                    v => !!v || 'ingrese contraseña',
                    v => v.length>6||'contraseña muy corta - min:6 caracteres',
                    v => /^\S*$/.test(v)|| 'la contraseña no puede contener espacios'
                ]
            }
        },
        methods: {
            submit(){
                if(this.$refs.form.validate()) {
                    if (this.colaborador == true) {
                        axios.post('/colaborador/changepassword', {
                            mypassword: this.password_actual,
                            password: this.password_nuevo,
                            password_confirmation: this.password_confirm
                        })
                            .then(response => {
                                if (response.data.estatus === 'ok') {
                                    swal({
                                        type: 'success',
                                        title: 'Tu contraseña ha cambiado.',
                                        showConfirmButton: true,
                                        buttonsStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    });
                                    this.clear();
                                } else if (response.data.estatus === 'fail') {
                                    swal({
                                        type: 'warning',
                                        title: response.data.descripcion,
                                        text: 'Verifica tu contraseña actual.',
                                        showConfirmButton: true,
                                        buttonsStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    });
                                }
                            })
                            .catch(error => {
                                if (error.response.data.errors) {
                                    this.errors = error.response.data.errors;
                                    this.alertErrors = true;
                                } else {
                                    swal({
                                        title: error.toString(),
                                        buttonsStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    })
                                }
                            })
                    }else{
                        axios.post('/notario/changepasswordnotario', {
                            mypassword: this.password_actual,
                            password: this.password_nuevo,
                            password_confirmation: this.password_confirm
                        })
                            .then(response => {
                                if (response.data.estatus === 'ok') {
                                    swal({
                                        type: 'success',
                                        title: 'Tu contraseña ha cambiado.',
                                        showConfirmButton: true,
                                        buttonsStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    });
                                    this.clear();
                                } else if (response.data.estatus === 'fail') {
                                    swal({
                                        type: 'warning',
                                        title: response.data.descripcion,
                                        text: 'Verifica tu contraseña actual.',
                                        showConfirmButton: true,
                                        buttonsStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    });
                                }
                            })
                            .catch(error => {
                                if (error.response.data.errors) {
                                    this.errors = error.response.data.errors;
                                    this.alertErrors = true;
                                } else {
                                    swal({
                                        title: error.toString(),
                                        buttonsStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    })
                                }
                            })
                    }
                }
            },
            reemplazarCadena(cadena){
                return cadena.toString();
            },
            clear () {
                this.$refs.form.reset();
                this.password_actual='';
                this.password_nuevo='';
                this.password_confirm='';
            },
            /**
             * Convierte el objeto cadena en un string
             * @param cadena
             * @returns {string}
             */
            convertToString(cadena){
                return cadena.toString();
            }
        }
    }
</script>