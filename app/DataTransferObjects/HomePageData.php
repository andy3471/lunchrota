<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class HomePageData extends Data
{
    public function __construct(
        #[DataCollectionOf(LunchSlotData::class)]
        public DataCollection $lunchSlots,
        public ?int $initialSlot,
        public bool $available,
        #[DataCollectionOf(UserLunchData::class)]
        public DataCollection $userLunches,
        #[DataCollectionOf(RoleData::class)]
        public DataCollection $roles,
        public string $selectedDate,
    ) {}
}
