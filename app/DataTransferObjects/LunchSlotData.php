<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use App\Models\LunchSlot;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class LunchSlotData extends Data
{
    public function __construct(
        public string $id,
        public string $time,
        public int|float $available_slots,
    ) {}

    public static function fromLunchSlot(LunchSlot $lunchSlot, string $date): self
    {
        return self::from([
            'id'              => $lunchSlot->id,
            'time'            => $lunchSlot->time,
            'available_slots' => $lunchSlot->getAvailableForDate($date),
        ]);
    }

    public static function collectForDate($items, string $date)
    {
        return self::collect(
            collect($items)->map(fn ($slot) => self::fromLunchSlot($slot, $date))
        );
    }
}
