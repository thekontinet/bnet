<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $level
 */
class Plan extends Model
{
    use HasFactory;

    const INTERVAL_DAY = 'day';
    const INTERVAL_MONTH = 'month';
    const INTERVAL_YEAR = 'year';

    public $timestamps = false;

    protected $guarded = [];

    public function getExpiryDate()
    {
        $method =  str($this->interval)
            ->ucfirst()
            ->plural()
            ->prepend('add')
            ->toString();

        return now()->$method($this->duration);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
