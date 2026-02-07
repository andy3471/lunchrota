import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\LunchSlotResource\Pages\CreateLunchSlot::__invoke
* @see app/Filament/Resources/LunchSlotResource/Pages/CreateLunchSlot.php:7
* @route '/admin/lunch-slots/create'
*/
const CreateLunchSlot = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateLunchSlot.url(options),
    method: 'get',
})

CreateLunchSlot.definition = {
    methods: ["get","head"],
    url: '/admin/lunch-slots/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\LunchSlotResource\Pages\CreateLunchSlot::__invoke
* @see app/Filament/Resources/LunchSlotResource/Pages/CreateLunchSlot.php:7
* @route '/admin/lunch-slots/create'
*/
CreateLunchSlot.url = (options?: RouteQueryOptions) => {
    return CreateLunchSlot.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\LunchSlotResource\Pages\CreateLunchSlot::__invoke
* @see app/Filament/Resources/LunchSlotResource/Pages/CreateLunchSlot.php:7
* @route '/admin/lunch-slots/create'
*/
CreateLunchSlot.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateLunchSlot.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\LunchSlotResource\Pages\CreateLunchSlot::__invoke
* @see app/Filament/Resources/LunchSlotResource/Pages/CreateLunchSlot.php:7
* @route '/admin/lunch-slots/create'
*/
CreateLunchSlot.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateLunchSlot.url(options),
    method: 'head',
})

export default CreateLunchSlot