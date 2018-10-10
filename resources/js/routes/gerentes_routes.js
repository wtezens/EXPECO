const routes = [
    {
        path:'/',
        name:'home',
        component: require('../components/gerentes/dashboardGerentes')
    },
    {
        path:'/logout',
        name:'gerentes.logout',
        component:require('../components/login/AppLogout'),
        props: {redirect:'/gerentes/panel'}
    },
    {
        path:'/password',
        name:'password.change',
        component:require('../components/login/AppFormChangePassword'),
        props:{colaborador:true}
    },
    {
        path:'/anticipo/create',
        name:'anticipo.create',
        component:require('../components/gerentes/AppAnticipoCreate'),
    },
    {
        path:'/anticipo/show',
        name:'anticipo.show',
        component:require('../components/gerentes/AppListAnticipos'),
    }
];

export default routes