@extends('layout')

@section('content')
<div class="container">
    <h2>Fatura {{ $invoice->invoice_no }}</h2>
    <p><a href="/{{ $invoice->pdf_path }}" target="_blank">PDF Indir</a></p>
</div>
@endsection
