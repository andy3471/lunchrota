<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserLunchData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $time,
    ) {}
}
