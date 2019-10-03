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
 * GERENTES
 */
import routes from './routes/gerentes_routes';

const router = new VueRouter({
    routes
});

const app_gerentes = new Vue({
    el: '#gerentes',
    router,
    data: ()=> {
        return {
            left_menu:false,
            actionsUser: [
                ['Cambiar contraseña', 'settings','/password'],
                ['Cerrar Sesión', 'exit_to_app','/logout']
            ]
        };
    },
    methods:{

    }
});
