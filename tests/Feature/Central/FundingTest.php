<?php

namespace Tests\Feature\Central;

use App\Models\Payment;
use App\Models\Tenant;
use App\Services\Gateways\Paystack;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\Mock;
use Tests\TestCase;

class FundingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_funding_page(): void
    {
        $tenant = Tenant::factory()->create();
        $response = $this->actingAs($tenant)->get(route('deposit.create'));

        $response->assertStatus(200);
    }

    public function test_can_create_payment_link_and_redirect_to_make_payment(): void
    {
        $this->partialMock(PaymentService::class, function($mock){
            $mock->shouldReceive('createPaymentLink')->andReturn('/fake-payment-link');
        });

        $tenant = Tenant::factory()->create();

        $response = $this->actingAs($tenant)->post(route('deposit.pay', [
            'amount' => '100.00'
        ]));

        $response->assertRedirect('/fake-payment-link');
        $this->assertDatabaseHas(Payment::class, [
            'amount' => 10000,
            'status' => Payment::STATUS_PENDING
        ]);
    }

    public function test_wallet_funded_if_payment_confirmation_is_successful()
    {
        $this->partialMock(PaymentService::class, function($mock){
            $mock->shouldReceive('verifyPayment')->andReturn(true);
        });

        $tenant = Tenant::factory()->create();
        $payment = $tenant->initializePayment(money(100.00));

        $response = $this->actingAs($tenant)->get(route('deposit.confirm', [
            'reference' => $payment->reference
        ]));

        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas(Payment::class, [
            'amount' => 10000,
            'status' => Payment::STATUS_SUCCESS
        ]);

        $this->assertEquals($tenant->wallet->balance, 10000);
    }

    public function test_wallet_not_funded_if_payment_confirmation_is_fails()
    {
        $this->partialMock(PaymentService::class, function($mock){
            $mock->shouldReceive('verifyPayment')->andReturn(false);
        });

        $tenant = Tenant::factory()->create();
        $payment = $tenant->initializePayment(money(100.00));

        $response = $this->actingAs($tenant)->get(route('deposit.confirm', [
            'reference' => $payment->reference
        ]));


        $this->assertEquals($tenant->wallet->balance, 0);
    }
}
