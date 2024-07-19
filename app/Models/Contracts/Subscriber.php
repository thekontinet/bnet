<?php

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\HasOne;

interface Subscriber
{
    public function subscription(): HasOne;

    public function refresh();
}
