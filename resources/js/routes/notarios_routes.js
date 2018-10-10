const routes = [
    {
        path:'/',
        name:'home',
        component: require('../components/notario/dashboardNotaries')
    },
    {
        path:'/logout',
        name:'notarios.logout',
        component:require('../components/login/AppLogoutNotario'),
    },
    {
        path:'/expediente/:idexpediente',
        name:'expediente.show',
        component:require('../components/notario/AppExpedienteShow')
    },
    {
        path:'/revision',
        name:'expedientes.revision',
        component:require('../components/notario/AppEnvioRevision')
    },
    {
        path:'/liquidacion',
        name:'expedientes.liquidacion',
        component:require('../components/notario/AppGenerarLiquidacion')
    },
    {
        path:'/liquidaciones',
        name:'liquidaciones.show',
        component:require('../components/notario/AppVerLiquidaciones')
    },
    {
        path:'/password',
        name:'password.change',
        component:require('../components/login/AppFormChangePassword'),
        props:{colaborador:false}
    }
];

export default routes