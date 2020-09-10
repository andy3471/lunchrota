p

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\User;
use App\Role;
use Illuminate\Support\Facades\DB;

class RolesGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Roles';

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
        //Get Default role from .env file

        if (config('app.default_role') == 'none') {
            $this->line('No default role set');
            return;
        }

        $defaultRole = Role::where('name', config('app.default_role'))->first();
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addWeek();
        $dateRange = CarbonPeriod::create($startDate, $endDate);

        if ($defaultRole) {
            $this->line('The Default Role is ' . $defaultRole->name);
        } else {
            $this->error('The default role in the .env file does not match the name of a role');
            return;
        }

        foreach ($dateRange as $date) {
            if ($date->isWeekday()) {
                $this->line($date);
                $dateString = Carbon::parse($date)->toDateString();

                $usersWithRoles = DB::table('role_user')
                        ->select('user_id')
                        ->where('date', $dateString)
                        ->get();

                $usersWithRoles = json_decode(json_encode($usersWithRoles), true);

                $users = User::whereNotIn('id', $usersWithRoles)->get();
                
                foreach ($users as $user) {
                    if ($user->scheduled) {
                        $user->roles()->attach($defaultRole, ['date' => $dateString]);
                        $this->line($user->name .' Given Role Of '. $defaultRole->name . ' For ' . $dateString);
                    } else {
                        $this->line($user->name .' is not a scheduled user');
                    }
                };
            } else {
                $this->line($date . ' Is Weekend');
            }
        };

        
    }
}