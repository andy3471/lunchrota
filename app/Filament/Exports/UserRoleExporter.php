<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use App\Models\RoleUser;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class UserRoleExporter extends Exporter
{
    protected static ?string $model = RoleUser::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('user.name')
                ->label('User'),
            ExportColumn::make('role.name')
                ->label('Role'),
            ExportColumn::make('date'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your user role export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
