import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\RoleResource\Pages\CreateRole::__invoke
* @see app/Filament/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/admin/roles/create'
*/
const CreateRole = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateRole.url(options),
    method: 'get',
})

CreateRole.definition = {
    methods: ["get","head"],
    url: '/admin/roles/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\RoleResource\Pages\CreateRole::__invoke
* @see app/Filament/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/admin/roles/create'
*/
CreateRole.url = (options?: RouteQueryOptions) => {
    return CreateRole.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\RoleResource\Pages\CreateRole::__invoke
* @see app/Filament/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/admin/roles/create'
*/
CreateRole.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateRole.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\RoleResource\Pages\CreateRole::__invoke
* @see app/Filament/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/admin/roles/create'
*/
CreateRole.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateRole.url(options),
    method: 'head',
})

export default CreateRole