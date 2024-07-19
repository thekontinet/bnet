<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

/**
 * @property \App\Models\Contracts\Customer $customer
 * @property array $data
 * @property mixed $reference
 * @property Organization $organization
 * @property Collection<Item> $items
 */
class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['items.product'];

    protected $casts = [
        'attr' => 'array',
        'status' => StatusEnum::class
    ];

    public function description(): Attribute
    {
        return new Attribute(
            fn() => ucfirst($this->items->first()?->product->name) . ' Purchase'
        );
    }

    public function getTotal()
    {
        return $this->items->sum('customer_amount');
    }

    public function getPlatformTotal()
    {
        return $this->items->sum('platform_amount');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function customer(): MorphTo
    {
        return $this->morphTo();
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'reference');
    }

    public function updateStatus(?StatusEnum $status = null)
    {
        if($status) {
            $this->update(['status' => $status]);
            if($status === StatusEnum::FAILED){
                $this->items()->update(['status' => StatusEnum::FAILED]);
            };
            return true;
        }

        $this->refresh();
        $deliveredCount = $this->items->where('status', StatusEnum::DELIVERED)->count();
        $pendingCount = $this->items->where('status', StatusEnum::PENDING)->count();
        $totalCount = $this->items->count();

        if($totalCount === 1){
            return $this->update(['status' => $this->items->first()->status]);
        }

        if ($pendingCount === $totalCount) {
            return $this->update(['status' => StatusEnum::PENDING]);
        }

        if ($deliveredCount === $totalCount) {
            return $this->update(['status' => StatusEnum::DELIVERED]);
        }

        if ($deliveredCount > 1) {
            return $this->update(['status' => StatusEnum::PARTIALLY_DELIVERED]);
        }

        return $this->update(['status' => StatusEnum::FAILED]);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
