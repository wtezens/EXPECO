require('./vuetify');
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import Vuetify from 'vuetify'
import VueRouter from 'vue-router'

Vue.use(Vuetify);
Vue.use(VueRouter);

import AppFooter from './components/AppFooter'
import AppChangePassword from './components/login/AppChangePassword'

Vue.component('app-footer', AppFooter);
Vue.component('app-change-password', AppChangePassword);

/**
 * CREDITOS
 */
import routes from './routes/secretaria_gerencia_routes';

const router = new VueRouter({
    routes
});

const app_secretaria_gerencia = new Vue({
    el: '#secretaria_gerencia',
    router,
    data: ()=> {
        return {
            left_menu:false,
            dialog_search:false,
            valid: false,
            actionsUser: [
                ['Cambiar contraseña', 'settings','/password'],
                ['Cerrar Sesión', 'exit_to_app','/logout']
            ],
            expediente:'',
            expedienteRules:[
                v => !!v || 'Ingrese un número',
                v => v.length <=10 || 'ingrese menos de 10 digitos',
                v => /^[0-9]+$/.test(v)||'el número debe ser válido'
            ]
        }
    },
    methods:{
        buscarExpediente(){
            if(this.ValidarExpediente()){
                window.location.hash='/expediente/'+this.expediente;
                this.dialog_search=false;
                this.$refs.expediente.reset();
                this.expediente='';
            }
        },
        ValidarExpediente(){
            if(this.$refs.expediente.validate()){
                return true;
            }else{
                return false;
            }
        }

    }
});