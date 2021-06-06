<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function getUserRolesByDate(Request $request)
    {
        $date = Carbon::parse($request->date)->toDateString();
        return Role::getUserRolesByDate($date);
    }
}
