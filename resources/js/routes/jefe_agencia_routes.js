const routes = [
    {
        path:'/',
        name:'home',
        component: require('../components/jefe_agencia/dashboardJefeAgencia')
    },
    {
        path:'/logout',
        name:'jefes.logout',
        component:require('../components/login/AppLogout'),
        props:{redirect:'jefe'}
    },
    {
        path:'/expediente/:idexpediente',
        name:'expediente.show',
        component:require('../components/jefe_agencia/AppExpedienteShow')
    },
    {
        path:'/password',
        name:'password.change',
        component:require('../components/login/AppFormChangePassword'),
        props:{colaborador:true}
    },
    {
        path:'/asociado/show',
        name:'asociado.show',
        component: require('../components/jefe_agencia/AppVerAsociado'),
        props:{New:true}
    }
];

export default routes