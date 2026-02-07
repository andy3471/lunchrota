<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use App\Models\RoleUser;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class RoleData extends Data
{
    public function __construct(
        public string $name,
        public string $role,
        public int $available,
    ) {}

    public static function fromRoleUser(RoleUser $roleUser): self
    {
        return self::from([
            'name'      => $roleUser->user->name,
            'role'      => $roleUser->role->name,
            'available' => $roleUser->role->available,
        ]);
    }

    public static function from(mixed ...$payloads): static
    {
        if (count($payloads) === 1 && $payloads[0] instanceof RoleUser) {
            return self::fromRoleUser($payloads[0]);
        }

        return parent::from(...$payloads);
    }
}
