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
        if ($debt->is_paid) {
            return back()->withErrors('Debt already paid');
        }

        $installmentAmount = $debt->amount / $debt->installment_count;

        $gateway = GatewayFactory::make();
        $result = $gateway->charge($installmentAmount, [
            'description' => 'Debt #' . $debt->id . ' installment',
        ]);

        if ($result['status'] !== 'succeeded' && $result['status'] !== 'success') {
            return back()->withErrors('Payment failed');
        }

        $installmentNo = $debt->installments_paid + 1;

        $payment = Payment::create([
            'student_id' => $debt->student_id,
            'debt_id' => $debt->id,
            'amount_paid' => $installmentAmount,
            'installment_no' => $installmentNo,
            'transaction_id' => $result['transaction_id'],
            'payment_gateway' => env('PAYMENT_GATEWAY', 'dummy'),
            'status' => 'success',
            'paid_at' => now(),
        ]);

        $debt->increment('installments_paid');
        if ($debt->installments_paid >= $debt->installment_count) {
            $debt->update(['is_paid' => true]);
        }

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
