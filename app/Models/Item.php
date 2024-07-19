<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property Service $product
 * @property array $attr
 * @property string $reference
 * @property StatusEnum $status
 * @property Order $order
 * @property int $platform_amount
 * @property int $customer_amount
 */
class Item extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'attr' => 'array',
        'status' => StatusEnum::class
    ];

    public function updateStatus(StatusEnum $status, ?string $message = null): bool
    {
        $status = $this->update([
            'status' => $status,
            'message' => $message ?? $this->message
        ]);

        $this->order->updateStatus();

        return $status;
    }

    public function reference(): Attribute
    {
        return new Attribute(
            fn() => $this->id
        );
    }

    public function product(): MorphTo
    {
        return $this->morphTo();
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
