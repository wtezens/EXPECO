import DashboardContabilidad from '../components/contabilidad/dashboardContabilidad';
import ExpedienteShow from '../components/contabilidad/AppExpedienteShow'
import Logout from '../components/login/AppLogout'
import ChangePassword from '../components/login/AppFormChangePassword'

const routes = [
    {
        path:'/',
        name:'home',
        component: DashboardContabilidad
    },
    {
        path:'/logout',
        name:'contabilidad.logout',
        component: Logout,
        props:{redirect:'/contabilidad/panel'}
    },
    {
        path:'/expediente/:idexpediente',
        name:'expediente.show',
        component: ExpedienteShow
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
        component: ChangePassword,
        props:{colaborador:true}
    },
];

export default routes