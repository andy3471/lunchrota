import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Front\LunchSlotController::claim
* @see app/Http/Controllers/Front/LunchSlotController.php:18
* @route '/lunch-slots/claim'
*/
export const claim = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: claim.url(options),
    method: 'post',
})

claim.definition = {
    methods: ["post"],
    url: '/lunch-slots/claim',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Front\LunchSlotController::claim
* @see app/Http/Controllers/Front/LunchSlotController.php:18
* @route '/lunch-slots/claim'
*/
claim.url = (options?: RouteQueryOptions) => {
    return claim.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\LunchSlotController::claim
* @see app/Http/Controllers/Front/LunchSlotController.php:18
* @route '/lunch-slots/claim'
*/
claim.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: claim.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Front\LunchSlotController::unclaim
* @see app/Http/Controllers/Front/LunchSlotController.php:33
* @route '/lunch-slots/unclaim'
*/
export const unclaim = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: unclaim.url(options),
    method: 'post',
})

unclaim.definition = {
    methods: ["post"],
    url: '/lunch-slots/unclaim',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Front\LunchSlotController::unclaim
* @see app/Http/Controllers/Front/LunchSlotController.php:33
* @route '/lunch-slots/unclaim'
*/
unclaim.url = (options?: RouteQueryOptions) => {
    return unclaim.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\LunchSlotController::unclaim
* @see app/Http/Controllers/Front/LunchSlotController.php:33
* @route '/lunch-slots/unclaim'
*/
unclaim.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: unclaim.url(options),
    method: 'post',
})

const lunchSlots = {
    claim: Object.assign(claim, claim),
    unclaim: Object.assign(unclaim, unclaim),
}

export default lunchSlots