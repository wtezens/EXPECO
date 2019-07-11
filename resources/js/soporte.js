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

import dashboardSoporte from "./components/soporte/dashboardSoporte";
import AppFooter from "./components/AppFooter";
import AppChangePassword from "./components/login/AppChangePassword";
import AppCardUser from "./components/soporte/card-users";

Vue.component('card-users', AppCardUser);
Vue.component('AppChangePassword', AppChangePassword);
Vue.component('app-footer', AppFooter);
Vue.component('home', dashboardSoporte);


/*rutas soporte*/

import routes from './routes/soporte_routes';

const router = new VueRouter({
    routes
});

const app_soporte = new Vue({
    el: '#soporte_tecnico',
    router,
    data: ()=> {
        return {
            left_menu: false,
            actionsUser: [
                ['Cambiar contraseña', 'settings', '/password'],
                ['Cerrar Sesión', 'exit_to_app', '/logout']
            ],
            users: [],
            total_users: 0,
            roles: [],
            agencias:[],
        };
    },
    created: function () {
        this.getUsers();
        this.getRoles();
        this.getAgencias();
    },
        methods: {
            /**
             * Obtenemos todos los usuarios del sistema
             */
            getUsers: function () {
                axios.get('/soporte/usuarios/')
                    .then(response => {
                        this.users = response.data.datos;
                        this.total_users = response.data.total;
                    })
                    .catch(error => {
                        if (error.response.status === 403) {
                            swal({
                                type: 'error',
                                title: '403. Forbidden',
                                text: 'No tiene autorización para realizar esta acción.',
                                buttonsStyling: false,
                                confirmButtonClass: 'v-btn primary'
                            })
                        } else if (error.response.status === 404) {
                            swal({
                                type: 'error',
                                title: 'Fallo en la operación.',
                                text: 'No se pudo completar la consulta.',
                                buttonsStyling: false,
                                confirmButtonClass: 'v-btn primary'
                            })
                        } else {
                            swal({
                                title: error.toString(),
                                buttonsStyling: false,
                                confirmButtonClass: 'v-btn primary'
                            })
                        }
                    })
            },
            getRoles() {
                axios.get('/soporte/list/roles')
                    .then(res => {
                        this.roles = res.data;
                    })
                    .catch(error => {
                        swal({
                            title: 'No pudimos obtener los roles.',
                            text: error.toString()
                        })
                    })
            },
            getAgencias() {
                axios.get('/soporte/list/agencias')
                    .then(res => {
                        this.agencias = res.data;
                    })
                    .catch(error => {
                        swal({
                            title: 'No pudimos obtener las agencias.',
                            text: error.toString()
                        })
                    })
            }
        }
});
