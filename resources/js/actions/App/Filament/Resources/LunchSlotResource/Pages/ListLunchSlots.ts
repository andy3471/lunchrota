import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\LunchSlotResource\Pages\ListLunchSlots::__invoke
* @see app/Filament/Resources/LunchSlotResource/Pages/ListLunchSlots.php:7
* @route '/admin/lunch-slots'
*/
const ListLunchSlots = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListLunchSlots.url(options),
    method: 'get',
})

ListLunchSlots.definition = {
    methods: ["get","head"],
    url: '/admin/lunch-slots',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\LunchSlotResource\Pages\ListLunchSlots::__invoke
* @see app/Filament/Resources/LunchSlotResource/Pages/ListLunchSlots.php:7
* @route '/admin/lunch-slots'
*/
ListLunchSlots.url = (options?: RouteQueryOptions) => {
    return ListLunchSlots.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\LunchSlotResource\Pages\ListLunchSlots::__invoke
* @see app/Filament/Resources/LunchSlotResource/Pages/ListLunchSlots.php:7
* @route '/admin/lunch-slots'
*/
ListLunchSlots.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListLunchSlots.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\LunchSlotResource\Pages\ListLunchSlots::__invoke
* @see app/Filament/Resources/LunchSlotResource/Pages/ListLunchSlots.php:7
* @route '/admin/lunch-slots'
*/
ListLunchSlots.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListLunchSlots.url(options),
    method: 'head',
})

export default ListLunchSlots