<?php

namespace App\Models;

use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    const INTERVAL_DAY = 'day';
    const INTERVAL_MONTH = 'month';
    const INTERVAL_YEAR = 'year';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'price' => MoneyIntegerCast::class
    ];

    public function getExpiryDate()
    {
        $method =  str($this->interval)
            ->ucfirst()
            ->plural()
            ->prepend('add')
            ->toString();

        return now()->$method($this->duration);
    }
}
