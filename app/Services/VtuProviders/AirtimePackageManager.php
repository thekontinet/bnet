<?php

namespace App\Services\VtuProviders;

use App\DataObjects\AirtimePackageData;
use App\Enums\ServiceEnum;
use App\Enums\StatusEnum;
use App\Exceptions\ServicePurchaseError;
use App\Models\Item;
use App\Models\Package;
use App\Services\VtuProviders\Contracts\PackageManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AirtimePackageManager implements  PackageManager
{
    const PROVIDER_MTN = 'mtn';
    const PROVIDER_GLO = 'glo';
    const PROVIDER_Airtel = 'airtel';
    const PROVIDER_9Mobile = '9mobile';
    private $client;
    private $endpoint = 'https://www.airtimenigeria.com/api/v1/';

    public function __construct()
    {
        $this->client = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.airtimenigeria.api_key'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->baseUrl($this->endpoint);
    }

    /**
     * @throws ServicePurchaseError
     */
    public static function deliverPurchase(Item $item): void
    {
        $data = [
            'network_operator' => $item->attr['provider'],
            'amount' => $item->attr['amount'],
            'phone' => $item->attr['phone'],
            'customer_reference' => $item->reference,
            'callback_url' => route('tenant.order.check', $item)
        ];

        logger()->info('Sending airtime order', $data);

        $response = app(static::class)->client->post('/airtime', $data);

        if(!$response->successful()){
            logger()->error('Airtime purchase failed: ' . $response->json('message'), $data);
            throw new ServicePurchaseError('Airtime purchase failed');
        }

        logger()->info('sent airtime order');

        $item->updateStatus(StatusEnum::DELIVERING, $response->json('message'));
    }

    /**
     * @return Collection<AirtimePackageData>
     */
    public function packages(): Collection
    {
        return collect($this->fetchPackages())
            ->reduce(function ($carry, $data, $key) {
                $data['id'] = $key;
                $data['name'] = $data['title'];
                $data['main_discount'] = $data['discount'];
                $carry[$data['id']] = AirtimePackageData::fromArray($data);
                return $carry;
            }, collect());
    }

    public function fetchPackages(): array
    {
        return [
            [
                'uuid' => Str::uuid(),
                'image' => '/images/logos/mtn-logo.png',
                'service' => ServiceEnum::AIRTIME->value,
                'provider' => self::PROVIDER_MTN,
                'title' => str(self::PROVIDER_MTN)->ucfirst()->append(' ', 'Airtime'),
                'description' => '',
                'price_type' => Package::PRICE_TYPE_DISCOUNT,
                'price' => 0,
                'discount' => 2
            ],
            [
                'uuid' => Str::uuid(),
                'image' => '/images/logos/airtel-logo.png',
                'service' => ServiceEnum::AIRTIME->value,
                'provider' => self::PROVIDER_Airtel,
                'title' => str(self::PROVIDER_Airtel)->ucfirst()->append(' ', 'Airtime'),
                'description' => '',
                'price_type' => Package::PRICE_TYPE_DISCOUNT,
                'price' => 0,
                'discount' => 2
            ],
            [
                'uuid' => Str::uuid(),
                'image' => '/images/logos/glo-logo.png',
                'service' => ServiceEnum::AIRTIME->value,
                'provider' => self::PROVIDER_GLO,
                'title' => str(self::PROVIDER_GLO)->ucfirst()->append(' ', 'Airtime'),
                'description' => '',
                'price_type' => Package::PRICE_TYPE_DISCOUNT,
                'price' => 0,
                'discount' => 2
            ],
            [
                'uuid' => Str::uuid(),
                'image' => '/images/logos/9mobile-logo.png',
                'service' => ServiceEnum::AIRTIME->value,
                'provider' => self::PROVIDER_9Mobile,
                'title' => str(self::PROVIDER_9Mobile)->ucfirst()->append(' ', 'Airtime'),
                'description' => '',
                'price_type' => Package::PRICE_TYPE_DISCOUNT,
                'price' => 0,
                'discount' => 2
            ]
        ];
    }

    public function sync(array $centralPackages, array $packages, bool $exceptPrice = true): array
    {
        return array_map(function($package) use ($centralPackages, $exceptPrice){
            $package_array = $package->toArray();
            $centralPackage_array = $centralPackages[$package_array['id']]->toArray();


            if($exceptPrice && !empty($centralPackages)){
                $package_array['discount'] = $centralPackage_array['discount'];
            }

            return $package_array;
        }, $packages);
    }
}
