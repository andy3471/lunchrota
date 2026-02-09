<?php

declare(strict_types=1);

namespace App\Filament\Plugins;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Colors\Color;

class OnLunchTheme implements Plugin
{
    public static function make(): static
    {
        return new static;
    }

    public function getId(): string
    {
        return 'on-lunch-theme';
    }

    public function register(Panel $panel): void
    {
        $panel->colors([
            'primary' => Color::Indigo,
            'danger'  => Color::Red,
            'gray'    => Color::Slate,
            'info'    => Color::Blue,
            'success' => Color::Emerald,
            'warning' => Color::Orange,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
