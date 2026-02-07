import Front from './Front'
import Auth from './Auth'
import Api from './Api'
import AdminApi from './AdminApi'

const Controllers = {
    Front: Object.assign(Front, Front),
    Auth: Object.assign(Auth, Auth),
    Api: Object.assign(Api, Api),
    AdminApi: Object.assign(AdminApi, AdminApi),
}

export default Controllers