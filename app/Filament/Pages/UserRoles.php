<?php

namespace App\Filament\Pages;

use App\Filament\Exports\UserRoleExporter;
use App\Filament\Imports\UserRoleImporter;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

class UserRoles extends Page
{
    public array $userRoles = [];

    public string $date;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.user-roles';

    protected static ?string $navigationGroup = 'Users';

    public function getHeaderActions(): array
    {
        return [
            ExportAction::make('export')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query
                        ->where('date', '>', now()->startOfDay())
                        ->with('user', 'role');
                })
                ->exporter(UserRoleExporter::class)
                ->columnMapping(false),
            ImportAction::make('import')
                ->importer(UserRoleImporter::class),
        ];
    }

    public function mount(): void
    {
        $this->date = now()->startOfDay()->format('Y-m-d');
        $this->getUserRoles();
    }

    #[Computed]
    protected function users(): Collection
    {
        return User::all();
    }

    #[Computed]
    protected function roles(): Collection
    {
        return Role::all();
    }

    public function updatedDate($date): void
    {
        $this->date = Carbon::parse($date)->startOfDay()->format('Y-m-d');
        $this->getUserRoles();
    }

    public function updateUserRole($userId): void
    {
        $roleId = $this->userRoles[$userId];

        $user = User::find($userId);
        $user->roles()->wherePivot('date', $this->date)->detach();

        if ($roleId === 'none') {
            Notification::make()->title('User Role Updated')->success()->send();

            return;
        }

        $user->roles()->attach($roleId, ['date' => $this->date]);

        Notification::make()->title('User Role Updated')->success()->send();
    }

    public function getUserRoles(): void
    {
        $this->userRoles = [];

        foreach ($this->users as $user) {
            $this->userRoles[$user->id] = $user->roles()->wherePivot('date', $this->date)->first()?->id ?: 'none';
        }
    }
}
