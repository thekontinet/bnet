@switch($service)
    @case(\App\Enums\ServiceEnum::DATA)
        @include('service.partials.fixed-price-form')
        @break
    @case(\App\Enums\ServiceEnum::AIRTIME)
        @include('service.partials.discount-price-form')
        @break
@endswitch
