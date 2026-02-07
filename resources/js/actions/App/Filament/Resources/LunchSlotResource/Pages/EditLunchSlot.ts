import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\LunchSlotResource\Pages\EditLunchSlot::__invoke
* @see app/Filament/Resources/LunchSlotResource/Pages/EditLunchSlot.php:7
* @route '/admin/lunch-slots/{record}/edit'
*/
const EditLunchSlot = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditLunchSlot.url(args, options),
    method: 'get',
})

EditLunchSlot.definition = {
    methods: ["get","head"],
    url: '/admin/lunch-slots/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\LunchSlotResource\Pages\EditLunchSlot::__invoke
* @see app/Filament/Resources/LunchSlotResource/Pages/EditLunchSlot.php:7
* @route '/admin/lunch-slots/{record}/edit'
*/
EditLunchSlot.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditLunchSlot.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\LunchSlotResource\Pages\EditLunchSlot::__invoke
* @see app/Filament/Resources/LunchSlotResource/Pages/EditLunchSlot.php:7
* @route '/admin/lunch-slots/{record}/edit'
*/
EditLunchSlot.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditLunchSlot.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\LunchSlotResource\Pages\EditLunchSlot::__invoke
* @see app/Filament/Resources/LunchSlotResource/Pages/EditLunchSlot.php:7
* @route '/admin/lunch-slots/{record}/edit'
*/
EditLunchSlot.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditLunchSlot.url(args, options),
    method: 'head',
})

export default EditLunchSlot