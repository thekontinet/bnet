<?php

use App\Enums\ServiceEnum;
use App\Models\Service;
use App\Services\VirtualTopupService;
use App\Services\VtuProviders\AirtimePackageManager;
use App\Services\VtuProviders\DataPackageManager;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('package:upload', function () {
    foreach (ServiceEnum::cases() as $service){
        (new VirtualTopupService($service))->uploadPackages();
    }
})->purpose('Upload packages from service apis to DB');

Artisan::command('service:update {service}', function () {
    $serviceName = $this->argument('service');
    $serviceEnum = ServiceEnum::tryFrom($serviceName);
    $manager = match ($serviceEnum){
        ServiceEnum::AIRTIME => app(AirtimePackageManager::class),
        ServiceEnum::DATA => app(DataPackageManager::class),
        default => null
    };

    if(!$manager){
        $this->info('No manager found for this service');
    }

    $this->info("Fetching {$this->argument('service')} services.");

    $packages = $manager->packages();

    $this->info('Updating services.');

    /** @var Service $service */
    $service = Service::central($serviceEnum)->first();
    $centralPackages = $service?->getPackages();

    if($centralPackages){
        $serviceData = $manager->sync($centralPackages->toArray(), $packages->toArray());
    }else{
        $serviceData = $packages;
    }

    Service::upsertServiceData($serviceEnum, $serviceData);

    $this->info('Service update complete');
})->purpose('Upload packages from service apis to DB');
