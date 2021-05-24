<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DailyPassword extends Model
{
    protected $appends = [
        'code',
    ];

    public function getCodeAttribute()
    {
        $epoch = Carbon::createMidnightDate(1967, 12, 31, 'Europe/London');
        $date = Carbon::parse($this->date);
        $dsp = $epoch->diffInDays($date);
        $dsp = strrev($dsp);
        return $dsp;
    }

    public function dspToday() {
        Return Cache::remember('dsp', 600, function () {
            $today = Carbon::now()->toDateString();
            return DailyPassword::where('date', $today)->get();
        });
    }


}
