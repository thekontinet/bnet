<?php

namespace App\Services\VtuProviders;

use App\Enums\ErrorCode;
use App\Enums\ServiceEnum;
use App\Models\Customer;
use App\Models\Package;
use App\Services\VtuProviders\Contracts\PackageManager;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPUnit\TextUI\XmlConfiguration\Exception;

class DataPackageManager implements PackageManager
{
    private $client;

    const PROVIDER_MTN = 'mtn';
    const PROVIDER_GLO = 'glo';
    const PROVIDER_Airtel = 'airtel';
    const PROVIDER_9Mobile = '9mobile';

    public string $endpoint = 'https://www.airtimenigeria.com/api/v1/data/plans';

    public function __construct()
    {
        $this->client = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.airtimenigeria.api_key'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->baseUrl($this->endpoint);
    }
    public function getPackages(): array
    {
        $response = $this->client->get('/data/plans');

        if($response->successful()){
            return $this->formatResponseData($response->json('data'));
        }

        return [];
    }

    private function formatResponseData(array $array)
    {
        $packagesArray = [];

        foreach ($array as $data){
            $packagesArray[] = [
                'uuid' => Str::uuid(),
                'service' => ServiceEnum::DATA,
                'provider' => $data['network_operator'],
                'title' => $data['plan_summary'],
                'description' => '',
                'price_type' => Package::PRICE_TYPE_FIXED,
                'price' => $data['regular_price'] * 100,
                'discount' => 0,
                'data' => [
                    'package_code' => $data['package_code']
                ]
            ];
        }

        return $packagesArray;
    }

    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'max:14'],
            'customer_reference' => ['nullable', 'string']
        ];
    }

    public function procesDelivery(Package $package, array $params): array
    {
        try {
            $data = Validator::make($params, $this->rules())->validated();

            $response = $this->client->post('/data', [
                ...$data,
                'package_code' => $package->code
            ])->throw();

            if ($response->ok() && ($response->json('status') === 'success')) return $response->json();

            throw new Exception('Data purchase failed: ' . $response->json('message'), ErrorCode::DELIVERY_FAILED);
        } catch (HttpClientException $exception) {
            logger()->error('Data purchase failed: ' . $exception->getMessage());
            throw new Exception('Data purchase failed: ' . "something went wrong. Try again later", ErrorCode::DELIVERY_FAILED);
        } catch (\Exception $exception) {
            throw new Exception('Data purchase failed: ' . $exception->getMessage(), ErrorCode::DELIVERY_FAILED);
        }
    }
}
