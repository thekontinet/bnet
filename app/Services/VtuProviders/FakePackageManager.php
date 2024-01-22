<?php

namespace App\Services\VtuProviders;

use App\Enums\ErrorCode;
use App\Enums\ServiceEnum;
use App\Models\Customer;
use App\Models\Package;
use App\Services\VtuProviders\Contracts\PackageManager;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use PHPUnit\TextUI\XmlConfiguration\Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FakePackageManager implements  PackageManager
{
    public function getPackages(): array
    {
       return [];
    }

    public function rules(): array
    {
        return [];
    }

    public function procesDelivery(Package $package, array $params): array
    {
        return [];
    }
}
