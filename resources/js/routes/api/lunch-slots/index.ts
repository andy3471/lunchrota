import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\LunchSlotController::index
* @see app/Http/Controllers/Api/LunchSlotController.php:16
* @route '/api/lunch-slots'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/lunch-slots',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\LunchSlotController::index
* @see app/Http/Controllers/Api/LunchSlotController.php:16
* @route '/api/lunch-slots'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\LunchSlotController::index
* @see app/Http/Controllers/Api/LunchSlotController.php:16
* @route '/api/lunch-slots'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\LunchSlotController::index
* @see app/Http/Controllers/Api/LunchSlotController.php:16
* @route '/api/lunch-slots'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\LunchSlotController::users
* @see app/Http/Controllers/Api/LunchSlotController.php:22
* @route '/api/lunch-slots/users'
*/
export const users = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: users.url(options),
    method: 'get',
})

users.definition = {
    methods: ["get","head"],
    url: '/api/lunch-slots/users',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\LunchSlotController::users
* @see app/Http/Controllers/Api/LunchSlotController.php:22
* @route '/api/lunch-slots/users'
*/
users.url = (options?: RouteQueryOptions) => {
    return users.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\LunchSlotController::users
* @see app/Http/Controllers/Api/LunchSlotController.php:22
* @route '/api/lunch-slots/users'
*/
users.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: users.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\LunchSlotController::users
* @see app/Http/Controllers/Api/LunchSlotController.php:22
* @route '/api/lunch-slots/users'
*/
users.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: users.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\LunchSlotController::claim
* @see app/Http/Controllers/Api/LunchSlotController.php:47
* @route '/api/lunch-slots/claim'
*/
export const claim = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: claim.url(options),
    method: 'post',
})

claim.definition = {
    methods: ["post"],
    url: '/api/lunch-slots/claim',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\LunchSlotController::claim
* @see app/Http/Controllers/Api/LunchSlotController.php:47
* @route '/api/lunch-slots/claim'
*/
claim.url = (options?: RouteQueryOptions) => {
    return claim.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\LunchSlotController::claim
* @see app/Http/Controllers/Api/LunchSlotController.php:47
* @route '/api/lunch-slots/claim'
*/
claim.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: claim.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\LunchSlotController::unClaim
* @see app/Http/Controllers/Api/LunchSlotController.php:62
* @route '/api/lunch-slots/un-claim'
*/
export const unClaim = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: unClaim.url(options),
    method: 'post',
})

unClaim.definition = {
    methods: ["post"],
    url: '/api/lunch-slots/un-claim',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\LunchSlotController::unClaim
* @see app/Http/Controllers/Api/LunchSlotController.php:62
* @route '/api/lunch-slots/un-claim'
*/
unClaim.url = (options?: RouteQueryOptions) => {
    return unClaim.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\LunchSlotController::unClaim
* @see app/Http/Controllers/Api/LunchSlotController.php:62
* @route '/api/lunch-slots/un-claim'
*/
unClaim.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: unClaim.url(options),
    method: 'post',
})

const lunchSlots = {
    index: Object.assign(index, index),
    users: Object.assign(users, users),
    claim: Object.assign(claim, claim),
    unClaim: Object.assign(unClaim, unClaim),
}

export default lunchSlots