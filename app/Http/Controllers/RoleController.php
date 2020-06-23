<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = $request->date;
        $date = Carbon::parse($date)->toDateString();

        $roles = DB::table('users')
            ->select('users.name', 'roles.name as role', 'roles.available')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('role_user.date', $date)
            ->orderBy('users.name')
            ->get();

        return $roles;
    }

    public function get(Request $request)
    {
        $date = Carbon::parse($request->date)->toDateString();
        $roles = User::find($request->user_id)->roles()->wherePivot('date', $date)->get();

        if ($roles->isEmpty()) {
            return 'None';
        } else {
            return $roles[0]->name;
        }
    }

    public function post(Request $request)
    {
        $date = Carbon::parse($request->date)->toDateString();

        $user = User::find($request->user_id);

        $user->roles()->wherePivot('date', $date)->detach();

        if ($request->role == 0) {
            return 'None';
        } else {
            $user->roles()->attach($request->role, ['date' => $date]);
            $role = Role::find($request->role);
            return $role->name;
        }
    }

    public function roleAdmin()
    {
        return view('admin.roles.index');
    }

    public function roleAdminGetRoles()
    {
        return Role::orderBy('name')->get();
    }

    public function roleAdminUpdateRoles(Request $request)
    {
        $this->validate($request, [
            'roles.*.name' => 'required|string',
            'roles.*.available'    => 'required|boolean',
        ]);

        $roles = collect($request->roles);
        $deletedRoles = Role::whereNotIn('id', $roles->where('id', '!=', null)->pluck('id')->toArray())->get();

        foreach ($deletedRoles as $role) {
            $role->users()->detach();
            $role->delete();
        };

        foreach ($roles as $r) {
            if ($r['id'] == 0) {
                $role = new Role;
                $role->name = $r['name'];
            } else {
                $role = Role::find($r['id']);
            }

            $role->available = $r['available'];
            $role->save();
        }

        return Role::orderBy('name')->get();
    }

    public function userRolesAdmin()
    {
        $users = User::all();
        $roles = Role::orderBy('name')->get();
        return view('admin.userroles.index')->withUsers($users)->withRoles($roles);
    }

    public function userRolesUpload()
    {
        return view('admin.userroles.upload');
    }

    public function downloadCsv()
    {
        $filename = "commrotaexport.csv";

        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=galleries.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];

        $date = Carbon::yesterday();

        if (config('database.default') == 'mysql') {
            $roles = DB::table('users')
                ->select('users.name', DB::raw('DATE_FORMAT(role_user.date,"%d/%m/%Y") as date'), 'roles.name as role')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('date', '>', $date )
                ->orderBy('role_user.date')
                ->get();
        } else {
            $roles = DB::table('users')
                ->select('users.name', DB::raw("FORMAT(role_user.date, 'd', 'en-gb') as date"), 'roles.name as role')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('date', '>', $date )
                ->orderBy('role_user.date')
                ->get();
        }

        $roles = json_decode(json_encode($roles), true);

        if (count($roles) > 0) {
            array_unshift($roles, array_keys($roles[0]));

            $callback = function () use ($roles) {
                $FH = fopen('php://output', 'w');
                foreach ($roles as $row) {
                    fputcsv($FH, $row);
                }
                fclose($FH);
            };
        } else {
            $callback = function () {
                $FH = fopen('php://output', 'w');

                fputcsv($FH, array('name', 'date', 'role'));
                fclose($FH);
            };
        }

        return response()->streamDownload($callback, $filename, $headers);
    }

    public function uploadCsv(Request $request)
    {
        $this->validate($request, [
            'csv' => 'required|file',
        ]);

        $path = $request->file('csv')->storeAs('/csv', 'commrotaupload.csv');
        $file = Storage::url($path);

        $file = fopen(base_path() . '/storage/app/csv/commrotaupload.csv', 'r');
        while (!feof($file)) {
            $content[] = fgetcsv($file);
        }
        fclose($file);

        $messages = collect();

        $count =  count($content);

        for ($i = 1; $i < $count - 1; $i++) {
            if ($content[$i][0]){
                $user = User::where('name', $content[$i][0])->first();

                $date = Carbon::createFromFormat('d/m/Y', $content[$i][1])->toDateString();
                $role = Role::where('name', $content[$i][2])->first();

                $user->roles()->wherePivot('date', $date)->detach();

                if (!$user) {
                    $messages->push(['message' => "User " . $content[$i][0] . " does not exist", 'type' => 'danger']);
                } else if (!$role) {
                    $messages->push(['message' => "Role " . $content[$i][2] . " does not exist", 'type' => 'danger']);
                } else if (!$date) {
                    $messages->push(['message' => "Date " . $content[$i][1] . " is not valid", 'type' => 'danger']);
                } else {
                    $user->roles()->attach($role, ['date' => $date]);
                    $messages->push(['message' => "Added Role of " . $role->name . " for user " . $user->name . " on " . $date, 'type' => 'success']);
                }
            }
        };

        //return $messages->all();
        return view('admin.userroles.confirmupload')->withMessages($messages->all());
    }
}
