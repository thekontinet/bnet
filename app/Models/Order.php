<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';

    const STATUS_DELIVERED = 'delivered';

    const STATUS_PAID = 'paid';

    const STATUS_FAILED = 'failed';

    protected $guarded = [];

    protected $casts = [
        'data' => 'array'
    ];

    public function isDelivered()
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    public function isPaid()
    {
        return $this->status === self::STATUS_PAID;
    }

    public function markAsDelivered()
    {
        return $this->update(['status' => self::STATUS_DELIVERED]);
    }

    public function owner()
    {
        return $this->morphTo();
    }

    public function item()
    {
        return $this->morphTo();
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'reference');
    }
}
