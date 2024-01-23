<?php

namespace App\Services\VtuProviders;

use App\Enums\ErrorCode;
use App\Enums\ServiceEnum;
use App\Models\Customer;
use App\Models\Package;
use App\Services\VtuProviders\Contracts\PackageManager;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Client\RequestException;
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
                'discount' => 2
            ],
            [
                'uuid' => Str::uuid(),
                'service' => ServiceEnum::AIRTIME,
                'provider' => self::PROVIDER_Airtel,
                'title' => str(self::PROVIDER_Airtel)->ucfirst()->append(' ', 'Airtime'),
                'description' => '',
                'price_type' => Package::PRICE_TYPE_DISCOUNT,
                'price' => 0,
                'discount' => 2
            ],
            [
                'uuid' => Str::uuid(),
                'service' => ServiceEnum::AIRTIME,
                'provider' => self::PROVIDER_GLO,
                'title' => str(self::PROVIDER_GLO)->ucfirst()->append(' ', 'Airtime'),
                'description' => '',
                'price_type' => Package::PRICE_TYPE_DISCOUNT,
                'price' => 0,
                'discount' => 2
            ],
            [
                'uuid' => Str::uuid(),
                'service' => ServiceEnum::AIRTIME,
                'provider' => self::PROVIDER_9Mobile,
                'title' => str(self::PROVIDER_9Mobile)->ucfirst()->append(' ', 'Airtime'),
                'description' => '',
                'price_type' => Package::PRICE_TYPE_DISCOUNT,
                'price' => 0,
                'discount' => 2
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

    /**
     * @throws \Exception
     */
    public function handleDelivery(Package $package, array $params): array
    {
        $data = Validator::make($params, $this->rules(), [
            'amount.min' => "Min amount required is " . money(50.00)
        ])->validated();

        $data['network_operator'] = $package->provider;

        try{
            $response = $this->client->post('/airtime', $data)->throw();

            if (($response->json('status') !== 'success'))
                throw new \Exception($response->json('message'));

            return $response->json();
        }catch (\Exception $exception){
            logger()->error('Airtime purchase failed: ' . $exception->getMessage());
            throw new Exception('Airtime purchase failed: ' . "Airtime recharge failed to deliver", ErrorCode::DELIVERY_FAILED);
        }
    }
}
