<?php

namespace App\Filament\Imports;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class UserRoleImporter extends Importer
{
    protected static ?string $model = RoleUser::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('User')
                ->castStateUsing(function (string $state) {
                    return User::where('name', $state)->first();
                })
                ->fillRecordUsing(function (RoleUser $roleUser, User $user) {
                    $roleUser->user_id = $user->id;
                })
                ->rules(['exists:users,name']),
            ImportColumn::make('Role')
                ->castStateUsing(function (string $state) {
                    return Role::where('name', $state)->first();
                })
                ->fillRecordUsing(function (RoleUser $roleUser, Role $role) {
                    $roleUser->role_id = $role->id;
                })
                ->rules(['exists:roles,name']),
            ImportColumn::make('Date')
                ->rules(['date']),
        ];
    }

    public function beforeSave(): void
    {
        RoleUser::all()->each->delete();
    }

    public function resolveRecord(): ?RoleUser
    {
        return new RoleUser();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your user role import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }
}
