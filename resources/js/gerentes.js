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

Vue.component('app-footer', require('./components/AppFooter.vue'));
Vue.component('app-change-password',require('./components/login/AppChangePassword'));

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
