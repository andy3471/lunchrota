<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppDelSupportDay extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
