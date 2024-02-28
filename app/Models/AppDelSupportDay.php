<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppDelSupportDay extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
