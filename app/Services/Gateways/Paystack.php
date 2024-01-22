<?php

namespace App\Services\Gateways;

use App\Enums\Config;
use App\Exceptions\PaymentError;
use App\Services\Gateways\Contracts\Gateway;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Paystack implements Gateway
{
    private string $paystackSecretKey;

    /**
     * @throws PaymentError
     */
    public function __construct()
    {
        $this->paystackSecretKey = tenant() ?
            tenant()->settings()->get(Config::PAYSTACK_SECRET->value, '') :
            config('services.paystack.secret_key');
    }

    public function isReady():bool
    {
        return !!$this->paystackSecretKey;
    }


    public function getClient(): PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->getSecret(),
        ])->baseUrl('https://api.paystack.co/transaction');

    }


    public function createPaymentLink(int $amount, string $email, $reference, ?string $callback_url): string
    {

        try {
            $response = $this->getClient()->post('/initialize', [
                'amount' => $amount,
                'email' => $email,
                'callback_url' => $callback_url,
                'reference' => $reference,
            ]);

            if ($response->successful()) {
                return $response['data']['authorization_url'];
            } else {
                throw new \Exception("Payment link creation failed: {$response['message']}");
            }
        }catch (\Exception $e) {
            logger()->error("Payment link creation failed: {$e->getMessage()}");
            throw $e;
        }
    }

    public function verifyPayment(string $reference): bool
    {
        try {
            $response = $this->getClient()->get("/verify/{$reference}");

            if ($response->successful() && $response['data']['status'] === 'success') {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            logger()->error("Payment verification failed: {$e->getMessage()}");
            throw $e;
        }
    }

    public function verifyPaymentWebhook(Request $request): bool
    {
        try {
            $expectedSignature = hash_hmac('sha512', $request->getContent(), config('paystack.secret_key'));
            if ($expectedSignature !== $request->header('X-PAYSTACK-SIGNATURE')) {
                throw new \Exception('Invalid webhook signature');
            }

            $event = $request->input('event');
            $data = $request->input('data');

            if ($event === 'charge.success' && $data['status'] === 'success') {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            logger()->error("Webhook payment verification failed: {$e->getMessage()}");
            throw $e;
        }
    }

    public function getSecret(): string
    {
        return $this->paystackSecretKey;
    }
}
