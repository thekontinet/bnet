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

class AirtimePackageManager implements  PackageManager
{
    private $client;

    const PROVIDER_MTN = 'mtn';
    const PROVIDER_GLO = 'glo';
    const PROVIDER_Airtel = 'airtel';
    const PROVIDER_9Mobile = '9mobile';
    private $endpoint = 'https://www.airtimenigeria.com/api/v1/';

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
        return [
            [
                'uuid' => Str::uuid(),
                'service' => ServiceEnum::AIRTIME,
                'provider' => self::PROVIDER_MTN,
                'title' => str(self::PROVIDER_MTN)->ucfirst()->append(' ', 'Airtime'),
                'description' => '',
                'price_type' => Package::PRICE_TYPE_DISCOUNT,
                'price' => 0,
                'discount' => 1
            ],
            [
                'uuid' => Str::uuid(),
                'service' => ServiceEnum::AIRTIME,
                'provider' => self::PROVIDER_Airtel,
                'title' => str(self::PROVIDER_Airtel)->ucfirst()->append(' ', 'Airtime'),
                'description' => '',
                'price_type' => Package::PRICE_TYPE_DISCOUNT,
                'price' => 0,
                'discount' => 1
            ],
            [
                'uuid' => Str::uuid(),
                'service' => ServiceEnum::AIRTIME,
                'provider' => self::PROVIDER_GLO,
                'title' => str(self::PROVIDER_GLO)->ucfirst()->append(' ', 'Airtime'),
                'description' => '',
                'price_type' => Package::PRICE_TYPE_DISCOUNT,
                'price' => 0,
                'discount' => 1
            ],
            [
                'uuid' => Str::uuid(),
                'service' => ServiceEnum::AIRTIME,
                'provider' => self::PROVIDER_9Mobile,
                'title' => str(self::PROVIDER_9Mobile)->ucfirst()->append(' ', 'Airtime'),
                'description' => '',
                'price_type' => Package::PRICE_TYPE_DISCOUNT,
                'price' => 0,
                'discount' => 1
            ]
        ];
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'decimal:2', 'money', 'min:50'],
            'phone' => ['required', 'string', 'max:14'],
            'customer_reference' => ['nullable', 'string']
        ];
    }

    public function procesDelivery(Package $package, array $params): array
    {
        try{
            $data = Validator::make($params, $this->rules(), [
                'amount.min' => "Min amount required is " . money(50.00)
            ])->validated();

            $data['network_operator'] = $package->provider;

            $response = $this->client->post('/airtime', $data)->throw();

            if($response->ok() && ($response->json('status') === 'success')) return $response->json();
            throw new Exception('Airtime purchase failed: ' . $response->json('message'), ErrorCode::DELIVERY_FAILED);
        }catch (HttpClientException $exception){
            logger()->error('Airtime purchase failed: ' . $exception->getMessage());
            throw new Exception('Airtime purchase failed: ' . "something went wrong. Try again later", ErrorCode::DELIVERY_FAILED);
        }catch (\Exception $exception){
            throw new Exception('Airtime purchase failed: ' . $exception->getMessage(), ErrorCode::DELIVERY_FAILED);
        }
    }
}
