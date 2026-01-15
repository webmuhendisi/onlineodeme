<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {
        $this->requireAuth();
        if (Auth::user()->role !== 'admin' && Auth::id() !== optional($invoice->payment->student)->user_id) {
            abort(403);
        }
        $fullPath = storage_path('app/' . $invoice->pdf_path);
        if (is_file($fullPath)) {
            return response()->file($fullPath);
        }

        return view('invoices.show', compact('invoice'));
    }

    public function generate(Payment $payment)
    {
        // Deprecated by PaymentController::store
        return redirect()->route('invoices.show', $payment->invoice);
    }
}
