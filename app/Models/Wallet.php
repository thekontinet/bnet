<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends \MannikJ\Laravel\Wallet\Models\Wallet
{
    use HasFactory;

    protected $guarded = [];
}
