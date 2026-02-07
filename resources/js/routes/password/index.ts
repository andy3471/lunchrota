import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Front\UserController::change
* @see app/Http/Controllers/Front/UserController.php:16
* @route '/change-password'
*/
export const change = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: change.url(options),
    method: 'get',
})

change.definition = {
    methods: ["get","head"],
    url: '/change-password',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\UserController::change
* @see app/Http/Controllers/Front/UserController.php:16
* @route '/change-password'
*/
change.url = (options?: RouteQueryOptions) => {
    return change.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\UserController::change
* @see app/Http/Controllers/Front/UserController.php:16
* @route '/change-password'
*/
change.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: change.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\UserController::change
* @see app/Http/Controllers/Front/UserController.php:16
* @route '/change-password'
*/
change.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: change.url(options),
    method: 'head',
})

const password = {
    change: Object.assign(change, change),
}

export default password