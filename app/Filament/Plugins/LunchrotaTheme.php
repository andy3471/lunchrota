<?php

declare(strict_types=1);

namespace App\Filament\Plugins;

use Filament\MinimalTheme;

class LunchrotaTheme extends MinimalTheme
{
    public static function getColors(): array
    {
        return [
            'primary' => '#fec107',
            'danger'  => '#d97706',
            'gray'    => '#4b5563',
            'info'    => '#3b82f6',
            'success' => '#10b981',
            'warning' => '#f97316',
        ];
    }
}
