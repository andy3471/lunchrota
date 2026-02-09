<?php

declare(strict_types=1);

namespace App\Filament\Plugins;

use Filament\MinimalTheme;

class OnLunchTheme extends MinimalTheme
{
    public static function getColors(): array
    {
        return [
            'primary' => '#6366f1',
            'danger'  => '#ef4444',
            'gray'    => '#475569',
            'info'    => '#3b82f6',
            'success' => '#10b981',
            'warning' => '#f97316',
        ];
    }
}
