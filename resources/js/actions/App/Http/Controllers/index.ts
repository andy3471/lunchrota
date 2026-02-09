import Auth from './Auth'
import HomeController from './HomeController'
import ClaimController from './Lunch/ClaimController'
import PasswordController from './User/PasswordController'

const Controllers = {
    Auth: Object.assign(Auth, Auth),
    HomeController: Object.assign(HomeController, HomeController),
    Lunch: {
        ClaimController: Object.assign(ClaimController, ClaimController),
    },
    User: {
        PasswordController: Object.assign(PasswordController, PasswordController),
    },
}

export default Controllers