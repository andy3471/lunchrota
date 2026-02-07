import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Front\UserController::show
* @see app/Http/Controllers/Front/UserController.php:16
* @route '/change-password'
*/
export const show = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/change-password',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\UserController::show
* @see app/Http/Controllers/Front/UserController.php:16
* @route '/change-password'
*/
show.url = (options?: RouteQueryOptions) => {
    return show.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\UserController::show
* @see app/Http/Controllers/Front/UserController.php:16
* @route '/change-password'
*/
show.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\UserController::show
* @see app/Http/Controllers/Front/UserController.php:16
* @route '/change-password'
*/
show.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Front\UserController::changePassword
* @see app/Http/Controllers/Front/UserController.php:21
* @route '/change-password'
*/
export const changePassword = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: changePassword.url(options),
    method: 'post',
})

changePassword.definition = {
    methods: ["post"],
    url: '/change-password',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Front\UserController::changePassword
* @see app/Http/Controllers/Front/UserController.php:21
* @route '/change-password'
*/
changePassword.url = (options?: RouteQueryOptions) => {
    return changePassword.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\UserController::changePassword
* @see app/Http/Controllers/Front/UserController.php:21
* @route '/change-password'
*/
changePassword.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: changePassword.url(options),
    method: 'post',
})

const UserController = { show, changePassword }

export default UserController