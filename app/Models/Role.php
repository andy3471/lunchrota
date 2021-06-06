<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    /**
     * @param $date
     * @return \Illuminate\Support\Collection
     */
    public static function getUserRolesByDate($date) {
        return DB::table('users')
            ->select('users.name', 'roles.name as role', 'roles.available')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('role_user.date', $date)
            ->where('users.app_del', '=', false)
            ->orderBy('users.name')
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withPivot('date');
    }

    /**
     * @param $value
     * @return bool
     */
    public function getAvailableAttribute($value) {
        return ($value == 0) ? false : true;
    }
}
