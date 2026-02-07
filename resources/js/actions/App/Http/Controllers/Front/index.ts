import HomeController from './HomeController'
import UserController from './UserController'
import LunchSlotController from './LunchSlotController'
import RoleController from './RoleController'

const Front = {
    HomeController: Object.assign(HomeController, HomeController),
    UserController: Object.assign(UserController, UserController),
    LunchSlotController: Object.assign(LunchSlotController, LunchSlotController),
    RoleController: Object.assign(RoleController, RoleController),
}

export default Front