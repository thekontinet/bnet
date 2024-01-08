<?php

namespace App\Services\Gateways\Contracts;

interface Gateway
{
    public function createPaymentLink(int $amount, string $email, $reference, ?string $callback_url): string;

    public function verifyPayment(string $reference): bool;
}
