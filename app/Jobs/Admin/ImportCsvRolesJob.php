<?php

namespace App\Jobs\Admin;

use App\Http\Requests\Admin\ImportCsvRolesRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportCsvRolesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ImportCsvRolesRequest
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ImportCsvRolesRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = $this->request->file('csv')->storeAs('/csv', 'commrotaupload.csv');
        $file = Storage::url($path);

        $file = fopen(base_path().'/storage/app/csv/commrotaupload.csv', 'r');
        while (! feof($file)) {
            $content[] = fgetcsv($file);
        }
        fclose($file);

        $messages = collect();

        $count = count($content);

        for ($i = 1; $i < $count - 1; $i++) {
            if ($content[$i][0]) {
                $user = User::where('name', $content[$i][0])->first();

                $date = Carbon::createFromFormat('d/m/Y', $content[$i][1])->toDateString();
                $role = Role::where('name', $content[$i][2])->first();

                $user->roles()->wherePivot('date', $date)->detach();

                if (! $user) {
                    $messages->push(['message' => 'User '.$content[$i][0].' does not exist', 'type' => 'danger']);
                } elseif (! $role) {
                    $messages->push(['message' => 'Role '.$content[$i][2].' does not exist', 'type' => 'danger']);
                } elseif (! $date) {
                    $messages->push(['message' => 'Date '.$content[$i][1].' is not valid', 'type' => 'danger']);
                } else {
                    $user->roles()->attach($role, ['date' => $date]);
                    $messages->push(['message' => 'Added Role of '.$role->name.' for user '.$user->name.' on '.$date, 'type' => 'success']);
                }
            }
        }

        return $messages;
    }
}
