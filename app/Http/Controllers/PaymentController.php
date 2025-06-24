<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Debt;
use App\Models\Invoice;
use App\Services\PaymentGateways\GatewayFactory;
use App\Services\InvoiceService;
use App\Services\LogoAccountingService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Debt $debt)
    {
        $gateway = GatewayFactory::make();
        $result = $gateway->charge($debt->amount, [
            'description' => 'Debt #' . $debt->id,
        ]);

        if ($result['status'] !== 'succeeded' && $result['status'] !== 'success') {
            return back()->withErrors('Payment failed');
        }

        $payment = Payment::create([
            'student_id' => $debt->student_id,
            'debt_id' => $debt->id,
            'amount_paid' => $debt->amount,
            'transaction_id' => $result['transaction_id'],
            'payment_gateway' => env('PAYMENT_GATEWAY', 'dummy'),
            'status' => 'success',
            'paid_at' => now(),
        ]);

        $debt->update(['is_paid' => true]);

        $invoice = Invoice::create([
            'payment_id' => $payment->id,
            'invoice_no' => uniqid('INV-'),
            'pdf_path' => '',
        ]);

        $invoiceService = new InvoiceService();
        $invoicePath = $invoiceService->generate($payment);
        $invoice->update(['pdf_path' => $invoicePath]);

        $payment->load('invoice');
        $logo = new LogoAccountingService();
        $logo->sendPayment($payment);

        return redirect()->route('invoices.show', $invoice)->with('status', 'Payment successful');
    }
}
