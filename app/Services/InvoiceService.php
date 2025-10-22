<?php
namespace App\Services;

use Dompdf\Dompdf;
use App\Models\Payment;

class InvoiceService
{
    public function generate(Payment $payment): string
    {
        $dompdf = new Dompdf();
        $html = view('invoices.show', ['invoice' => $payment->invoice])->render();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $fileName = 'storage/invoices/' . uniqid('inv_') . '.pdf';
        file_put_contents($fileName, $dompdf->output());
        return $fileName;
    }
}
