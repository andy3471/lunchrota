<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withPivot('date');
    }

    public function getAvailableAttribute($value) {
        if ($value == 0) {
            return false;
        } else {
            return true;
        }
    }
}
