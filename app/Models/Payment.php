<?php

namespace App\Models;

use App\Models\Contracts\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property Customer|Organization $payable
 */
class Payment extends Model
{
    use HasFactory;

    const StatusPending = 'pending';

    const StatusPaid = 'paid';

    const StatusFailed = 'failed';

    protected $guarded = [];

    protected $casts = [
        'amount' => 'integer'
    ];

    public function scopeOnlyPending(Builder $query): Builder
    {
        return $query->where('status', self::StatusPending);
    }

    public function isPaid(): bool
    {
        return $this->status === self::StatusPaid;
    }

    public function verify(): bool
    {
        return $this->update(['status' => self::StatusPaid]);
    }

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

    public function transactionReference(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'reference');
    }
}
