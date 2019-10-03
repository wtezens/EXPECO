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
import AppRealizarPagoLiquidacion from './components/contabilidad/AppEfectuarPagoLiquidacion'
import AppFormReporteCasosLiquidados from './components/contabilidad/AppFormReporteCasosLiquidados'

Vue.component('app-footer', AppFooter);
Vue.component('AppChangePassword',AppChangePassword);
Vue.component('app-realizar-pago-liquidacion', AppRealizarPagoLiquidacion);

/**
 * CREDITOS
 */
import routes from './routes/contabilidad_routes';

const router = new VueRouter({
    routes
});

const app_contabilidad = new Vue({
    el: '#contabilidad',
    router,
    data: ()=> {
        return {
            left_menu:false,
            dialog_search:false,
            actionsUser: [
                ['Cambiar contraseña', 'settings','/password'],
                ['Cerrar Sesión', 'exit_to_app','/logout']
            ],
            valid: false,
            expediente:'',
            expedienteRules:[
                v => !!v || 'Ingrese un número',
                v => v.length <=10 || 'ingrese menos de 10 digitos',
                v => /^[0-9]+$/.test(v)||'el número debe ser válido'
            ],
            notarios: [],
            agencias: []

        };
    },
    created(){
        this.getNotarios();
        this.getAgencias();
    },
    methods:{
        buscarExpediente(){
            if(this.$refs.expediente.validate()){
                window.location.hash='/expediente/'+this.expediente;
                this.dialog_search=false;
                this.$refs.expediente.reset();
                this.expediente='';
            }
        },
        getNotarios(){
            axios.get('/contabilidad/getNotaries')
                .then(response => {
                    this.notarios = response.data;
                })
                .catch(error => {
                    swal({
                        title: this.OnErrorMessages(error.response),
                        text:'Ref. Notarios - Code: ' + error.response.status,
                        buttonsStyling:false,
                        confirmButtonClass:'v-btn error'
                    })
                });
        },
        getAgencias(){
            axios.get('/contabilidad/getAgencies')
                .then(response => {
                    this.agencias = response.data;
                })
                .catch(error => {
                    swal({
                        title: this.OnErrorMessages(error.response),
                        text:'Ref. Agencias - Code: ' + error.response.status,
                        buttonsStyling:false,
                        confirmButtonClass:'v-btn error'
                    })
                });
        },
        /*Codigos de Errores
            * var @error HTTP*/
        OnErrorMessages(error){
            switch (error.status) {
                case 404:
                    return 'No se ha podido encontrar el recurso solicitado.';
                    break;
                case 403:
                    return 'No tiene acceso para acceder a este recurso.';
                    break;
                case 419:
                    return 'Su sessión ha expirado, recargue la página.';
                    break;
                case 500:
                    return 'Error del servidor.';
                    break;
                default:
                    return error.statusText;
                    break;
            }
        }
    }
});
