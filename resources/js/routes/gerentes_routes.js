import DashboardGerentes from '../components/gerentes/dashboardGerentes';
import AnticiposCreate from '../components/gerentes/AppAnticipoCreate'
import AnticipoList from '../components/gerentes/AppListAnticipos'
import Logout from '../components/login/AppLogout'
import ChangePassword from '../components/login/AppFormChangePassword'


const routes = [
    {
        path:'/',
        name:'home',
        component: DashboardGerentes
    },
    {
        path:'/logout',
        name:'gerentes.logout',
        component: Logout,
        props: {redirect:'/gerentes/panel'}
    },
    {
        path:'/password',
        name:'password.change',
        component: ChangePassword,
        props:{colaborador:true}
    },
    {
        path:'/anticipo/create',
        name:'anticipo.create',
        component: AnticiposCreate,
    },
    {
        path:'/anticipo/show',
        name:'anticipo.show',
        component: AnticipoList,
    }
];

export default routes