<?php

declare(strict_types=1);

namespace App\Filament\Resources\LunchSlotResource\Pages;

use App\Filament\Resources\LunchSlotResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLunchSlots extends ListRecords
{
    protected static string $resource = LunchSlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
