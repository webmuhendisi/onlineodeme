<?php
namespace App\Services\PaymentGateways;

class GatewayFactory
{
    public static function make(): PaymentGatewayInterface
    {
        $driver = env('PAYMENT_GATEWAY', 'dummy');
        return match ($driver) {
            'stripe' => new StripeGateway(env('STRIPE_SECRET')),
            default => new DummyGateway(),
        };
    }
}
