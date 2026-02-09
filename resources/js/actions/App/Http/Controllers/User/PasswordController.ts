import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\User\PasswordController::show
* @see app/Http/Controllers/User/PasswordController.php
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
* @see \App\Http\Controllers\User\PasswordController::show
* @see app/Http/Controllers/User/PasswordController.php
* @route '/change-password'
*/
show.url = (options?: RouteQueryOptions) => {
    return show.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\PasswordController::show
* @see app/Http/Controllers/User/PasswordController.php
* @route '/change-password'
*/
show.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\User\PasswordController::show
* @see app/Http/Controllers/User/PasswordController.php
* @route '/change-password'
*/
show.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\User\PasswordController::update
* @see app/Http/Controllers/User/PasswordController.php
* @route '/change-password'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/change-password',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\User\PasswordController::update
* @see app/Http/Controllers/User/PasswordController.php
* @route '/change-password'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\PasswordController::update
* @see app/Http/Controllers/User/PasswordController.php
* @route '/change-password'
*/
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

const PasswordController = { show, update }

export default PasswordController
