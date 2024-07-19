<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Carbon $expires_at;
 */
class Subscription extends Model
{
    use HasFactory;

    const EXPIRY_THRESHOLD = 7;

    protected $guarded = [];

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    protected $with = ['plan'];

    public function isOnGracePeriod(): bool
    {
       return $this->expired()
           && $this->expires_at->lessThan(now()->addDays(7));
    }

    public function expired(): bool
    {
        return $this->expires_at->lessThan(now());
    }

    public function expiring(): bool
    {
        $daysBeforeExpiration = 7;
        return $this->expires_at->lessThanOrEqualTo(now()->addDays($daysBeforeExpiration));
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
