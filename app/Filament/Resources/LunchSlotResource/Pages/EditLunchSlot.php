<?php

declare(strict_types=1);

namespace App\Filament\Resources\LunchSlotResource\Pages;

use App\Filament\Resources\LunchSlotResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLunchSlot extends EditRecord
{
    protected static string $resource = LunchSlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
