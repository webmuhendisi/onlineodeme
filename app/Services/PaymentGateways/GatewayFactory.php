<?php
namespace App\Services\PaymentGateways;

use App\Services\PaymentGateways\IsbankGateway;
use App\Services\PaymentGateways\StripeGateway;
use App\Services\PaymentGateways\DummyGateway;
use App\Services\PaymentGateways\PaymentGatewayInterface;

class GatewayFactory
{
    public static function make(): PaymentGatewayInterface
    {
        $driver = env('PAYMENT_GATEWAY', 'dummy');
        return match ($driver) {
            'stripe' => new StripeGateway(env('STRIPE_SECRET')),
            'isbank' => new IsbankGateway(
                env('ISBANK_API_URL'),
                env('ISBANK_CLIENT_ID'),
                env('ISBANK_CLIENT_SECRET')
            ),
            default => new DummyGateway(),
        };
    }
}
