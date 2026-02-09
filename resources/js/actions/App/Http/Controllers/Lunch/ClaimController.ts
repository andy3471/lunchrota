import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Lunch\ClaimController::store
* @see app/Http/Controllers/Lunch/ClaimController.php
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
* @see \App\Http\Controllers\Lunch\ClaimController::store
* @see app/Http/Controllers/Lunch/ClaimController.php
* @route '/lunch-slots/claim'
*/
claim.url = (options?: RouteQueryOptions) => {
    return claim.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Lunch\ClaimController::store
* @see app/Http/Controllers/Lunch/ClaimController.php
* @route '/lunch-slots/claim'
*/
claim.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: claim.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Lunch\ClaimController::destroy
* @see app/Http/Controllers/Lunch/ClaimController.php
* @route '/lunch-slots/claim'
*/
export const unclaim = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: unclaim.url(options),
    method: 'delete',
})

unclaim.definition = {
    methods: ["delete"],
    url: '/lunch-slots/claim',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Lunch\ClaimController::destroy
* @see app/Http/Controllers/Lunch/ClaimController.php
* @route '/lunch-slots/claim'
*/
unclaim.url = (options?: RouteQueryOptions) => {
    return unclaim.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Lunch\ClaimController::destroy
* @see app/Http/Controllers/Lunch/ClaimController.php
* @route '/lunch-slots/claim'
*/
unclaim.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: unclaim.url(options),
    method: 'delete',
})

const ClaimController = { claim, unclaim }

export default ClaimController
