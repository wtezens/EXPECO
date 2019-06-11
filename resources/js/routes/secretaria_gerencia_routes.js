import DashboardGerencia from '../components/gerencia/dashboardGerencia'
import Logout from '../components/login/AppLogout'
import ExpedienteShow from '../components/gerencia/AppExpedienteShow'
import ChangePassword from '../components/login/AppChangePassword'

const routes = [
    {
        path:'/',
        name:'home',
        component: DashboardGerencia
    },
    {
        path:'/logout',
        name:'creditos.logout',
        component: Logout,
        props:{redirect:'/gerencia/panel'}
    },
    {
        path:'/expediente/:idexpediente',
        name:'expediente.show',
        component: ExpedienteShow
    },
    {
        path:'/password',
        name:'password.change',
        component: ChangePassword,
        props:{colaborador:true}
    }
];

export default routes