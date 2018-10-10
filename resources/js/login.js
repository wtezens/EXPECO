require('./vuetify');
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);

window.Vuetify = require('vuetify');

Vue.use(Vuetify);


/**
 * CREDITOS
 */
const app_login = new Vue({
    el: '#login',
    data: ()=> {
        return {
            y:'top',                //ubicacion snackbar
            snackbarColor:'white',  //color snackbar
            visualizar:false,       //show password
            valido:true,            //formulario válido
            alertErrors:false,      //Mostrar alerta
            errors:[],              //errores

            //Datos del login
            email:'',               //email
            password:'',            //password

            //RULES
            emailRules:[
                v => !!v || 'ingrese correo',
                v => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'el correo no es válido'
            ],
            passwordRules:[
                v => !!v || 'ingrese contraseña',
                v => /^\S*$/.test(v)|| 'la contraseña no puede contener espacios'
            ]
        };
    },
    methods:{

        /**
         * Convierte el objeto cadena en un string
         * @param cadena
         * @returns {string}
         */
        convertToString(cadena){
            return cadena.toString();
        },

        /**
         * Submit Notario
         * if credentials redirect intended
         */
        submitNotario(){
            if(this.$refs.form.validate()){
                axios.post('/notario/login',{
                    email:this.email,
                    password:this.password

                })
                    .then(response=>{
                        if(response.data.auth === true){
                            window.location = response.data.intended;
                        }
                    })
                    .catch(error =>{
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
                    });

            }
        },
        /**
         * Submit Colaborador
         * if credentials redirect intended
         */
        submitColaborador(){
            if(this.$refs.form.validate()){
                axios.post('/colaborador/login',{
                    email:this.email,
                    password:this.password
                })
                    .then(response=>{
                        if(response.data.auth === true){
                            window.location = response.data.intended;
                        }
                    })
                    .catch(error =>{
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
                    });
            }
        }
    }
});