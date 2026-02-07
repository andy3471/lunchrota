import lunchSlots from './lunch-slots'
import roles from './roles'
import users from './users'

const resources = {
    lunchSlots: Object.assign(lunchSlots, lunchSlots),
    roles: Object.assign(roles, roles),
    users: Object.assign(users, users),
}

export default resources