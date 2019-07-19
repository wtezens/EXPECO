import DashboardCreditos from '../components/creditos/dashboardCredits';
import AsociadoCreate from '../components/creditos/AppAsociadoCreate'
import VerAsociado from '../components/creditos/AppVerAsociado'
import CreditosCreate from '../components/creditos/AppCreditosCreate'
import CreditosCalculate from '../components/creditos/AppCreditosCalculate'
import Logout from '../components/login/AppLogout'
import ExpedienteShow from '../components/creditos/AppExpedienteShow'
import EnvioAbogado from '../components/creditos/AppEnvioAbogado'
import ChangePassword from '../components/login/AppFormChangePassword'

const routes = [
    {
        path:'/',
        name:'home',
        component: DashboardCreditos
    },
    {
        path:'/asociado/create',
        name:'asociado.create',
        component: AsociadoCreate,
        props:{New:true}
    },
    {
        path:'/asociado/show',
        name:'asociado.show',
        component: VerAsociado,
        props:{New:true}
    },
    {
        path:'/creditos/create',
        name:'creditos.create',
        component: CreditosCreate,
    },
    {
        path:'/expediente/:idexpediente',
        name:'expediente.show',
        component: ExpedienteShow
    },
    {
        path:'/envios',
        name:'expedientes.notario',
        component: EnvioAbogado
    },
    {
        path:'/creditos/calculate',
        name:'creditos.calculate',
        component: CreditosCalculate,
    },
    {
        path:'/logout',
        name:'creditos.logout',
        component: Logout,
        props:{redirect:'/creditos/panel'}
    },
    {
        path:'/password',
        name:'password.change',
        component: ChangePassword,
        props:{colaborador:true}
    }
];

export default routes