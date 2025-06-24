<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {
        // In real project, return PDF download
        return view('invoices.show', compact('invoice'));
    }

    public function generate(Payment $payment)
    {
        // Placeholder for PDF generation
        $invoice = Invoice::create([
            'payment_id' => $payment->id,
            'invoice_no' => uniqid('INV-'),
            'pdf_path' => 'storage/invoices/'.uniqid().'.pdf'
        ]);

        return redirect()->route('invoices.show', $invoice);
    }
}
