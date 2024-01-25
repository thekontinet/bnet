<?php

namespace App\Models\Contracts;

interface Product
{
    public function getPrice(Customer $customer): string;

    public function getMeta(): array;

    public function canBePurchased();
}
