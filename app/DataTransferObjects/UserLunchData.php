<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use App\Models\LunchSlot;
use App\Models\User;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserLunchData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public string $time,
    ) {}

    public static function fromUserAndSlot(User $user, LunchSlot $slot): self
    {
        return self::from([
            'id'   => $user->id,
            'name' => $user->name,
            'time' => $slot->time,
        ]);
    }

    public static function fromUser(User $user): self
    {
        return self::from([
            'id'   => $user->id,
            'name' => $user->name,
            'time' => $user->lunches->first()?->time ?? '',
        ]);
    }

    public static function from(mixed ...$payloads): static
    {
        if (count($payloads) === 1 && $payloads[0] instanceof User) {
            return self::fromUser($payloads[0]);
        }

        return parent::from(...$payloads);
    }
}
