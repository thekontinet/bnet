<?php

namespace App\Models\Contracts;

use App\Enums\Config;
use Illuminate\Http\Request;
use Rawilk\Settings\Models\HasSettings;

trait HasTenantSettings
{
    use HasSettings;
    public function haveAtleastOnePaymentMethod(): bool
    {
        return $this->settings()->get(Config::PAYSTACK_SECRET->value) ||
            ($this->settings()->get(Config::BANK_ACCOUNT_NUMBER->value) &&
                $this->settings()->get(Config::BANK_ACCOUNT_NAME->value) &&
                $this->settings()->get(Config::BANK_NAME->value));
    }

    public function completeApplicationSettings(): bool
    {
        return $this->brand_name && $this->brand_description && $this->logo;
    }
}
