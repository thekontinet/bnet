<?php

namespace App\Models;

use App\Models\Contracts\Payable;
use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';

    const STATUS_SUCCESS = 'success';

    const STATUS_FAILED = 'failed';

    protected $guarded = [];

    protected $casts = [
        'amount' => MoneyIntegerCast::class
    ];

    public function scopeOnlyPending(Builder $query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public static function getPendingByReference($reference)
    {
        return self::query()
            ->onlyPending()
            ->where('status', self::STATUS_PENDING)
            ->first();
    }

    public function verify()
    {
        return $this->update(['status' => self::STATUS_SUCCESS]);
    }

    public function payable()
    {
        return $this->morphTo();
    }
}
