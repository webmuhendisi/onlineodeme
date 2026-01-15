@extends('layout')

@section('content')
<div class="container">
    <h2>Fatura {{ $invoice->invoice_no }}</h2>
    <p>Tutar: {{ $invoice->payment->amount_paid }} {{ $invoice->payment->currency }}</p>
    <p>Taksit: {{ $invoice->payment->installment_no }} / {{ $invoice->payment->debt->installment_count }}</p>
    <p><a href="/{{ $invoice->pdf_path }}" target="_blank">PDF Indir</a></p>
</div>
@endsection
