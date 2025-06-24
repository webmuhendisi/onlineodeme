<?php
namespace App\Services\PaymentGateways;

class DummyGateway implements PaymentGatewayInterface
{
    public function charge(float $amount, array $options = []): array
    {
        return [
            'status' => 'success',
            'transaction_id' => uniqid('dummy_'),
        ];
    }
}
