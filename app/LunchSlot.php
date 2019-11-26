<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LunchSlot extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('date');
    }
}
