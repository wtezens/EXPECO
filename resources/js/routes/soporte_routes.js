import Logout from '../components/login/AppLogout'
import ChangePassword from '../components/login/AppChangePassword'
import DashboardSoporte from '../components/soporte/dashboardSoporte'
const routes = [
    {
        path:'/',
        name:'home',
        component: DashboardSoporte,
    },
    {
        path:'/logout',
        name:'soporte.logout',
        component:Logout,
        props: {redirect:'/soporte/panel'}
    },
    {
        path:'/password',
        name:'password.change',
        component:ChangePassword,
        props:{colaborador:true}
    },
];

export default routes
