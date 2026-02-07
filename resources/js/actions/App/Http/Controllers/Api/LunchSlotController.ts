import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\LunchSlotController::getSlots
* @see app/Http/Controllers/Api/LunchSlotController.php:16
* @route '/api/lunch-slots'
*/
export const getSlots = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getSlots.url(options),
    method: 'get',
})

getSlots.definition = {
    methods: ["get","head"],
    url: '/api/lunch-slots',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\LunchSlotController::getSlots
* @see app/Http/Controllers/Api/LunchSlotController.php:16
* @route '/api/lunch-slots'
*/
getSlots.url = (options?: RouteQueryOptions) => {
    return getSlots.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\LunchSlotController::getSlots
* @see app/Http/Controllers/Api/LunchSlotController.php:16
* @route '/api/lunch-slots'
*/
getSlots.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getSlots.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\LunchSlotController::getSlots
* @see app/Http/Controllers/Api/LunchSlotController.php:16
* @route '/api/lunch-slots'
*/
getSlots.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getSlots.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\LunchSlotController::userLunches
* @see app/Http/Controllers/Api/LunchSlotController.php:22
* @route '/api/lunch-slots/users'
*/
export const userLunches = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: userLunches.url(options),
    method: 'get',
})

userLunches.definition = {
    methods: ["get","head"],
    url: '/api/lunch-slots/users',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\LunchSlotController::userLunches
* @see app/Http/Controllers/Api/LunchSlotController.php:22
* @route '/api/lunch-slots/users'
*/
userLunches.url = (options?: RouteQueryOptions) => {
    return userLunches.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\LunchSlotController::userLunches
* @see app/Http/Controllers/Api/LunchSlotController.php:22
* @route '/api/lunch-slots/users'
*/
userLunches.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: userLunches.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\LunchSlotController::userLunches
* @see app/Http/Controllers/Api/LunchSlotController.php:22
* @route '/api/lunch-slots/users'
*/
userLunches.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: userLunches.url(options),
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
* @see \App\Http\Controllers\Api\LunchSlotController::unclaim
* @see app/Http/Controllers/Api/LunchSlotController.php:62
* @route '/api/lunch-slots/un-claim'
*/
export const unclaim = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: unclaim.url(options),
    method: 'post',
})

unclaim.definition = {
    methods: ["post"],
    url: '/api/lunch-slots/un-claim',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\LunchSlotController::unclaim
* @see app/Http/Controllers/Api/LunchSlotController.php:62
* @route '/api/lunch-slots/un-claim'
*/
unclaim.url = (options?: RouteQueryOptions) => {
    return unclaim.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\LunchSlotController::unclaim
* @see app/Http/Controllers/Api/LunchSlotController.php:62
* @route '/api/lunch-slots/un-claim'
*/
unclaim.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: unclaim.url(options),
    method: 'post',
})

const LunchSlotController = { getSlots, userLunches, claim, unclaim }

export default LunchSlotController