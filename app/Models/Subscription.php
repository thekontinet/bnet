<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    public function hasExpired(): bool
    {
        return $this->plan?->expires_at?->isPast() ?? false;
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
