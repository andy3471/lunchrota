import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Filament\Resources\RoleResource\Pages\ListRoles::__invoke
* @see app/Filament/Resources/RoleResource/Pages/ListRoles.php:7
* @route '/admin/roles'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/roles',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\RoleResource\Pages\ListRoles::__invoke
* @see app/Filament/Resources/RoleResource/Pages/ListRoles.php:7
* @route '/admin/roles'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\RoleResource\Pages\ListRoles::__invoke
* @see app/Filament/Resources/RoleResource/Pages/ListRoles.php:7
* @route '/admin/roles'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\RoleResource\Pages\ListRoles::__invoke
* @see app/Filament/Resources/RoleResource/Pages/ListRoles.php:7
* @route '/admin/roles'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\RoleResource\Pages\CreateRole::__invoke
* @see app/Filament/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/admin/roles/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/admin/roles/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\RoleResource\Pages\CreateRole::__invoke
* @see app/Filament/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/admin/roles/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\RoleResource\Pages\CreateRole::__invoke
* @see app/Filament/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/admin/roles/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\RoleResource\Pages\CreateRole::__invoke
* @see app/Filament/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/admin/roles/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\RoleResource\Pages\EditRole::__invoke
* @see app/Filament/Resources/RoleResource/Pages/EditRole.php:7
* @route '/admin/roles/{record}/edit'
*/
export const edit = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/roles/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\RoleResource\Pages\EditRole::__invoke
* @see app/Filament/Resources/RoleResource/Pages/EditRole.php:7
* @route '/admin/roles/{record}/edit'
*/
edit.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { record: args }
    }

    if (Array.isArray(args)) {
        args = {
            record: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        record: args.record,
    }

    return edit.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\RoleResource\Pages\EditRole::__invoke
* @see app/Filament/Resources/RoleResource/Pages/EditRole.php:7
* @route '/admin/roles/{record}/edit'
*/
edit.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\RoleResource\Pages\EditRole::__invoke
* @see app/Filament/Resources/RoleResource/Pages/EditRole.php:7
* @route '/admin/roles/{record}/edit'
*/
edit.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

const roles = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    edit: Object.assign(edit, edit),
}

export default roles