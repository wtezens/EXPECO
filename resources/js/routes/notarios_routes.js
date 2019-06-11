import DashboardNotarios from '../components/notario/dashboardNotaries'
import Logout from '../components/login/AppLogoutNotario'
import ExpedienteShow from '../components/notario/AppExpedienteShow'
import ExpedienteRevision from '../components/notario/AppEnvioRevision'
import ExpedienteLiquidacion from '../components/notario/AppGenerarLiquidacion'
import Liquidaciones from '../components/notario/AppVerLiquidaciones'
import ChangePassword from '../components/login/AppFormChangePassword'

const routes = [
    {
        path:'/',
        name:'home',
        component: DashboardNotarios
    },
    {
        path:'/logout',
        name:'notarios.logout',
        component: Logout,
    },
    {
        path:'/expediente/:idexpediente',
        name:'expediente.show',
        component: ExpedienteShow
    },
    {
        path:'/revision',
        name:'expedientes.revision',
        component: ExpedienteRevision
    },
    {
        path:'/liquidacion',
        name:'expedientes.liquidacion',
        component: ExpedienteLiquidacion
    },
    {
        path:'/liquidaciones',
        name:'liquidaciones.show',
        component: Liquidaciones
    },
    {
        path:'/password',
        name:'password.change',
        component: ChangePassword,
        props:{colaborador:false}
    }
];

export default routes