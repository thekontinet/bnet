<?php

namespace App\Services\VtuProviders;

use App\Models\Package;
use App\Services\VtuProviders\Contracts\PackageManager;

class FakePackageManager implements  PackageManager
{
    public function fetchPackages(): array
    {
       return [];
    }

    public function rules(): array
    {
        return [];
    }

    public function sendOrder(Package $package, array $params): array
    {
        return [];
    }
}
