<?php

namespace App\Models\Contracts;

use App\Enums\Config;
use Rawilk\Settings\Models\HasSettings;

trait HasTenantSettings
{
    use HasSettings;

    public function updateConfig(array $data): bool
    {
        foreach ($data as $key => $info){
            if(!config()->has('tenant.app.' . $key)){
                unset($data[$key]);
            }
        }

        $config = [...($this->config ?? []), ...$data];

        return $this->update(['config' => $config]);
    }

    public function hasPaymentMethod(): bool
    {
        $hasBankDetails = ($this->config->get(Config::BANK_ACCOUNT_NUMBER->value) &&
            $this->config->get(Config::BANK_ACCOUNT_NAME->value) &&
            $this->config->get(Config::BANK_NAME->value));

        return $this->config->get(Config::PAYSTACK_SECRET->value) || $hasBankDetails;
    }
}
