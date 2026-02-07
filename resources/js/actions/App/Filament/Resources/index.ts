import LunchSlotResource from './LunchSlotResource'
import RoleResource from './RoleResource'
import UserResource from './UserResource'

const Resources = {
    LunchSlotResource: Object.assign(LunchSlotResource, LunchSlotResource),
    RoleResource: Object.assign(RoleResource, RoleResource),
    UserResource: Object.assign(UserResource, UserResource),
}

export default Resources