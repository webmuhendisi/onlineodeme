<?php
namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;

class LogoAccountingService
{
    public function sendPayment(Payment $payment): void
    {
        $url = env('LOGO_API_URL');
        if (!$url) {
            return;
        }
        $payload = [
            'payment_id' => $payment->id,
            'amount' => $payment->amount_paid,
            'student_id' => $payment->student_id,
            'transaction_id' => $payment->transaction_id,
            'invoice_no' => $payment->invoice->invoice_no ?? null,
        ];
        Http::withBasicAuth(env('LOGO_CLIENT_ID'), env('LOGO_CLIENT_SECRET'))
            ->post($url . '/payments', $payload);
    }
}

