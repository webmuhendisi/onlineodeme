<?php
namespace App\Services\PaymentGateways;

use GuzzleHttp\Client;

class IsbankGateway implements PaymentGatewayInterface
{
    protected Client $client;

    public function __construct(string $baseUrl, string $clientId, string $clientSecret)
    {
        $this->client = new Client([
            'base_uri' => $baseUrl,
            'auth' => [$clientId, $clientSecret]
        ]);
    }

    public function charge(float $amount, array $options = []): array
    {
        $response = $this->client->post('/payments', [
            'json' => [
                'amount' => $amount,
                'currency' => $options['currency'] ?? 'TRY',
                'description' => $options['description'] ?? 'Online payment'
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        return [
            'status' => $data['status'] ?? 'failed',
            'transaction_id' => $data['transaction_id'] ?? null,
        ];
    }
}
