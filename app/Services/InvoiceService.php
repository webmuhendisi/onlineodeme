<?php
namespace App\Services;

use Dompdf\Dompdf;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;

class InvoiceService
{
    public function generate(Payment $payment): string
    {
        $dompdf = new Dompdf();
        $html = view('invoices.show', ['invoice' => $payment->invoice])->render();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $path = 'invoices/' . uniqid('inv_') . '.pdf';
        Storage::put($path, $dompdf->output());
        return $path;
    }
}
