<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RolesClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear roles more than 3 weeks old';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = Carbon::now()->addWeek(-3);
        DB::table('role_user')->where('date', '<', $date)->delete();
        DB::table('app_del_support_days')->where('date', '<', $date)->delete();
        $this->line('Deleted roles older than '.$date);
    }
}
