import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\AdminApi\RoleController::index
* @see [unknown]:0
* @route '/api/admin/user-roles'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/admin/user-roles',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AdminApi\RoleController::index
* @see [unknown]:0
* @route '/api/admin/user-roles'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminApi\RoleController::index
* @see [unknown]:0
* @route '/api/admin/user-roles'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AdminApi\RoleController::index
* @see [unknown]:0
* @route '/api/admin/user-roles'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AdminApi\RoleController::update
* @see [unknown]:0
* @route '/api/admin/user-roles'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/api/admin/user-roles',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AdminApi\RoleController::update
* @see [unknown]:0
* @route '/api/admin/user-roles'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminApi\RoleController::update
* @see [unknown]:0
* @route '/api/admin/user-roles'
*/
update.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

const userRoles = {
    index: Object.assign(index, index),
    update: Object.assign(update, update),
}

export default userRoles