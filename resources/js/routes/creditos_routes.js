const routes = [
    {
        path:'/',
        name:'home',
        component: require('../components/creditos/dashboardCredits')
    },
    {
        path:'/asociado/create',
        name:'asociado.create',
        component: require('../components/creditos/AppAsociadoCreate'),
        props:{New:true}
    },
    {
        path:'/asociado/show',
        name:'asociado.show',
        component: require('../components/creditos/AppVerAsociado'),
        props:{New:true}
    },
    {
        path:'/creditos/create',
        name:'creditos.create',
        component:require('../components/creditos/AppCreditosCreate'),
        props: { New:true }
    },
    {
        path:'/creditos/calculate',
        name:'creditos.calculate',
        component:require('../components/creditos/AppCreditosCalculate'),
    },
    {
        path:'/logout',
        name:'creditos.logout',
        component:require('../components/login/AppLogout'),
        props:{redirect:'creditos'}
    },
    {
        path:'/expediente/:idexpediente',
        name:'expediente.show',
        component:require('../components/creditos/AppExpedienteShow')
    },
    {
        path:'/envios',
        name:'expedientes.notario',
        component:require('../components/creditos/AppEnvioAbogado')
    },
    {
        path:'/password',
        name:'password.change',
        component:require('../components/login/AppFormChangePassword'),
        props:{colaborador:true}
    }
];

export default routes