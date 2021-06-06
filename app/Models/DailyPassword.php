<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class DailyPassword extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $appends = [
        'code',
    ];

    /**
     * @return mixed
     */
    public static function dspToday() {
        Return Cache::remember('dsp', 600, function () {
            $today = Carbon::now()->toDateString();
            return DailyPassword::where('date', $today)->first();
        });
    }

    /**
     * @return string
     */
    public function getCodeAttribute()
    {
        $epoch = Carbon::createMidnightDate(1967, 12, 31, 'Europe/London');
        $date = Carbon::parse($this->date);
        $dsp = $epoch->diffInDays($date);
        $dsp = strrev($dsp);
        return $dsp;
    }
}
