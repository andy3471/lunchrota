<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RolesClear extends Command
{
    protected $signature = 'roles:clear';

    protected $description = 'Clear roles more than 3 weeks old';

    public function handle(): void
    {
        $date = Carbon::now()->addWeeks(-3);
        DB::table('role_user')->where('date', '<', $date)->delete();
        $this->line('Deleted roles older than '.$date);
    }
}
