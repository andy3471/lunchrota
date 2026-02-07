import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/admin',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Pages\UserRoles::__invoke
* @see app/Filament/Pages/UserRoles.php:7
* @route '/admin/user-roles'
*/
export const userRoles = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: userRoles.url(options),
    method: 'get',
})

userRoles.definition = {
    methods: ["get","head"],
    url: '/admin/user-roles',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Pages\UserRoles::__invoke
* @see app/Filament/Pages/UserRoles.php:7
* @route '/admin/user-roles'
*/
userRoles.url = (options?: RouteQueryOptions) => {
    return userRoles.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Pages\UserRoles::__invoke
* @see app/Filament/Pages/UserRoles.php:7
* @route '/admin/user-roles'
*/
userRoles.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: userRoles.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\UserRoles::__invoke
* @see app/Filament/Pages/UserRoles.php:7
* @route '/admin/user-roles'
*/
userRoles.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: userRoles.url(options),
    method: 'head',
})

const pages = {
    dashboard: Object.assign(dashboard, dashboard),
    userRoles: Object.assign(userRoles, userRoles),
}

export default pages