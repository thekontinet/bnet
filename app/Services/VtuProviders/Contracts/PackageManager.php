<?php

namespace App\Services\VtuProviders\Contracts;

use App\Models\Item;
use Illuminate\Support\Collection;

interface PackageManager
{
    public static function deliverPurchase(Item $item): void;

    /**
     * @return Collection
     */
    public function packages(): Collection;

    public function sync(array $centralPackages, array $packages, bool $exceptPrice = true): array;
}
