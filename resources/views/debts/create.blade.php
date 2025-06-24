@extends('layout')

@section('content')
<div class="container">
    <h2>Yeni Borç</h2>
    <form method="POST" action="{{ route('students.debts.store', $student) }}">
        @csrf
        <div class="mb-3">
            <label>Tip</label>
            <input type="text" name="type" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tutar</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Taksit Sayısı</label>
            <input type="number" name="installment_count" value="1" min="1" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Son Ödeme Tarihi</label>
            <input type="date" name="due_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Kaydet</button>
    </form>
</div>
@endsection
