<?php

namespace App\Services\VtuProviders;

use App\DataObjects\DataPlanPackageData;
use App\Enums\ServiceEnum;
use App\Enums\StatusEnum;
use App\Exceptions\ServicePurchaseError;
use App\Models\Item;
use App\Services\VtuProviders\Contracts\PackageManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class DataPackageManager implements PackageManager
{
    const PROVIDER_MTN = 'mtn';
    const PROVIDER_GLO = 'glo';
    const PROVIDER_Airtel = 'airtel';
    const PROVIDER_9Mobile = '9mobile';
    public string $endpoint = 'https://www.airtimenigeria.com/api/v1';
    private $client;

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
            'package_code' => $item->attr['package_code'],
            'phone' => $item->attr['phone'],
            'max_amount' => $item->customer_amount,
            'customer_reference' => $item->reference,
            'callback_url' => route('tenant.order.check', $item)
        ];

        logger()->info('Sending data order', $data);

        $response = app(static::class)->client->post('/data', $data);

        if(!$response->successful()){
            logger()->error('Data purchase failed: ' . $response->json('message'), $data);
            throw new ServicePurchaseError('Data purchase failed');
        }

        logger()->info('sent airtime order');

        $item->updateStatus(StatusEnum::DELIVERING, $response->json('message'));
    }

    public function fetchPackages(): array
    {
        $response = $this->client->get('/data/plans');

        if($response->successful()){
            return $this->formatResponseData($response->json('data'));
        }

        return [];
    }

    private function formatResponseData(array $array): Collection
    {
        $packages = collect();

        foreach ($array as  $data){
            $packages->put($data['package_code'], DataPlanPackageData::fromArray([
                'id' => $data['package_code'],
                'name' => $data['plan_summary'],
                'service' => ServiceEnum::DATA->value,
                'provider' => $data['network_operator'],
                'validity' => $data['validity'],
                'description' => '',
                'currency' => $data['currency'],
                'main_price' => $data['regular_price'] * 100,
                'price' => $data['regular_price'] * 100,
            ]));
        }

        return $packages;
    }

    public function packages(): Collection
    {
        $response = $this->client->get('/data/plans');

        if($response->successful()){
            return $this->formatResponseData($response->json('data'));
        }

        return collect();
    }

    public function sync(array $centralPackages, array $packages, bool $exceptPrice = true): array
    {
        return array_map(function($package) use ($centralPackages, $exceptPrice){
            $package_array = $package->toArray();

            if($exceptPrice && !empty($centralPackages)){
                $package_array['price'] = $centralPackages[$package_array['id']]['price'];
            }

            return $package_array;
        }, $packages);
    }
}
