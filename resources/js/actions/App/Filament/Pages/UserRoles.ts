import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Filament\Pages\UserRoles::__invoke
* @see app/Filament/Pages/UserRoles.php:7
* @route '/admin/user-roles'
*/
const UserRoles = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: UserRoles.url(options),
    method: 'get',
})

UserRoles.definition = {
    methods: ["get","head"],
    url: '/admin/user-roles',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Pages\UserRoles::__invoke
* @see app/Filament/Pages/UserRoles.php:7
* @route '/admin/user-roles'
*/
UserRoles.url = (options?: RouteQueryOptions) => {
    return UserRoles.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Pages\UserRoles::__invoke
* @see app/Filament/Pages/UserRoles.php:7
* @route '/admin/user-roles'
*/
UserRoles.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: UserRoles.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\UserRoles::__invoke
* @see app/Filament/Pages/UserRoles.php:7
* @route '/admin/user-roles'
*/
UserRoles.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: UserRoles.url(options),
    method: 'head',
})

export default UserRoles