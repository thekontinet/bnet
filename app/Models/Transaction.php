<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends \MannikJ\Laravel\Wallet\Models\Transaction
{
    use HasFactory;

    protected $guarded = [];

    public function description(): Attribute
    {
        return new Attribute(
            fn() => $this->meta['description'] ?? $this->type
        );
    }
}
