const routes = [
    {
        path:'/',
        name:'home',
        component: require('../components/contabilidad/dashboardContabilidad')
    },
    {
        path:'/logout',
        name:'contabilidad.logout',
        component:require('../components/login/AppLogout'),
        props:{redirect:'/contabilidad/panel'}
    },
    {
        path:'/expediente/:idexpediente',
        name:'expediente.show',
        component:require('../components/contabilidad/AppExpedienteShow')
    },
    {
        path:'/anticipo/new',
        name:'anticipo.new',
        component:require('../components/contabilidad/AppNewAnticipo'),
        props:{New:true}
    },
    {
        path:'/anticipo/show',
        name:'anticipo.show',
        component:require('../components/contabilidad/AppListAnticipos'),
    },
    {
        path:'/liquidar',
        name:'liquidar.create',
        component:require('../components/contabilidad/AppPagarLiquidacion'),
    },
    {
        path:'/liquidados',
        name:'liquidar.show',
        component:require('../components/contabilidad/AppYaLiquidados'),
    },
    {
        path:'/password',
        name:'password.change',
        component:require('../components/login/AppFormChangePassword'),
        props:{colaborador:true}
    },
];

export default routes