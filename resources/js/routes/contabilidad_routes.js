import DashboardContabilidad from '../components/contabilidad/dashboardContabilidad';
import ExpedienteShow from '../components/contabilidad/AppExpedienteShow'
import Logout from '../components/login/AppLogout'
import ChangePassword from '../components/login/AppFormChangePassword'
import NewAnticipo from '../components/contabilidad/AppNewAnticipo'
import AnticipoShow from '../components/contabilidad/AppListAnticipos'
import LiquidarCreate from '../components/contabilidad/AppPagarLiquidacion'
import LiquidadosShow from '../components/contabilidad/AppYaLiquidados'

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
        component: NewAnticipo,
        props:{New:true}
    },
    {
        path:'/anticipo/show',
        name:'anticipo.show',
        component: AnticipoShow,
    },
    {
        path:'/liquidar',
        name:'liquidar.create',
        component: LiquidarCreate,
    },
    {
        path:'/liquidados',
        name:'liquidar.show',
        component: LiquidadosShow,
    },
    {
        path:'/password',
        name:'password.change',
        component: ChangePassword,
        props:{colaborador:true}
    },
];

export default routes