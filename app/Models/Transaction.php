<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends \MannikJ\Laravel\Wallet\Models\Transaction
{
    use HasFactory;

    protected $guarded = [];
}
