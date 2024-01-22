<?php

namespace Tests\Feature\Tenant;

use App\Enums\Config;
use App\Models\Payment;
use App\Services\Gateways\Contracts\Gateway;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TenantTestCase;
use Tests\TestCase;

class FundWalletTest extends TenantTestCase
{
    use RefreshDatabase;

    public function test_can_use_the_correct_key(): void
    {
        $this->login()->get(route('tenant.deposit'));

        $this->assertEquals(app(Gateway::class)->getSecret(), tenant()->settings()->get(Config::PAYSTACK_SECRET->value));
    }

    public function test_render_deposit_page(): void
    {

        $response = $this->login()->get(route('tenant.deposit'));

        $response->assertStatus(200);
    }

    public function test_can_redirect_to_payment_link()
    {
        Http::fake();

        $this->partialMock(Gateway::class, function($mock){
            $mock->shouldReceive('createPaymentLink')
                ->andReturn('/fake-payment-link');
            $mock->shouldReceive('isReady')
                ->andReturn(true);
        });


        $repsonse = $this->login()->post(route('tenant.deposit'), [
            'amount' => '100.00'
        ]);

        $repsonse->assertStatus(302);
        $repsonse->assertRedirect('/fake-payment-link');
    }

    public function test_can_verify_payment_reference()
    {
        $this->login();
        $payment = Payment::factory()->for(auth()->user(), 'payable')->create();

        $this->partialMock(Gateway::class, function($mock){
            $mock->shouldReceive('verifyPayment')
                ->andReturn(true);
            $mock->shouldReceive('isReady')
                ->andReturn(true);
        });

        $this->get(route('tenant.deposit.verify', ['reference' => $payment->reference]))
            ->assertRedirect(route('tenant.dashboard'))
            ->assertSessionHas('message');
    }

    public function test_can_credit_customer_after_payment_verification()
    {
        $this->login();
        $payment = Payment::factory()->for(auth()->user(), 'payable')->create();

        $this->partialMock(Gateway::class, function($mock){
            $mock->shouldReceive('verifyPayment')
                ->andReturn(true);
            $mock->shouldReceive('isReady')
                ->andReturn(true);
        });


        $this->get(route('tenant.deposit.verify', ['reference' => $payment->reference]));

        $this->assertEquals(auth()->user()->wallet->balance, $payment->amount->getAmount());
    }
}
