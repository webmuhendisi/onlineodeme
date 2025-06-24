@extends('layout')

@section('content')
<div class="container">
    <h2>{{ $student->user->name }} - Borçlar</h2>
    <a href="{{ route('students.debts.create', $student) }}" class="btn btn-primary mb-3">Yeni Borç</a>
    <table class="table">
        <thead>
            <tr>
                <th>Tip</th>
                <th>Tutar</th>
                <th>Son Ödeme</th>
                <th>Taksit</th>
                <th>Durum</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($debts as $debt)
            <tr>
                <td>{{ $debt->type }}</td>
                <td>{{ $debt->amount }}</td>
                <td>{{ $debt->due_date->format('Y-m-d') }}</td>
                <td>{{ $debt->installments_paid }} / {{ $debt->installment_count }}</td>
                <td>{{ $debt->is_paid ? 'Ödendi' : 'Bekleniyor' }}</td>
                <td>
                    @if(!$debt->is_paid)
                    <form method="POST" action="{{ route('debts.pay', $debt) }}" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm">Öde</button>
                    </form>
                    @endif
                    <form method="POST" action="{{ route('debts.destroy', $debt) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Sil</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
