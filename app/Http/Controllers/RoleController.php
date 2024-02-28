<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    // TODO: Refactor this
    public function index(Request $request): JsonResponse
    {
        $date = $request->date;
        $date = Carbon::parse($date)->toDateString();

        $roles = DB::table('users')
            ->select('users.name', 'roles.name as role', 'roles.available')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('role_user.date', $date)
            ->where('users.app_del', '=', false)
            ->orderBy('users.name')
            ->get();

        return response()->json($roles);
    }
}
