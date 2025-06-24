@extends('layout')

@section('content')
<div class="container">
    <h2>{{ $student->user->name }}</h2>
    <p>Öğrenci No: {{ $student->student_number }}</p>
    <p>Bölüm: {{ $student->department }}</p>
    <p>Sınıf: {{ $student->class }}</p>
    <a href="{{ route('students.edit', $student) }}" class="btn btn-warning">Düzenle</a>
    <form method="POST" action="{{ route('students.destroy', $student) }}" class="d-inline">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">Sil</button>
    </form>
    <hr>
    <a href="{{ route('students.debts', $student) }}" class="btn btn-secondary">Borçları Görüntüle</a>
</div>
@endsection
