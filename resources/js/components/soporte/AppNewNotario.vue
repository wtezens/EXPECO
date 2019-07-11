<template>
    <v-layout row wrap my-1 justify-center>
        <v-flex xs12 sm8 md8>
            <v-snackbar
                v-model="alertErrors"
                :timeout="4500"
                :color="snackbarColor"
                :top="y==='top'"
                :auto-height="'true'==='true'"
            >
                <ul>
                    <li v-for="value in errors" v-text="convertToString(value)">
                    </li>
                </ul>
                <v-btn
                    class="white red--text"
                    flat
                    @click="alertErrors = false"
                >
                    Cerrar
                </v-btn>
            </v-snackbar>
            <v-card>
                <v-card-title primary-title class="center blue-grey lighten-4">
                    <!-- class = blue-grey lighten-4 -->
                    <div>
                        <h3 class="headline black--text">NUEVO NOTARIO</h3>
                    </div>
                </v-card-title>
                <v-divider class="green"></v-divider>
                <v-card-text>
                    <v-form ref="form" v-model="valido" lazy-validation>
                        <v-layout row wrap>
                            <v-flex xs12 sm12 md6 pb-2>
                                <v-text-field
                                    validate-on-blur
                                    autofocus
                                    ref="email"
                                    prepend-icon="email"
                                    v-model="email"
                                    label="correo"
                                    v-on:change="onChangeEmail"
                                    :rules="emailRules"
                                    required
                                >
                                </v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md6 pb-2>
                                <v-text-field
                                    validate-on-blur
                                    prepend-icon="account_circle"
                                    ref="nombre"
                                    v-model="nombre"
                                    label="Nombres y Apellidos"
                                    :rules="nameRules"
                                    required
                                >
                                </v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md6 pb-2>
                                <v-text-field
                                    validate-on-blur
                                    prepend-icon="lock"
                                    ref="password"
                                    v-model="password"
                                    label="contraseña por defecto"
                                    :rules="passwordRules"
                                    required
                                    :type="'password'"
                                >
                                </v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md6 pb-2>
                                <v-text-field
                                    validate-on-blur
                                    prepend-icon="lock"
                                    ref="telefono"
                                    v-model="telefono"
                                    label="Telefóno"
                                    required
                                >
                                </v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12 pb-2>
                                <v-text-field
                                    validate-on-blur
                                    prepend-icon="lock"
                                    ref="direccion"
                                    v-model="direccion"
                                    label="Dirección"
                                    required
                                >
                                </v-text-field>
                            </v-flex>
                            <v-btn block outline class=" green--text2"
                                   :disabled="!valido"
                                   @click="submit"
                            >
                                <!-- color="primary white--text"-->
                                guardar
                                <v-icon right dark>send</v-icon>
                            </v-btn>
                        </v-layout>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "AppNewNotario",
        data:()=>{
            return {
                y:'top',
                snackbarColor:'red lighten-1',
                valido:true,
                alertErrors:false,
                errors:[],

                email: '',
                emailRules:[
                    v => !!v || 'ingrese correo',
                    v => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'el correo no es válido'
                ],

                nombre: '',
                nameRules: [
                    v => !!v || 'ingrese los datos',
                    v => v.length <=30 || 'nombre muy largo',
                    v => /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\xDC\xFC\s-]{3,30}$/.test(v) || 'nombre inválido'
                ],
                telefono:'',
                direccion:'',
                password:'',
                passwordRules:[
                    v => !!v || 'ingrese contraseña por defecto',
                    v => v.length>6||'contraseña muy corta - min:6 caracteres',
                    v => /^\S*$/.test(v)|| 'la contraseña no puede contener espacios'
                ]
            }
        },
        methods: {
            onChangeEmail: function () {
                if(this.ValidateEmailNotary(this.email)){
                    axios.post('/soporte/validar/emailNotary',{
                        email: this.email
                    })
                        .then(response => {
                            if(response.data.estatus === 'fail') {
                                swal({
                                    title: 'El correo proporcionado ya existe.',
                                    text: 'Ingrese un correo único.',
                                    type: 'warning',
                                    showCloseButton: true,
                                    buttonsStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                })
                                this.email = '';
                            }
                        })
                        .catch(error => {
                            console.log('No pudimos validar el email');
                        });
                }else{
                    swal({
                        title:'El correo ingresado es incorrecto.',
                        buttonsStyling:false,
                        confirmButtonClass:'v-btn primary'
                    })
                }
            },
            ValidateEmailNotary:function (email) {
                let expreg = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

                if(expreg.test(email)) return true
                else return false;
            },
            submit(){
                if(this.$refs.form.validate()) {
                    axios.post('/soporte/notarios/store', {
                        email: this.email,
                        nombre: this.nombre,
                        password: this.password,
                        telefono:this.telefono,
                        direccion:this.direccion

                    })
                        .then(response => {
                            console.log(response.data)
                            if (response.data.estatus === 'ok') {
                                swal({
                                    type: 'success',
                                    title: response.data.descripcion,
                                    showConfirmButton: true,
                                    buttonsStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                });
                                this.$root.users.push(response.data.user[0]);
                                this.$root.total_users++;
                                this.clear();

                            } else if (response.data.estatus === 'fail') {
                                swal({
                                    type: 'error',
                                    title: response.data.descripcion,
                                    text: 'Email Duplicate: No es posible registrar al usuario.',
                                    showConfirmButton: true,
                                    buttonsStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                });
                            }else if(response.data.estatus==='duplicate key'){
                                swal({
                                    type: 'error',
                                    title: 'Datos duplicados.',
                                    text:'El registro ya existe!',
                                    showConfirmButton: true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            } else if(response.data.estatus==='a foreign key constraint fails'){
                                swal({
                                    type: 'error',
                                    title: 'Violación de Integridad.',
                                    text:'No es puede añadir o actualizar una fila secundaria.',
                                    showConfirmButton: true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }else if(response.data.estatus==='incorrect type value'){
                                swal({
                                    type: 'error',
                                    title: 'Valores incorrectos.',
                                    text:'El tipo de valor esperado es incorrecto.',
                                    showConfirmButton: true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }
                        })
                        .catch(error => {
                            if (error.response.data.errors) {
                                this.errors = error.response.data.errors;
                                this.alertErrors = true;
                            }else if(error.response.estatus===403){
                                swal({
                                    type:'error',
                                    title:'403. Forbidden',
                                    text:'No tiene autorización para realizar esta acción.',
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }else if(error.response.estatus===404){
                                swal({
                                    type:'error',
                                    title:'404: Fallo en la operación.',
                                    text:'No es posible realizar esta acción.',
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            } else {
                                swal({
                                    title: error.toString(),
                                    buttonsStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                })
                            }
                        })
                    }
            },
            clear () {
                this.$refs.form.reset();
                this.email = '';
                this.nombres = '';
                this.telefono = '';
                this.direccion='';
                this.password = '';
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
