<?php
namespace App\Services\PaymentGateways;

interface PaymentGatewayInterface
{
    /**
     * Charge the given amount and return transaction details.
     *
     * @param float $amount
     * @param array $options
     * @return array
     */
    public function charge(float $amount, array $options = []): array;
}
