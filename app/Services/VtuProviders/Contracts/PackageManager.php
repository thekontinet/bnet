<?php

namespace App\Services\VtuProviders\Contracts;

use App\Models\Customer;
use App\Models\Package;
use Illuminate\Http\Request;

interface PackageManager
{
    public function getPackages(): array;

    public function rules(): array;

    public function handleDelivery(Package $package, array $params): array;
}
