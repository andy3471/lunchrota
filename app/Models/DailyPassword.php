<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DailyPassword extends Model
{
    protected $appends = [
        'code'
    ];

    public function getCodeAttribute()
    {
        $epoch = Carbon::createMidnightDate(1967, 12, 31, 'Europe/London');
        $date = Carbon::parse($this->date);
        $dsp = $epoch->diffInDays($date);
        $dsp = strrev($dsp);
        return $dsp;
    }
}
