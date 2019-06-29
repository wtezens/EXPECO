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
import AppEstatusTres from './components/notario/AppEstatusTres'
import AppModalSearch from './components/AppModalSearch'
import AppInscripcionExpediente from './components/notario/AppIncripcionExpediente'
import AppAgregarRechazo from './components/notario/AppAgregarRechazo'


Vue.component('my-component', require('./components/Example-component.vue'));
Vue.component('app-footer', AppFooter);
Vue.component('app-modal-search', AppModalSearch);
Vue.component('app-estatus-tres', AppEstatusTres);
Vue.component('app-incripcion-expediente', AppInscripcionExpediente);
Vue.component('app-change-password', AppChangePassword);
Vue.component('app-agregar-rechazo', AppAgregarRechazo);

/**
 * CREDITOS
 */
import routes from './routes/notarios_routes';

const router = new VueRouter({
    routes
});

const app_notario = new Vue({
    el: '#notario',
    router,
    data: ()=> {
        return {
            left_menu:false,
            dialog_search:false,
            dialog_note:false,
            actionsUser: [
                ['Cambiar contraseña', 'settings','/password'],
                ['Cerrar Sesión', 'exit_to_app','/logout']
            ],
            menuEnvios:[
                {id:1, title:'Expedientes a revisión', route:'/revision',icon:'note'},
            ],
            menuLiquidacion:[
                {id:1, title:'Generar Liquidación', route:'/liquidacion',icon:'add_box'},
                {id:2, title:'Ver liquidaciones', route:'/liquidaciones',icon:'done_all'}
            ],
            valid: false,
            expediente:'',
            observaciones:'',
            expedienteRules:[
                v => !!v || 'Ingrese un número',
                v => v.length <=10 || 'ingrese menos de 10 digitos',
                v => /^[0-9]+$/.test(v)||'el número debe ser válido'
            ],


            //datos generales del dashboard
            datos:[],
            expedientes:[], //expedientes atrasados
        };
    },
    created(){
        this.getDatos();
        this.getAtrasados();
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
        NotaExpediente(){
            if(this.$refs.expediente.validate()){
                window.open('/notario/nota/expediente/'+this.expediente+'?&o='+encodeURI(this.observaciones));
                this.dialog_note=false;
                this.$refs.expediente.reset();
                this.expediente='';
            }
        },
        getDatos:function () {
            axios.get('/notario/dashboard')
                .then(res => {
                    this.datos =res.data;
                })
                .catch(error => {
                    swal({
                        title: 'No se ha completado la solicitud de datos.'
                    })
                });
        },
        getAtrasados:function () {
            axios.get('/notario/sinliquidar')
                .then(response => {
                    this.expedientes = response.data;
                })
                .catch(error => {
                    swal({
                        title: 'No se ha completado la solicitud de datos.'
                    })
                });
        },
    }
});
