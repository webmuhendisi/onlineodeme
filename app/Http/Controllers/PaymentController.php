<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Debt;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Debt $debt)
    {
        $payment = Payment::create([
            'student_id' => $debt->student_id,
            'debt_id' => $debt->id,
            'amount_paid' => $debt->amount,
            'transaction_id' => uniqid('trx_'),
            'payment_gateway' => env('PAYMENT_GATEWAY', 'dummy'),
            'status' => 'success',
            'paid_at' => now()
        ]);

        $debt->update(['is_paid' => true]);

        $invoice = Invoice::create([
            'payment_id' => $payment->id,
            'invoice_no' => uniqid('INV-'),
            'pdf_path' => 'storage/invoices/'.uniqid().'.pdf'
        ]);

        return redirect()->route('invoices.show', $invoice)->with('status', 'Payment successful');
    }
}
