<?php

declare(strict_types=1);

namespace App\Jobs\Admin;

use App\Http\Requests\Admin\UpdateUsersRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateUsersJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    // TODO: Move to filament
    // TODO: Never pass the request

    public function __construct(
        public UpdateUsersRequest $request
    ) {}

    // TODO: Tidy this
    public function handle(): void
    {
        $users = collect($this->request->users);

        foreach ($users as $u) {
            $user = User::withTrashed()->where('id', $u['id'])->first();

            if ($u['deleted'] && ! $user->is_deleted) {
                $user->delete();
            } elseif (! $u['deleted'] && $user->is_deleted) {
                $user->restore();
            }

            if (! $u['new_password'] === '') {
                $user->password = bcrypt($u['new_password']);
            }

            $user->name      = $u['name'];
            $user->email     = $u['email'];
            $user->admin     = $u['admin'];
            $user->scheduled = $u['scheduled'];
            $user->save();
        }

    }
}
