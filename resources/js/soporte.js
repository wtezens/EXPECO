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
                ['Cambiar contraseña', 'settings','/password'],
                ['Cerrar Sesión', 'exit_to_app','/logout']
            ],
        }
    }
});
