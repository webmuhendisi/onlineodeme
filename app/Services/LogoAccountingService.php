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
            'installment_no' => $payment->installment_no,
            'invoice_no' => $payment->invoice->invoice_no ?? null,
        ];

        $client = Http::withBasicAuth(env('LOGO_CLIENT_ID'), env('LOGO_CLIENT_SECRET'));
        $client->post($url . '/payments', $payload);

        if ($payment->invoice) {
            $client->post($url . '/invoices', [
                'payment_id' => $payment->id,
                'invoice_no' => $payment->invoice->invoice_no,
                'amount' => $payment->amount_paid,
            ]);
        }
    }
}

