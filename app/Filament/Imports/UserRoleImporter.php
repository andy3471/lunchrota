<?php

declare(strict_types=1);

namespace App\Filament\Imports;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Facades\Filament;

class UserRoleImporter extends Importer
{
    protected static ?string $model = RoleUser::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('User')
                ->castStateUsing(function (string $state) {
                    $tenant = Filament::getTenant();

                    return $tenant->members()->where('name', $state)->first();
                })
                ->fillRecordUsing(function (RoleUser $roleUser, User $user): void {
                    $roleUser->user_id = $user->id;
                })
                ->rules(['exists:users,name']),
            ImportColumn::make('Role')
                ->castStateUsing(function (string $state) {
                    $tenant = Filament::getTenant();

                    return $tenant->roles()->where('name', $state)->first();
                })
                ->fillRecordUsing(function (RoleUser $roleUser, Role $role): void {
                    $roleUser->role_id = $role->id;
                })
                ->rules(['exists:roles,name']),
            ImportColumn::make('Date')
                ->rules(['date']),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your user role import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }

    public function beforeSave(): void
    {
        $tenant = Filament::getTenant();

        RoleUser::query()
            ->whereHas('role', fn ($q) => $q->where('team_id', $tenant->id))
            ->delete();
    }

    public function resolveRecord(): ?RoleUser
    {
        return new RoleUser;
    }
}
