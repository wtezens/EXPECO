const routes = [
    {
        path:'/',
        name:'home',
        component: require('../components/gerencia/dashboardGerencia')
    },
    {
        path:'/logout',
        name:'creditos.logout',
        component:require('../components/login/AppLogout'),
        props:{redirect:'/gerencia/panel'}
    },
    {
        path:'/expediente/:idexpediente',
        name:'expediente.show',
        component:require('../components/gerencia/AppExpedienteShow')
    },
    {
        path:'/password',
        name:'password.change',
        component:require('../components/login/AppFormChangePassword'),
        props:{colaborador:true}
    }
];

export default routes