import Logout from '../components/login/AppLogout'
import ChangePassword from '../components/login/AppChangePassword'
import dashboardSoporte from '../components/soporte/dashboardSoporte'
import AppNewUsuario from '../components/soporte/AppNewUsuario'
import AppShowUsuario from '../components/soporte/AppShowUsuario'
import AppNewNotario from '../components/soporte/AppNewNotario'
import AppNewReporte from   '../components/soporte/AppNewReporte'

const routes = [
    {
        path:'/',
        name:'home',
        component: dashboardSoporte,
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
    {
        path:'/usuario/new',
        name:'usuario.new',
        component:AppNewUsuario,
        props:{New:true}
    },
    {
        path:'/usuario/show',
        name:'usuario.show',
        component:AppShowUsuario,
    },

    {
        path:'/notario/new',
        name:'notario.new',
        component:AppNewNotario,
    },
    {
        path:'/reporte/nuevo',
        name:'reporte.new',
        component:AppNewReporte,
    }
];

export default routes
