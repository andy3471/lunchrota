<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('date');
    }

    public function getAvailableAttribute($value) {
        if ($value == 0) {
            return false;
        } else {
            return true;
        }
    }
}
