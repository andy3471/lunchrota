<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class DailyPassword extends Model
{
    protected $appends = [
        'code',
    ];

    public function code(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $epoch = Carbon::createMidnightDate(1967, 12, 31, 'Europe/London');
                $date = Carbon::parse($this->date);
                $dsp = $epoch->diffInDays($date);
                $dsp = strrev($dsp);

                return $dsp;
            }
        );
    }
}
