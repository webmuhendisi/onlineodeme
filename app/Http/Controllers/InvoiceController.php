<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {
        if (file_exists(base_path($invoice->pdf_path))) {
            return response()->file(base_path($invoice->pdf_path));
        }

        return view('invoices.show', compact('invoice'));
    }

    public function generate(Payment $payment)
    {
        // Deprecated by PaymentController::store
        return redirect()->route('invoices.show', $payment->invoice);
    }
}
