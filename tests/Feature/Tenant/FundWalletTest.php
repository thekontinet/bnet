<?php

namespace Tests\Feature\Tenant;

use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TenantTestCase;

class FundWalletTest extends TenantTestCase
{
    use RefreshDatabase;

    public function test_can_render_deposit_page()
    {
        $response = $this->login()->get(route('tenant.deposit'));
        $response->assertStatus(200);
    }

    public function test_can_be_redirected_to_payment_link()
    {
        $this->partialMock(PaymentService::class)
            ->shouldReceive('generatePaymentLink')
            ->andReturn('/fake-payment-link');
        $response = $this->login()->post(route('tenant.deposit'), [
            'amount' => '100.00'
        ]);

        $this->assertDatabaseHas(Payment::class, [
            'amount' => 10000
        ]);
        $response->assertRedirect('/fake-payment-link');
    }

    public function test_amount_must_be_in_2_decimal_places()
    {
        $response = $this->login()->post(route('tenant.deposit'), [
            'amount' => '100'
        ]);
        $response->assertSessionHasErrors('amount');
    }

    public function test_can_verify_payment()
    {
        $this->login();
        $payment = (new PaymentService)->createPayment(auth()->user(), money(1000));

        $this->partialMock(PaymentService::class)
            ->shouldReceive('checkValidity')
            ->andReturn(true);

        $response = $this->login()->get(route('tenant.deposit.verify', [
            'reference' => $payment->reference
        ]));

        $response->assertSessionHas('message');
    }

    public function test_user_can_credited_after_payment_verification(){
        $this->login();
        $payment = (new PaymentService)->createPayment(auth()->user(), money(1000));

        $this->partialMock(PaymentService::class)
            ->shouldReceive('checkValidity')
            ->andReturn(true);

        $this->login()->get(route('tenant.deposit.verify', [
            'reference' => $payment->reference
        ]));

        $payment->refresh();

        $this->assertTrue($payment->isPaid());
        $this->assertEquals($payment->payable->wallet->balance, $payment->amount);
    }

    public function test_user_cannot_be_credited_if_payment_already_settled(){
        $this->login();
        $payment = (new PaymentService)->createPayment(auth()->user(), money(1000));
        $payment->verify();

        $this->partialMock(PaymentService::class)
            ->shouldReceive('checkValidity')
            ->andReturn(true);

        $this->login()->get(route('tenant.deposit.verify', [
            'reference' => $payment->reference
        ]))->assertSessionHas('error');

        $payment->refresh();

        $this->assertEquals($payment->payable->wallet->balance, 0);
    }
}
