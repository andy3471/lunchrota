import RoleController from './RoleController'
import LunchSlotController from './LunchSlotController'

const Api = {
    RoleController: Object.assign(RoleController, RoleController),
    LunchSlotController: Object.assign(LunchSlotController, LunchSlotController),
}

export default Api