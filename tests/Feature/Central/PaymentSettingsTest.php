<?php

namespace Tests\Feature\Central;

use App\Enums\Config;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_payment_settings_form(): void
    {
        $this->login()->withDomain();
        $response = $this->get(route('settings.edit', 'payment'));

        $response->assertStatus(200);
    }

    public function test_can_update_payment_settings()
    {
        $this->login()->withDomain();
        $response = $this->post(route('settings.update', 'payment'), [
            Config::BANK_ACCOUNT_NAME->value => 'Test Bank Account',
            Config::BANK_NAME->value => 'Test Bank',
            Config::BANK_ACCOUNT_NUMBER->value => '0000000000',
            Config::BANK_PAYMENT_INFO->value => 'test description',
        ]);

        $response->assertSessionHas('message');
        $this->assertEquals($this->tenant->settings()->get(Config::BANK_NAME), 'Test Bank');
        $this->assertEquals($this->tenant->settings()->get(Config::BANK_ACCOUNT_NAME), 'Test Bank Account');
        $this->assertEquals($this->tenant->settings()->get(Config::BANK_ACCOUNT_NUMBER), '0000000000');
        $this->assertEquals($this->tenant->settings()->get(Config::BANK_PAYMENT_INFO), 'test description');
    }
}
