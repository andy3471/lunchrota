<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class HomePageData extends Data
{
    /**
     * @param array<int, LunchSlotData> $lunchSlots
     * @param array<int, UserLunchData> $userLunches
     * @param array<int, RoleData> $roles
     */
    public function __construct(
        public array $lunchSlots,
        public ?int $initialSlot,
        public bool $available,
        public array $userLunches,
        public array $roles,
        public string $selectedDate,
    ) {}
}
