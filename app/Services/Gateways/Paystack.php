<?php

namespace App\Services\Gateways;

use App\Services\Gateways\Contracts\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Paystack implements Gateway
{
    private string $paystackSecretKey;

    public function __construct(string $secret)
    {
        $this->paystackSecretKey = $secret;
    }

    public function createPaymentLink(int $amount, string $email, $reference, ?string $callback_url): string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->paystackSecretKey,
            ])->post('https://api.paystack.co/transaction/initialize', [
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
        } catch (\Exception $e) {
            logger()->error("Payment link creation failed: {$e->getMessage()}");
            throw $e;
        }
    }

    public function verifyPayment(string $reference): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->paystackSecretKey,
            ])->get("https://api.paystack.co/transaction/verify/{$reference}");

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
}
