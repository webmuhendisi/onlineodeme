<?php
namespace App\Services\PaymentGateways;

use Stripe\StripeClient;

class StripeGateway implements PaymentGatewayInterface
{
    protected StripeClient $client;

    public function __construct(string $secret)
    {
        $this->client = new StripeClient($secret);
    }

    public function charge(float $amount, array $options = []): array
    {
        $payment = $this->client->paymentIntents->create([
            'amount' => intval($amount * 100),
            'currency' => $options['currency'] ?? 'try',
            'payment_method_types' => ['card'],
            'description' => $options['description'] ?? 'Online payment',
        ]);

        return [
            'status' => $payment->status,
            'transaction_id' => $payment->id,
        ];
    }
}
